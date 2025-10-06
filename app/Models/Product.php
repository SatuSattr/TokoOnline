<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'disc_price',
        'images',
        'main_image',
        'description',
        'rating',
        'reviews',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the category name attribute.
     */
    public function getCategoryNameAttribute(): string
    {
        return $this->category ? $this->category->name : '';
    }

    /**
     * Get the category display name attribute.
     */
    public function getCategoryDisplayNameAttribute(): string
    {
        return $this->category ? $this->category->display_name : '';
    }
    
    /**
     * Get the cart items for this product.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
    
    /**
     * Accessor for images attribute
     */
    public function getImagesAttribute(): array
    {
        $images = $this->attributes['images'] ?? '[]';
        $imagesArray = is_string($images) ? json_decode($images, true) : $images;
        return is_array($imagesArray) ? $imagesArray : [];
    }
    
    /**
     * Mutator for images attribute
     */
    public function setImagesAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['images'] = json_encode($value);
        } elseif (is_string($value)) {
            // If it's already a JSON string, validate it
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $this->attributes['images'] = $value;
            } else {
                $this->attributes['images'] = json_encode([$value]);
            }
        } else {
            $this->attributes['images'] = null;
        }
    }
    
    /**
     * Get the main image path
     */
    public function getMainImageAttribute(): ?string
    {
        return $this->attributes['main_image'] ?? null;
    }
    
    /**
     * Get the first image as fallback if main image is not set
     */
    public function getFirstImageAttribute(): ?string
    {
        if ($this->main_image) {
            return $this->main_image;
        }
        
        $images = $this->images;
        return !empty($images) ? $images[0] : null;
    }
    
    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute(): float
    {
        if ($this->disc_price && $this->price > 0) {
            return round((($this->price - $this->disc_price) / $this->price) * 100, 2);
        }
        return 0;
    }
    
    /**
     * Get formatted disc price attribute.
     */
    public function getFormattedDiscPriceAttribute(): string
    {
        if ($this->disc_price) {
            return 'Rp' . number_format($this->disc_price, 0, ',', '.');
        }
        return $this->getFormattedPriceAttribute();
    }
    
    /**
     * Delete associated images when product is deleted
     */
    public static function boot()
    {
        parent::boot();
        
        static::deleted(function ($product) {
            $product->deleteAssociatedImages();
        });
    }
    
    /**
     * Delete associated images from storage
     */
    public function deleteAssociatedImages()
    {
        $images = $this->images;
        if (is_array($images)) {
            foreach ($images as $image) {
                // Convert URL path to storage path
                $storagePath = str_replace('/storage/', 'public/', $image);
                $fullPath = storage_path('app/' . $storagePath);
                
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }
    }
    
    /**
     * Format price to Indonesian Rupiah.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }
}
