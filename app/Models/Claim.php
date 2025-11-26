<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Claim extends Model
{
    use HasFactory;
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function fooditems()
    {
        return $this->belongsTo(FoodItem::class);
    }
}
