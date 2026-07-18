<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

/**
 * Straight from the CV: three roles, most recent first.
 */
final class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $experiences = [
            [
                'key'           => 'medhyaf',
                'company_ar'    => 'مطعم مضياف',
                'company_en'    => 'Medhyaf Restaurant',
                'role_ar'       => 'شيف تنفيذي',
                'role_en'       => 'Executive Chef',
                'location_ar'   => 'الرياض',
                'location_en'   => 'Riyadh',
                'start_date'    => '2026-05-01',
                'end_date'      => null,
                'is_current'    => true,
                'summary_ar'    => 'قيادة المطبخ بالكامل: العمليات، والجودة، والفريق، والتكلفة.',
                'summary_en'    => 'Running the kitchen end to end: operations, quality, team and cost.',
                'highlights_ar' => [
                    'إدارة جميع عمليات المطبخ والإشراف عليها.',
                    'الحفاظ على جودة الطعام وتطوير أصناف القائمة.',
                    'قيادة فريق المطبخ وتوزيع المهام اليومية.',
                    'متابعة المخزون وطلب المستلزمات.',
                    'ضبط تكلفة الطعام وتقليل الهدر.',
                    'تدريب موظفي المطبخ ودعمهم.',
                    'الحفاظ على خدمة سريعة ومنظّمة داخل المطبخ.',
                    'التنسيق مع الإدارة لتحقيق الأهداف التشغيلية.',
                ],
                'highlights_en' => [
                    'Manage and supervise all kitchen operations.',
                    'Maintain food quality and develop menu items.',
                    'Lead kitchen staff and assign daily tasks.',
                    'Monitor inventory and order supplies.',
                    'Control food cost and reduce waste.',
                    'Train and support kitchen employees.',
                    'Maintain fast and organised kitchen service.',
                    'Coordinate with management to achieve operational goals.',
                ],
            ],
            [
                'key'           => 'lusin',
                'company_ar'    => 'مطعم لوسين',
                'company_en'    => 'Lusin Restaurant',
                'role_ar'       => 'شيف ضبط الجودة',
                'role_en'       => 'Control Chef',
                'location_ar'   => 'الرياض',
                'location_en'   => 'Riyadh',
                'start_date'    => '2025-09-01',
                'end_date'      => '2026-05-01',
                'is_current'    => false,
                'summary_ar'    => 'الإشراف على العمليات اليومية وضبط الجودة وسير العمل داخل المطبخ.',
                'summary_en'    => 'Overseeing daily operations, quality control and kitchen workflow.',
                'highlights_ar' => [
                    'الإشراف على العمليات اليومية وسير العمل في المطبخ.',
                    'توزيع المهام والواجبات على فريق المطبخ.',
                    'إعداد جداول العمل وإدارة حضور الموظفين.',
                    'تدريب الموظفين الجدد ودعم تطوير الفريق.',
                    'الإشراف على تحضير الطعام وفق الوصفات والمعايير المعتمدة.',
                    'ضمان مطابقة جودة الطعام ومذاقه وتقديمه للمعايير المطلوبة.',
                    'مراقبة أوقات التحضير لضمان تقديم الطلبات في وقتها.',
                ],
                'highlights_en' => [
                    'Supervise daily kitchen operations and workflow.',
                    'Assign tasks and duties to kitchen staff.',
                    'Prepare work schedules and manage staff attendance.',
                    'Train new employees and support team development.',
                    'Oversee food preparation according to approved recipes and standards.',
                    'Ensure food quality, taste and presentation meet required standards.',
                    'Monitor preparation times to ensure timely service.',
                ],
            ],
            [
                'key'           => 'sheraton',
                'company_ar'    => 'فندق شيراتون',
                'company_en'    => 'Sheraton Hotel',
                'role_ar'       => 'شيف — جميع أقسام المطبخ',
                'role_en'       => 'Chef — all kitchen sections',
                'location_ar'   => null,
                'location_en'   => null,
                'start_date'    => '2024-07-01',
                'end_date'      => '2025-07-01',
                'is_current'    => false,
                'summary_ar'    => 'خبرة عملية في جميع أقسام المطبخ داخل بيئة عمل فندقية.',
                'summary_en'    => 'Practical experience across every kitchen department in a hotel environment.',
                'highlights_ar' => [
                    'اكتساب خبرة عملية في جميع أقسام المطبخ: التحضير، والطهي، والتقديم.',
                    'العمل وفق معايير الصحة والسلامة المعتمدة في الفنادق.',
                    'تطوير المهارات المهنية وفهم بيئة العمل الفندقية.',
                ],
                'highlights_en' => [
                    'Gained practical experience across every kitchen department: preparation, cooking and service.',
                    'Worked to the health and safety standards required in hotel kitchens.',
                    'Developed professional skills and an understanding of the hotel working environment.',
                ],
            ],
        ];

        foreach ($experiences as $index => $experience) {
            Experience::query()->updateOrCreate(
                ['key' => $experience['key']],
                [...$experience, 'sort_order' => $index + 1],
            );
        }
    }
}
