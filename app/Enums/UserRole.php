<?php

namespace App\Enums;

enum UserRole: string
{
    case GARCOM   = 'garcom';
    case CAIXA    = 'caixa';
    case DONO     = 'dono';
    case CLIENTE  = 'cliente';
    case ADMIN    = 'admin'; // Administrador do sistema (nós)

    /**
     * Nome legível para exibição
     */
    public function label(): string
    {
        return match ($this) {
            self::GARCOM  => 'Garçom',
            self::CAIXA   => 'Caixa',
            self::DONO    => 'Dono do Restaurante',
            self::CLIENTE => 'Cliente',
            self::ADMIN   => 'Administrador do Sistema',
        };
    }

    /**
     * Retorna lista com todas as opções para select/input
     */
    public static function options(): array
    {
        return array_map(
            fn(self $case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
