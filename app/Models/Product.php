<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Remove SoftDeletes - comment this line
// use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    // Remove SoftDeletes trait - comment this line
    // use SoftDeletes;

    protected $table = 'products';
    
    protected $fillable = [
        'user_id', 'farmer_id', 'category_id', 'name', 'slug', 'description', 
        'price', 'quantity', 'unit', 'image', 'status', 'product_type', 'category'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relationship with farmer/agrovet (seller)
    public function farmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-product.jpg');
    }

    public function getFormattedPriceAttribute()
    {
        return 'KSh ' . number_format($this->price, 2);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isAvailable()
    {
        return $this->status === 'active' && $this->quantity > 0;
    }

    public function getStatusTextAttribute()
    {
        return $this->status === 'active' ? 'Available' : ucfirst($this->status);
    }

    public function reduceStock($quantity)
    {
        if ($this->quantity >= $quantity) {
            $this->quantity -= $quantity;
            if ($this->quantity == 0) {
                $this->status = 'out_of_stock';
            }
            $this->save();
            return true;
        }
        return false;
    }
}