<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-files');
    }
}
