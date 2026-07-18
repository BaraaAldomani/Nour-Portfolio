<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Metric;
use Illuminate\Database\Seeder;

/**
 * Deliberately conservative numbers. Every one of these is defensible straight
 * from the CV -- an inflated stat on a hiring-facing site is a liability.
 */
final class MetricSeeder extends Seeder
{
    public function run(): void
    {
        $metrics = [
            ['years-experience', 2,  '+', 'سنوات في مطابخ احترافية', 'Years in professional kitchens'],
            ['kitchens',         3,  null, 'مطابخ عملت فيها',         'Kitchens worked'],
            ['dishes',           14, null, 'أطباق في المعرض',         'Dishes in the portfolio'],
            ['standards',        2,  null, 'أنظمة سلامة غذاء',        'Food-safety systems'],
        ];

        foreach ($metrics as $index => [$key, $value, $suffix, $labelAr, $labelEn]) {
            Metric::query()->updateOrCreate(
                ['key' => $key],
                [
                    'value'      => $value,
                    'suffix'     => $suffix,
                    'label_ar'   => $labelAr,
                    'label_en'   => $labelEn,
                    'sort_order' => $index + 1,
                ],
            );
        }
    }
}
