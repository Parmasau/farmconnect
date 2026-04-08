<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    
    protected $fillable = [
        'user_id', 'farmer_id', 'category_id', 'name', 'slug', 'description', 
        'price', 'quantity', 'unit', 'image', 'status', 'product_type', 'category'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relationship with seller (could be farmer or agrovet)
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-product.jpg');
    }

    public function getFormattedPriceAttribute()
    {
        return 'KSh ' . number_format($this->price, 2);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isAvailable()
    {
        return $this->status === 'active' && $this->quantity > 0;
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