<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

final class Service extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'icon',
        'title_ar',
        'title_en',
        'summary_ar',
        'summary_en',
        'description_ar',
        'description_en',
        'features_ar',
        'features_en',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'features_ar' => 'array',
            'features_en' => 'array',
            'sort_order'  => 'integer',
        ];
    }

    /**
     * @return array<int, string>
     */
    public function features(): array
    {
        return $this->localizedArray('features');
    }
}
