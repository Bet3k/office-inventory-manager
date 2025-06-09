<?php

declare(strict_types=1);

namespace App\Enums;

enum GenderEnum: string
{
    /**
     * Acceptable gender values.
     */
    case FEMALE = 'female';
    case MALE = 'male';
    case OTHERS = 'others';

    /**
     * @return array<string>
     */
    public static function getValues(): array
    {
        return array_map(fn ($enum) => $enum->value, self::cases());
    }
}
