<?php

declare(strict_types=1);

namespace App\Enums;

enum ContentTypes: int
{
    case CONTENT = 1;
    case T = 2;
    case IMAGE = 3;

    /**
     * @param  ?array<int, int>  $filters
     * @return array<int|string, int|string>
     */
    public static function list(bool $with_label = true, ?array $filters = null): array
    {
        $array = [
            self::T->value => 'Titre',
            self::CONTENT->value => 'Contenu',
            self::IMAGE->value => 'Image',
        ];

        if ($filters !== null) {
            $array = array_filter($array, function ($value) use ($filters) {
                return in_array($value, $filters, true);
            }, ARRAY_FILTER_USE_KEY);
        }

        return ($with_label) ? $array : array_keys($array);
    }

    /**
     * @return array<int, int>
     */
    public static function contents(): array
    {
        return [self::CONTENT, self::T, self::IMAGE];
    }

    /**
     * @return array<int|string, int|string>
     */
    public static function listForContents(bool $with_label = true): array
    {
        return self::list($with_label, self::contents());
    }

    public static function label(int $key): null|int|string
    {
        return self::list()[$key] ?? null;
    }
}
