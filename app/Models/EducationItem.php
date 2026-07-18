<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

final class EducationItem extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'institution_ar',
        'institution_en',
        'credential_ar',
        'credential_en',
        'field_ar',
        'field_en',
        'grade_ar',
        'grade_en',
        'completed_on',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'completed_on' => 'date',
            'sort_order'   => 'integer',
        ];
    }

    public function completedLabel(): string
    {
        return $this->completed_on?->format('m/Y') ?? '';
    }
}
