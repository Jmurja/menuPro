<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'category_id',
        'is_active',
        'stock_quantity',
        'availability_start_time',
        'availability_end_time'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
