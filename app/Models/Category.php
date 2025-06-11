<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('menu.create', compact('categories'));
    }
}
