<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\Process;
use Illuminate\View\Component;

class DevLoginBar extends Component
{
    public array $users;

    public string $env;

    public string $branch;

    public function __construct()
    {
        // Apenas carregar usuários se NÃO estiver em produção
        $this->users = app()->environment('production') ? [] : User::all()->toArray();
        $this->env = config('app.env');
        $this->branch = trim(Process::run('git branch --show-current')->output());
    }

    public function render()
    {
        return view('components.dev-login-bar');
    }
}
