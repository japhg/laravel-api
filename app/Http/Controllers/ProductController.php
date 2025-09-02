<?php
namespace App\Http\Controllers;

use App\Enums\Product\CategoryEnum;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{

    public function __construct(protected ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $search            = $request->input('search');
        $per_page          = $request->input('per_page', 10);
        $productCategories = CategoryEnum::toOptions();
        $products          = $this->productService->product
            ->with('media')
            ->when($request->has('search'), fn($query) => $query->where('name', 'like', "%$search%")->orWhere('description', 'like', "%$search%"))
            ->when($request->has('category'), fn($query) => $query->where('category', $request->input('category')))
            ->orderBy('created_at', 'desc')
            ->paginate($per_page)
            ->withQueryString();

        return response()->json([
            'products'          => $products,
            'productCategories' => $productCategories,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $this->productService->store($request);
            return response()->json(['message' => 'Product stored successfully']);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422); // Unprocessable Entity
        } catch (\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400); // Bad Request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): JsonResponse
    {
        $product = $this->productService->product
            ->with('media')
            ->findOrFail($id);

        return response()->json([
            'product' => $product,
            'media'   => $product->getMedia('product-files')->map(function ($media) {
                return [
                    'id'   => $media->id,
                    'name' => $media->name,
                    'url'  => $media->getUrl(),
                ];
            }),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, int $id): JsonResponse
    {
        try {
            $this->productService->update($request, $id);
            return response()->json(['message' => 'Product updated successfully']);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422); // Unprocessable Entity
        } catch (\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400); // Bad Request
        }
    }

    public function destroyMedia(Media $media): JsonResponse
    {
        $media->delete();
        return response()->json(['message' => 'Media deleted successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $product = $this->productService->product->find($id);

            if (! $product) {
                throw new \Exception('Product not found!');
            }

            $product->delete();

            return response()->json(['message' => 'Product deleted successfully']);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422); // Unprocessable Entity
        } catch (\DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400); // Bad Request
        }
    }
}
