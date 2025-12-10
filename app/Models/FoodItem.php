<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'photo',
        'quantity',
        'pickup_location',
        'pickup_time',
        'expires_at',
        'status',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class, 'food_id');
    }
}
