<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

final class Metric extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'value',
        'suffix',
        'label_ar',
        'label_en',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'value'      => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
