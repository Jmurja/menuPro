<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index()
    {
        $items = MenuItem::latest()->get();
        return view('menu.index', compact('items'));
    }

    public function show($id)
    {
        $item = MenuItem::findOrFail($id);
        return view('menu.show', compact('item'));
    }
}

