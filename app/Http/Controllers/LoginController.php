<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // 🚀 Impede acesso em produção
        if (app()->environment('production')) {
            abort(404);
        }

        // 🚀 Garante que um usuário foi selecionado
        $userId = $request->user;

        if (! $userId) {
            return redirect()->back()->with('error', 'Usuário inválido');
        }

        // 🚀 Busca o usuário, tratando possíveis erros
        $user = User::find($userId);

        if (! $user) {
            return redirect()->back()->with('error', 'Usuário não encontrado');
        }

        // 🚀 Faz login e redireciona para o dashboard
        auth()->login($user);

        return redirect()->route('menu');
    }
}
