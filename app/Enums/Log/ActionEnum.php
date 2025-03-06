<?php

namespace App\Enums\Log;

enum ActionEnum: int
{
    case INSERT = 1;
    case UPDATE = 2;
    case DELETE = 3;

    public static function getLabel(?int $value = null): string
    {
        return match ($value) {
            self::INSERT->value => "Ekle",
            self::UPDATE->value => "Güncelle",
            self::DELETE->value => "Sil",
            default => 'Bilinmiyor',
        };
    }

}
