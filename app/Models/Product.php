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
        'image',
        'image2',
        'image3',
        'image4',
        'image5',
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
     * Get all images as an array for compatibility
     */
    public function getImagesAttribute(): array
    {
        $images = [];
        for ($i = 1; $i <= 5; $i++) {
            $imageFieldName = $i === 1 ? 'image' : "image$i";
            $imageValue = $this->attributes[$imageFieldName] ?? null;
            if ($imageValue) {
                $images[] = $imageValue;
            }
        }
        return $images;
    }
    
    /**
     * Get the primary image
     */
    public function getMainImageAttribute(): ?string
    {
        return $this->attributes['image'] ?? null;
    }
    
    /**
     * Get the first available image (the primary image)
     */
    public function getFirstImageAttribute(): ?string
    {
        return $this->attributes['image'] ?? null;
    }
    
    /**
     * Get image2 if it exists
     */
    public function getImage2Attribute(): ?string
    {
        return $this->attributes['image2'] ?? null;
    }
    
    /**
     * Get image3 if it exists
     */
    public function getImage3Attribute(): ?string
    {
        return $this->attributes['image3'] ?? null;
    }
    
    /**
     * Get image4 if it exists
     */
    public function getImage4Attribute(): ?string
    {
        return $this->attributes['image4'] ?? null;
    }
    
    /**
     * Get image5 if it exists
     */
    public function getImage5Attribute(): ?string
    {
        return $this->attributes['image5'] ?? null;
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
        // Delete all 5 image columns if they exist
        for ($i = 1; $i <= 5; $i++) {
            $imageFieldName = $i === 1 ? 'image' : "image$i";
            $image = $this->attributes[$imageFieldName] ?? null;
            
            if ($image) {
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