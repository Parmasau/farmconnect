<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'business_name',
        'address',
        'profile_photo',
        'bio',
        'is_active',
        'last_seen',
        'mpesa_number', // Added M-Pesa number field for farmers
        'till_number'   // Added Till/Paybill number field for agrovets
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'last_seen' => 'datetime',
    ];

    // Role checks
    public function isFarmer()
    {
        return $this->role === 'farmer';
    }

    public function isAgrovet()
    {
        return $this->role === 'agrovet';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Products
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function availableProducts()
    {
        return $this->products()->where('status', 'available')->where('quantity', '>', 0);
    }

    // Orders
    public function purchases()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function sales()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    // Consultations
    public function consultationsAsFarmer()
    {
        return $this->hasMany(Consultation::class, 'farmer_id');
    }

    public function consultationsAsAgrovet()
    {
        return $this->hasMany(Consultation::class, 'agrovet_id');
    }

    // Advice
    public function adviceRequests()
    {
        return $this->hasMany(AdviceRequest::class, 'farmer_id');
    }

    public function assignedAdvice()
    {
        return $this->hasMany(AdviceRequest::class, 'assigned_agrovet_id');
    }

    // Messages
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    
    // Custom notification helper methods (using different names to avoid conflict)
    public function createNotification($title, $message, $type, $data = [])
    {
        return Notification::create([
            'user_id' => $this->id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
        ]);
    }
    
    public function getUnreadNotificationsCount()
    {
        return Notification::where('user_id', $this->id)->where('is_read', false)->count();
    }
    
    /**
     * Get formatted M-Pesa number
     * Converts 0712345678 to 254712345678
     */
    public function getMpesaNumberAttribute($value)
    {
        if ($value) {
            // Remove any non-numeric characters
            $number = preg_replace('/[^0-9]/', '', $value);
            
            // If starts with 0, replace with 254
            if (substr($number, 0, 1) === '0') {
                $number = '254' . substr($number, 1);
            }
            // If starts with 254, keep as is
            elseif (substr($number, 0, 3) === '254') {
                $number = $number;
            }
            // If starts with 7, add 254
            elseif (substr($number, 0, 1) === '7') {
                $number = '254' . $number;
            }
            
            return $number;
        }
        return null;
    }
    
    /**
     * Get raw M-Pesa number for display
     */
    public function getRawMpesaNumberAttribute()
    {
        if ($this->mpesa_number) {
            $number = preg_replace('/[^0-9]/', '', $this->mpesa_number);
            // Format as 07XXXXXXXX for display
            if (substr($number, 0, 3) === '254') {
                $number = '0' . substr($number, 3);
            }
            return $number;
        }
        return null;
    }
    
    /**
     * Get formatted Till Number
     */
    public function getTillNumberAttribute($value)
    {
        if ($value) {
            // Remove any non-numeric characters
            return preg_replace('/[^0-9]/', '', $value);
        }
        return null;
    }
    
    /**
     * Get masked Till Number for display
     */
    public function getMaskedTillNumberAttribute()
    {
        if ($this->till_number) {
            $length = strlen($this->till_number);
            if ($length > 4) {
                return str_repeat('*', $length - 4) . substr($this->till_number, -4);
            }
            return $this->till_number;
        }
        return 'Not set';
    }
}