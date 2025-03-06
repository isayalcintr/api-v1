<?php

namespace App\Enums;

enum ModuleEnum: int
{
    case TASK = 100;
    case USER = 1000;

    public static function getLabel(?int $value = null): string
    {
        return match ($value) {
            self::TASK->value => "Görev",
            self::USER->value => "Kullanıcı",
            default => 'Bilinmiyor',
        };
    }
}
