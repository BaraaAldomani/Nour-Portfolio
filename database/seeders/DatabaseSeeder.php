<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeds the full content inventory.
 *
 * Run by hand on a first deploy only. The deploy pipeline never calls this --
 * re-seeding a live site would overwrite everything edited in the dashboard.
 *
 * Note there is no WithoutModelEvents here on purpose: the ContentObserver
 * should fire so the site cache is flushed once seeding finishes.
 */
final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            DishSeeder::class,
            ServiceSeeder::class,
            ExperienceSeeder::class,
            EducationSeeder::class,
            SkillSeeder::class,
            MetricSeeder::class,
            ProcessStepSeeder::class,
        ]);
    }
}
