<?php

namespace App\Enums\Task;

enum StatusEnum: int
{
    case PENDING = 1;
    case PROCESSING = 2;
    case COMPLETED = 3;
    case FAILED = 4;
    case CANCELLED = 5;

    public static function getLabel(?int $value = null): string
    {
        return match ($value) {
            self::PENDING->value => "Bekliyor",
            self::PROCESSING->value => "İşlemde",
            self::COMPLETED->value => "Tamamlandı",
            self::FAILED->value => "Başarısız",
            self::CANCELLED->value => "İptal",
            default => 'Bilinmiyor',
        };
    }
}
