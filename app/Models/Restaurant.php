<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'cnpj',
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'is_active',
    ];
    /**
     * Usuários vinculados ao restaurante com seus respectivos cargos (roles).
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Donos do restaurante.
     */
    public function owners(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'dono');
    }

    /**
     * Garçons do restaurante.
     */
    public function waiters(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'garcom');
    }

    /**
     * Caixas do restaurante.
     */
    public function cashiers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'caixa');
    }
}
