<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use App\Support\SettingsDefaults;
use Illuminate\Database\Seeder;

/**
 * Materialises SettingsDefaults into rows.
 *
 * updateOrCreate keyed on (group, key) means re-running the seeder is safe and
 * never duplicates, but note the deploy pipeline deliberately does NOT run
 * seeders -- doing so would overwrite dashboard edits.
 */
final class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SettingsDefaults::all() as $group => $entries) {
            foreach ($entries as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['group' => $group, 'key' => $key],
                    ['value' => $value],
                );
            }
        }
    }
}
