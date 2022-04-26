<?php

namespace App\Enums;

enum FilesPaths: string
{
    case Attachments = "Attachments/" ;

    public static function asArray(): array
    {
        return array_map(fn($x) => $x->value, self::cases());
    }
}
