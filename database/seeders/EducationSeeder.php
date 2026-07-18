<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\EducationItem;
use Illuminate\Database\Seeder;

final class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'key'            => 'damascus-hotel-management',
                'institution_ar' => 'جامعة دمشق — كلية السياحة',
                'institution_en' => 'Damascus University — Faculty of Tourism',
                'credential_ar'  => 'بكالوريوس',
                'credential_en'  => 'B.Sc.',
                'field_ar'       => 'إدارة الفنادق',
                'field_en'       => 'Hotel Management',
                'grade_ar'       => 'جيّد',
                'grade_en'       => 'Good',
                'completed_on'   => '2025-09-01',
            ],
            [
                'key'            => 'gilgamesh-culinary',
                'institution_ar' => 'مركز جلجامش',
                'institution_en' => 'Gilgamesh Center',
                'credential_ar'  => 'دبلوم',
                'credential_en'  => 'Diploma',
                'field_ar'       => 'فنون الطهي والحلويات',
                'field_en'       => 'Culinary Arts & Pastry',
                'grade_ar'       => 'جيّد',
                'grade_en'       => 'Good',
                'completed_on'   => '2025-07-01',
            ],
        ];

        foreach ($items as $index => $item) {
            EducationItem::query()->updateOrCreate(
                ['key' => $item['key']],
                [...$item, 'sort_order' => $index + 1],
            );
        }
    }
}
