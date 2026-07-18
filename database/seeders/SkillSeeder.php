<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SkillCategory;
use App\Models\Skill;
use Illuminate\Database\Seeder;

final class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            // Kitchen craft
            ['hot-kitchen',       'المطبخ الساخن',            'Hot kitchen',                 SkillCategory::Culinary,   5],
            ['cold-kitchen',      'المطبخ البارد والمقبّلات',  'Cold kitchen & garde manger', SkillCategory::Culinary,   5],
            ['pastry',            'الحلويات والمعجّنات',       'Pastry & baking',             SkillCategory::Culinary,   4],
            ['plating',           'التقديم والتنسيق',          'Plating & presentation',      SkillCategory::Culinary,   5],
            ['recipes',           'توحيد الوصفات',            'Recipe standardisation',      SkillCategory::Culinary,   4],

            // Leadership
            ['leadership',        'قيادة فريق المطبخ',         'Kitchen leadership',          SkillCategory::Management, 5],
            ['training',          'تدريب الموظفين',            'Staff training',              SkillCategory::Management, 4],
            ['scheduling',        'جداول العمل والحضور',       'Scheduling & attendance',     SkillCategory::Management, 4],
            ['inventory',         'المخزون والطلبات',          'Inventory & ordering',        SkillCategory::Management, 4],

            // Food safety
            ['haccp',             'نظام HACCP',               'HACCP',                       SkillCategory::Safety,     5],
            ['gmp',               'ممارسات التصنيع الجيّدة GMP', 'GMP',                       SkillCategory::Safety,     5],
            ['hygiene',           'النظافة الشخصية والمطبخ',   'Personal & kitchen hygiene',  SkillCategory::Safety,     5],

            // Cost & menu
            ['menu-engineering',  'هندسة القوائم',             'Menu engineering',            SkillCategory::Business,   4],
            ['food-cost',         'تكلفة الطعام والهدر',       'Food cost & waste control',   SkillCategory::Business,   4],
        ];

        foreach ($skills as $index => [$key, $nameAr, $nameEn, $category, $level]) {
            Skill::query()->updateOrCreate(
                ['key' => $key],
                [
                    'name_ar'    => $nameAr,
                    'name_en'    => $nameEn,
                    'category'   => $category,
                    'level'      => $level,
                    'sort_order' => $index + 1,
                ],
            );
        }
    }
}
