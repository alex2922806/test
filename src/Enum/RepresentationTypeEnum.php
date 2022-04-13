<?php

namespace App\Enum;

enum RepresentationTypeEnum: string
{
    case JSON = 'json';
    case CSV = 'csv';
    case YAML = 'yaml';

    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $enum) {
            $values[] = $enum->value ?? $enum->name;
        }

        return $values;
    }
}