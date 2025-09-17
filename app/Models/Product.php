<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'date_and_time',
    ];

    protected $casts = [
        'date_and_time' => 'datetime',
    ];

    #[Scope()]
    protected static function search(Builder $query, string $keyword): Builder
    {
        return $query->where('name', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%");
    }

    #[Scope()]
    protected static function filterByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-files');
    }
}
