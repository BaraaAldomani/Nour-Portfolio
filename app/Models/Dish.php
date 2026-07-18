<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

final class Dish extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'image',
        'title_ar',
        'title_en',
        'category_ar',
        'category_en',
        'description_ar',
        'description_en',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'sort_order'  => 'integer',
        ];
    }

    /**
     * A resolved public URL, whether the image was seeded into public/images or
     * uploaded through the dashboard onto the public disk.
     */
    public function imageUrl(): string
    {
        return image_url($this->image);
    }
}
