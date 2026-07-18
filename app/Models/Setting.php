<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A single piece of singleton site copy, addressed by (group, key).
 *
 * Defaults live in App\Support\SettingsDefaults; a row here only exists once
 * the value has been seeded or edited in the dashboard.
 */
final class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }
}
