<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

final class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'key'            => 'menu-development',
                'icon'           => 'menu',
                'title_ar'       => 'تطوير القوائم',
                'title_en'       => 'Menu Development',
                'summary_ar'     => 'بناء قوائم متوازنة تناسب هوية المكان وتكلفته وقدرة مطبخه.',
                'summary_en'     => 'Building balanced menus that fit the venue’s identity, its cost targets and what its kitchen can actually deliver.',
                'description_ar' => 'أصمّم القائمة انطلاقاً من ثلاثة قيود في آنٍ واحد: ذوق الضيف، وهامش الربح، وطاقة المطبخ في ساعة الذروة. الطبق الذي لا يمكن تنفيذه بثبات ليس طبقاً جيداً مهما كان مذاقه.',
                'description_en' => 'I design a menu against three constraints at once: the guest’s palate, the margin, and what the kitchen can hold at peak hour. A dish that cannot be executed consistently is not a good dish, however well it tastes.',
                'features_ar'    => ['هندسة القائمة والتسعير', 'توحيد الوصفات وأوزانها', 'قوائم موسمية ومناسبات', 'تذوّق وضبط نهائي'],
                'features_en'    => ['Menu engineering & pricing', 'Standardised, weighed recipes', 'Seasonal & event menus', 'Tasting and final calibration'],
            ],
            [
                'key'            => 'kitchen-management',
                'icon'           => 'brigade',
                'title_ar'       => 'إدارة المطبخ',
                'title_en'       => 'Kitchen Management',
                'summary_ar'     => 'قيادة الفريق وتنظيم المحطات وجداول العمل لخدمة تسير بلا تعثّر.',
                'summary_en'     => 'Leading the brigade, organising stations and schedules so service runs without stumbling.',
                'description_ar' => 'أوزّع المهام اليومية، وأضع جداول الدوام والحضور، وأنظّم المحطات بحيث يعرف كل فرد موقعه ومسؤوليته قبل بدء الخدمة. الهدف أن يكون المطبخ هادئاً حتى في أكثر الأوقات ضغطاً.',
                'description_en' => 'I assign daily tasks, build rotas and attendance, and lay out stations so every person knows their post and their responsibility before service starts. The aim is a kitchen that stays quiet even at its busiest.',
                'features_ar'    => ['توزيع المهام اليومية', 'جداول الدوام والحضور', 'تنظيم المحطات والتحضير', 'التنسيق مع الإدارة'],
                'features_en'    => ['Daily task allocation', 'Rotas & attendance', 'Station and mise en place layout', 'Coordination with management'],
            ],
            [
                'key'            => 'hot-kitchen',
                'icon'           => 'flame',
                'title_ar'       => 'المطبخ الساخن',
                'title_en'       => 'Hot Kitchen',
                'summary_ar'     => 'أطباق رئيسية وشوربات وصلصات بمستوى ثابت من أول طلب إلى آخره.',
                'summary_en'     => 'Mains, soups and sauces at one steady standard from the first order to the last.',
                'description_ar' => 'خبرة عملية في جميع أقسام المطبخ الساخن: الشوي، والقلي، والطهي البطيء، وتحضير المرقات والصلصات الأساسية، مع ضبط أوقات التحضير لضمان خروج الطبق في وقته.',
                'description_en' => 'Hands-on across the hot line: grill, sauté, slow cooking, and the mother stocks and sauces — with preparation times controlled so each plate leaves the pass on time.',
                'features_ar'    => ['الأطباق الرئيسية والشوربات', 'المرقات والصلصات الأساسية', 'ضبط أوقات التحضير', 'التقديم والتنسيق النهائي'],
                'features_en'    => ['Mains and soups', 'Stocks and mother sauces', 'Controlled preparation times', 'Plating and final presentation'],
            ],
            [
                'key'            => 'cold-kitchen',
                'icon'           => 'leaf',
                'title_ar'       => 'المطبخ البارد والمقبّلات',
                'title_en'       => 'Cold Kitchen & Garde Manger',
                'summary_ar'     => 'سلطات ومقبّلات وأطباق باردة تُبنى على النظافة والدقّة في التقطيع.',
                'summary_en'     => 'Salads, mezze and cold plates built on cleanliness and precise knife work.',
                'description_ar' => 'المطبخ البارد هو أول ما يراه الضيف وآخر ما ينساه. أعمل على السلطات والمقبّلات والأطباق الباردة بتقطيعٍ دقيق وتنسيقٍ متّسق، مع التزامٍ صارم بسلسلة التبريد.',
                'description_en' => 'The cold section is the first thing a guest sees and the last thing they forget. I work salads, mezze and cold plates with precise cuts and consistent presentation, under a strict cold chain.',
                'features_ar'    => ['السلطات والمقبّلات', 'الأطباق الباردة والغالانتين', 'دقّة التقطيع والتنسيق', 'الالتزام بسلسلة التبريد'],
                'features_en'    => ['Salads and mezze', 'Cold plates and galantines', 'Precise cuts and presentation', 'Cold-chain discipline'],
            ],
            [
                'key'            => 'food-safety',
                'icon'           => 'shield',
                'title_ar'       => 'سلامة الغذاء',
                'title_en'       => 'Food Safety',
                'summary_ar'     => 'تطبيق معايير HACCP وGMP في المطبخ تطبيقاً عملياً لا ورقياً.',
                'summary_en'     => 'HACCP and GMP applied on the floor, not just on paper.',
                'description_ar' => 'معرفة متقدّمة بأنظمة سلامة وجودة الغذاء، وقدرة على تطبيق اشتراطات الصحة والسلامة في بيئة العمل: نقاط التحكّم الحرجة، ودرجات الحرارة، والتخزين، والنظافة الشخصية، وسجلّات المتابعة.',
                'description_en' => 'Advanced knowledge of food safety and quality systems, and the ability to implement health and safety requirements in the workplace: critical control points, temperatures, storage, personal hygiene and monitoring records.',
                'features_ar'    => ['نقاط التحكّم الحرجة HACCP', 'ممارسات التصنيع الجيّدة GMP', 'مراقبة الحرارة والتخزين', 'تدريب الفريق على الاشتراطات'],
                'features_en'    => ['HACCP critical control points', 'Good Manufacturing Practice', 'Temperature & storage control', 'Training the team on requirements'],
            ],
            [
                'key'            => 'cost-control',
                'icon'           => 'scale',
                'title_ar'       => 'ضبط التكاليف',
                'title_en'       => 'Cost Control',
                'summary_ar'     => 'متابعة المخزون وتقليل الهدر والحفاظ على تكلفة الطعام ضمن هدفها.',
                'summary_en'     => 'Tracking inventory, cutting waste and holding food cost to its target.',
                'description_ar' => 'أراقب المخزون وأطلب المستلزمات بما يمنع النقص والفائض معاً، وأتابع تكلفة الطعام مقابل المبيعات، وأعمل على تقليل الهدر عبر التحضير المحسوب وإعادة استخدام المكوّنات بشكل آمن.',
                'description_en' => 'I monitor inventory and order to avoid both shortfall and overstock, track food cost against sales, and reduce waste through measured prep and safe re-use of ingredients.',
                'features_ar'    => ['متابعة المخزون والطلبات', 'حساب تكلفة الطبق', 'تقليل الهدر', 'تقارير دورية للإدارة'],
                'features_en'    => ['Inventory & ordering', 'Per-plate costing', 'Waste reduction', 'Regular reporting to management'],
            ],
        ];

        foreach ($services as $index => $service) {
            Service::query()->updateOrCreate(
                ['key' => $service['key']],
                [...$service, 'sort_order' => $index + 1],
            );
        }
    }
}
