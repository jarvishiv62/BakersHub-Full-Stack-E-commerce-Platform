<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
        'rating',
        'reviews_count'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'reviews_count' => 'integer'
    ];

    /**
     * Get the URL for the product's image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('images/placeholder.jpg');
        }
        
        // Check if the image is a full URL (for seeded data)
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Check if the image exists in the public directory (for seeded images)
        if (file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        
        // Otherwise, assume it's in the storage directory
        return asset('storage/' . $this->image);
    }
}
