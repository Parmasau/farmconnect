<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['image_url', 'formatted_price', 'stock_status'];

    // ========== RELATIONSHIPS ==========
    
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function owner()
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

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // ========== ACCESSORS ==========

    /**
     * Get the product image URL - FIXED VERSION
     */
    public function getImageUrlAttribute()
    {
        // If no image is stored
        if (!$this->image) {
            return $this->getDefaultImage();
        }
        
        // If it's already a full URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Check if file exists in storage
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        
        // Return default image if file doesn't exist
        return $this->getDefaultImage();
    }

    /**
     * Get default image based on category
     */
    protected function getDefaultImage()
    {
        // You can customize these default images
        $defaultImages = [
            'seed' => '/images/defaults/seeds.jpg',
            'fertilizer' => '/images/defaults/fertilizer.jpg',
            'pesticide' => '/images/defaults/pesticide.jpg',
            'tool' => '/images/defaults/tools.jpg',
            'equipment' => '/images/defaults/equipment.jpg',
            'default' => '/images/defaults/product.jpg',
        ];
        
        // Return a placeholder if no category match
        return 'https://via.placeholder.com/400x300?text=No+Image';
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'KSh ' . number_format($this->price, 2);
    }

    /**
     * Get stock status
     */
    public function getStockStatusAttribute()
    {
        if ($this->quantity <= 0) {
            return ['text' => 'Out of Stock', 'badge' => 'bg-red-500'];
        } elseif ($this->quantity <= 5) {
            return ['text' => 'Low Stock', 'badge' => 'bg-yellow-500'];
        } elseif ($this->quantity <= 10) {
            return ['text' => 'Limited Stock', 'badge' => 'bg-blue-500'];
        } else {
            return ['text' => 'In Stock', 'badge' => 'bg-green-500'];
        }
    }

    public function getStockStatusTextAttribute()
    {
        return $this->stock_status['text'];
    }

    public function getStockStatusBadgeAttribute()
    {
        return $this->stock_status['badge'];
    }

    // ========== SCOPES ==========

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')->where('quantity', '>', 0);
    }

    public function scopeForFarmer($query, $farmerId)
    {
        return $query->where('farmer_id', $farmerId);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('name', 'like', "%{$searchTerm}%")
                     ->orWhere('description', 'like', "%{$searchTerm}%");
    }

    // ========== BUSINESS LOGIC ==========

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

    public function increaseStock($quantity)
    {
        $this->quantity += $quantity;
        if ($this->status === 'out_of_stock' && $this->quantity > 0) {
            $this->status = 'active';
        }
        $this->save();
        return true;
    }
}