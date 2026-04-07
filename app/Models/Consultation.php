<?php
// app/Models/Consultation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id', 'agrovet_id', 'topic', 'description', 'type',
        'status', 'response', 'scheduled_at', 'responded_at'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function agrovet()
    {
        return $this->belongsTo(User::class, 'agrovet_id');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}