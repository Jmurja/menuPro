<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'cpf' => ['nullable', 'unique:users,cpf'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'role'     => ['required', 'in:' . implode(',', array_column(UserRole::cases(), 'value'))],
            'phone'    => ['nullable', 'string', 'max:20'],
            'is_active'=> ['nullable'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');
        $validated['phone'] = $validated['phone']
            ? preg_replace('/\D/', '', $validated['phone'])
            : null;
        $validated['cpf'] = isset($validated['cpf'])
            ? preg_replace('/\D/', '', $validated['cpf'])
            : null;

        User::create($validated);

        return redirect()->back()->with('success', 'Usuário cadastrado com sucesso.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'cpf' => ['nullable', 'unique:users,cpf,' . $user->id],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'     => ['required', 'in:' . implode(',', array_column(UserRole::cases(), 'value'))],
            'phone'    => ['nullable', 'string', 'max:20'],
            'is_active'=> ['nullable', 'boolean'],
        ]);

        $validated['cpf'] = isset($validated['cpf'])
            ? preg_replace('/\D/', '', $validated['cpf'])
            : null;
        $validated['is_active'] = $request->has('is_active');
        $validated['phone'] = $validated['phone']
            ? preg_replace('/\D/', '', $validated['phone'])
            : null;
        $user->update($validated);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Usuário excluído.');
    }
}
