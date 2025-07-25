<?php
namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use Illuminate\Validation\Rule;

class MyRestaurantController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $restaurants = $user->restaurants()->orderBy('name')->get();

        return view('owner.index', compact('restaurants'));
    }

    public function storeEmployee(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => ['required', Rule::in(['garcom', 'caixa'])],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => $validated['role'],
            'is_active'=> true,
        ]);

        $restaurant->users()->attach($user->id);

        return redirect()->back()->with('success', 'Funcionário cadastrado com sucesso.');
    }

    public function updateEmployee(Request $request, Restaurant $restaurant, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role'  => ['required', Rule::in(['garcom', 'caixa'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user->update([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'role'      => $validated['role'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Funcionário atualizado com sucesso.');
    }

    public function destroyEmployee(Restaurant $restaurant, User $user)
    {
        if (!$restaurant->users->contains($user->id)) {
            abort(403, 'Funcionário não pertence a este restaurante.');
        }

        // Remove o vínculo
//        $restaurant->users()->detach($user->id);

        // Opcional: deletar o usuário completamente
         $user->delete();

        return redirect()->back()->with('success', 'Funcionário removido com sucesso.');
    }


    public function show(Restaurant $restaurant)
    {

        return view('owner.show', compact('restaurant'));
    }
}
