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

    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'cnpj'         => ['nullable', Rule::unique('restaurants', 'cnpj')->ignore($restaurant->id)],
            'phone'        => ['nullable', 'string', 'max:20'],
            'zip_code'     => ['nullable', 'string', 'max:9'],
            'street'       => ['nullable', 'string', 'max:255'],
            'number'       => ['nullable', 'string', 'max:50'],
            'complement'   => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['nullable', 'string', 'max:255'],
            'city'         => ['nullable', 'string', 'max:255'],
            'state'        => ['nullable', 'string', 'size:2'],
            'is_active'    => ['nullable', 'boolean'],
            'user_id'      => ['required', 'exists:users,id'],
        ]);

        $validated['zip_code'] = isset($validated['zip_code'])
            ? preg_replace('/\D/', '', $validated['zip_code'])
            : null;
        $validated['cnpj'] = isset($validated['cnpj'])
            ? preg_replace('/\D/', '', $validated['cnpj'])
            : null;

        $restaurant->update([
            'name'         => $validated['name'],
            'cnpj'         => $validated['cnpj'] ?? null,
            'phone'        => $validated['phone'] ?? null,
            'zip_code'     => $validated['zip_code'] ?? null,
            'street'       => $validated['street'] ?? null,
            'number'       => $validated['number'] ?? null,
            'complement'   => $validated['complement'] ?? null,
            'neighborhood' => $validated['neighborhood'] ?? null,
            'city'         => $validated['city'] ?? null,
            'state'        => $validated['state'] ?? null,
            'is_active'    => $request->has('is_active'),
        ]);

        $restaurant->users()->sync([$validated['user_id']]);

        return redirect()->back()->with('success', 'Restaurante atualizado com sucesso.');
    }
}
