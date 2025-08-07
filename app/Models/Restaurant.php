<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'cnpj',
        'phone',
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
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
