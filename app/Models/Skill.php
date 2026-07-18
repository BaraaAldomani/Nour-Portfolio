<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SkillCategory;
use App\Support\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

final class Skill extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'name_ar',
        'name_en',
        'category',
        'level',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'category'   => SkillCategory::class,
            'level'      => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
