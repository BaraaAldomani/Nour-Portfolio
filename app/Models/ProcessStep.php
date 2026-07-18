<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

final class ProcessStep extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }
}
