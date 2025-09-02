<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function __construct(public Product $product)
    {
        $this->product = $product;
    }

    public function store(Request $request): Product
    {
        $product = $this->product->create([
            'name'          => $request->name,
            'category'      => $request->category,
            'description'   => $request->description,
            'date_and_time' => $request->date_and_time,
        ]);

        if (! $product) {
            throw new \Exception('Error in creating product!');
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $product->addMedia($file)
                    ->toMediaCollection('product-files');
            }
        }

        return $product;
    }

    public function update(Request $request, int $id): Product
    {
        $product = $this->product->find($id);

        $product->update([
            'name'          => $request->name,
            'category'      => $request->category,
            'description'   => $request->description,
            'date_and_time' => $request->date_and_time,
        ]);

        if (! $product) {
            throw new \Exception('Error in creating product!');
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $product->addMedia($file)
                    ->toMediaCollection('product-files');
            }
        }

        return $product;
    }
}
