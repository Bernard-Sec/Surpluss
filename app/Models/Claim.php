<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_id',
        'receiver_id',
        'quantity',
        'status',
        'message',
    ];

    
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function fooditems()
    {
        return $this->belongsTo(FoodItem::class, 'food_id');
    }
}
