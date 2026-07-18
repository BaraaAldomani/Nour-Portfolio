<?php

declare(strict_types=1);

namespace App\Enums;

enum SkillCategory: string
{
    case Culinary   = 'culinary';
    case Management = 'management';
    case Safety     = 'safety';
    case Business   = 'business';

    /**
     * The localized group heading shown above each cluster of skills.
     */
    public function label(): string
    {
        return match ($this) {
            self::Culinary   => __('skills.culinary'),
            self::Management => __('skills.management'),
            self::Safety     => __('skills.safety'),
            self::Business   => __('skills.business'),
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_reduce(
            self::cases(),
            static function (array $carry, self $case): array {
                $carry[$case->value] = ucfirst($case->value);

                return $carry;
            },
            [],
        );
    }
}
