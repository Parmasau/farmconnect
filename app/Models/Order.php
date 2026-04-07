<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number', 'buyer_id', 'seller_id', 'total_amount', 'status', 'payment_status', 'delivery_address', 'notes'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($o) => $o->order_number = 'FC-' . strtoupper(uniqid()));
    }

    public function buyer()  { return $this->belongsTo(User::class, 'buyer_id'); }
    public function seller() { return $this->belongsTo(User::class, 'seller_id'); }
    public function items()  { return $this->hasMany(OrderItem::class); }

    public function scopeForUser($q, $userId)
    {
        return $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
    }
}
