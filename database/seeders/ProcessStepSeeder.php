<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ProcessStep;
use Illuminate\Database\Seeder;

final class ProcessStepSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [
            [
                'key'            => 'taste',
                'title_ar'       => 'التذوّق والتحليل',
                'title_en'       => 'Taste & analyse',
                'description_ar' => 'أبدأ من القائمة الحالية والمطبخ كما هو: ما الذي يُطلب فعلاً، وما الذي يُهدَر، وأين تضيع الدقائق في ساعة الذروة.',
                'description_en' => 'I start from the menu and the kitchen as they actually are: what really sells, what gets thrown away, and where the minutes disappear at peak hour.',
            ],
            [
                'key'            => 'design',
                'title_ar'       => 'تصميم القائمة',
                'title_en'       => 'Design the menu',
                'description_ar' => 'أعيد بناء الأصناف بحيث تتقاطع مع بعضها في المكوّنات والتحضير، فتقل التكلفة والهدر دون أن يشعر الضيف بأي تنازل.',
                'description_en' => 'I rebuild the dishes so they share ingredients and prep, which cuts cost and waste without the guest feeling a single compromise.',
            ],
            [
                'key'            => 'train',
                'title_ar'       => 'تدريب الفريق',
                'title_en'       => 'Train the team',
                'description_ar' => 'أكتب الوصفات بأوزانها وأدرّب الفريق عليها، حتى لا يعتمد مستوى الطبق على من يقف في المحطة تلك الليلة.',
                'description_en' => 'I write the recipes with their weights and train the team on them, so the standard of a plate never depends on who is on the station that night.',
            ],
            [
                'key'            => 'measure',
                'title_ar'       => 'المتابعة والقياس',
                'title_en'       => 'Monitor & measure',
                'description_ar' => 'أتابع تكلفة الطعام وسجلّات السلامة وأوقات الخروج أسبوعياً، وأعدّل بناءً على الأرقام لا على الانطباع.',
                'description_en' => 'I track food cost, safety records and ticket times weekly, and adjust from the numbers rather than from impressions.',
            ],
        ];

        foreach ($steps as $index => $step) {
            ProcessStep::query()->updateOrCreate(
                ['key' => $step['key']],
                [...$step, 'sort_order' => $index + 1],
            );
        }
    }
}
