<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'description',
        'menu_item_id',
        'restaurant_id',
        'discount_price',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'discount_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2'
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
