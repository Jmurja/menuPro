<?php
namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class MyRestaurantController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $restaurants = $user->restaurants()->orderBy('name')->get();

        return view('owner.index', compact('restaurants'));
    }

    public function show(Restaurant $restaurant)
    {

        return view('owner.show', compact('restaurant'));
    }
}
