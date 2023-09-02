<?php

namespace App\Enums;

enum Stars: string
{
    case ONE = 'uma';

    case TWO = 'duas';

    case THREE = 'tres';

    case FOUR = 'quatro';

    case FIVE = 'cinco';

    public function int(): string
    {
        return static::getInt($this);
    }

    public static function getInt(self $value): string
    {
        return match ($value) {
            self::ONE => 1,
            self::TWO => 2,
            self::THREE => 3,
            self::FOUR => 4,
            self::FIVE => 5,
        };
    }

}
