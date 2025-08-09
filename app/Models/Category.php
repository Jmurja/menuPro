<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'restaurant_id', 'icon', 'offer_type', 'is_offer'];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
