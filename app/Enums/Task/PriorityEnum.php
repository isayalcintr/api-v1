<?php

namespace App\Enums\Task;

enum PriorityEnum: int
{
    case HIGH = 1;
    case NORMAL = 2;
    case LOW = 3;

    public static function getLabel(?int $value = null): string
    {
        return match ($value) {
            self::HIGH->value => "Yüksek",
            self::NORMAL->value => "Normal",
            self::LOW->value => "Düşük",
            default => 'Bilinmiyor',
        };
    }
}
