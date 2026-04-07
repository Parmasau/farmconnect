<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdviceRequest extends Model
{
    protected $fillable = ['farmer_id', 'agrovet_id', 'subject', 'message', 'response', 'status'];

    public function farmer()  { return $this->belongsTo(User::class, 'farmer_id'); }
    public function agrovet() { return $this->belongsTo(User::class, 'agrovet_id'); }
}
