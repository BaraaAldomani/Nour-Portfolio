<?php

declare(strict_types=1);

namespace App\Support;

/**
 * The one and only source of truth for singleton site copy.
 *
 * Both the seeder and every Filament settings page read from here, so there is
 * no second copy of this text in a lang file waiting to drift out of sync.
 * Structural, repeating content (dishes, services, experience) lives in its own
 * table instead -- this class is only for one-off copy and configuration.
 *
 * Group => key => value. Values that end in _ar / _en are the bilingual pairs.
 */
final class SettingsDefaults
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'theme'     => self::theme(),
            'identity'  => self::identity(),
            'pages'     => self::pages(),
            'home'      => self::home(),
            'about'     => self::about(),
            'portfolio' => self::portfolio(),
            'contact'   => self::contact(),
            'seo'       => self::seo(),
            'images'    => self::images(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function group(string $group): array
    {
        return self::all()[$group] ?? [];
    }

    /**
     * @return array<int, string>
     */
    public static function groups(): array
    {
        return array_keys(self::all());
    }

    /**
     * The three editable brand colours. Every other colour in the design system
     * is derived from these via color-mix(), so changing one of them re-themes
     * the entire site.
     *
     * @return array<string, mixed>
     */
    public static function theme(): array
    {
        return [
            'brand_primary'   => '#C8A24C', // gold -- links, CTAs, the plate ring
            'brand_secondary' => '#0F0E0C', // near-black ink and dark sections
            'brand_accent'    => '#E8DCC8', // warm beige highlight
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function identity(): array
    {
        return [
            'name_ar'     => 'نور الدين الدوماني',
            'name_en'     => 'Nour Aldeen Aldomani',
            'role_ar'     => 'شيف تنفيذي',
            'role_en'     => 'Executive Chef',
            'initials'    => 'N',
            'tagline_ar'  => 'إتقانٌ في كل طبق',
            'tagline_en'  => 'Precision on every plate',
            'location_ar' => 'الرياض، المملكة العربية السعودية',
            'location_en' => 'Riyadh, Saudi Arabia',
        ];
    }

    /**
     * Inner-page headers. Each public route reads its eyebrow/title/lead here.
     *
     * @return array<string, mixed>
     */
    public static function pages(): array
    {
        return [
            'about_eyebrow_ar' => 'نبذة',
            'about_eyebrow_en' => 'About',
            'about_title_ar'   => 'الشيف خلف الطبق',
            'about_title_en'   => 'The chef behind the plate',
            'about_lead_ar'    => 'من مطبخ فندقيّ إلى قيادة مطبخ مطعم، هذه هي الطريقة التي أعمل بها.',
            'about_lead_en'    => 'From a hotel kitchen to running a restaurant pass — this is how I work.',

            'portfolio_eyebrow_ar' => 'المعرض',
            'portfolio_eyebrow_en' => 'Portfolio',
            'portfolio_title_ar'   => 'أطباقٌ من مطبخي',
            'portfolio_title_en'   => 'Dishes from my kitchen',
            'portfolio_lead_ar'    => 'مختاراتٌ من أطباقٍ ساخنة وباردة، صُوِّرت كما تُقدَّم للضيف تماماً.',
            'portfolio_lead_en'    => 'A selection of hot and cold dishes, photographed exactly as they leave the pass.',

            'experience_eyebrow_ar' => 'المسيرة',
            'experience_eyebrow_en' => 'Experience',
            'experience_title_ar'   => 'المسيرة المهنية',
            'experience_title_en'   => 'Professional history',
            'experience_lead_ar'    => 'المطابخ التي عملت فيها، والمسؤوليات التي حملتها في كلٍّ منها.',
            'experience_lead_en'    => 'The kitchens I have worked in, and what I carried in each one.',

            'services_eyebrow_ar' => 'الخدمات',
            'services_eyebrow_en' => 'Services',
            'services_title_ar'   => 'ما أقدّمه',
            'services_title_en'   => 'What I bring',
            'services_lead_ar'    => 'من بناء القائمة إلى ضبط التكلفة وسلامة الغذاء — عملٌ متكاملٌ في المطبخ.',
            'services_lead_en'    => 'From menu design to cost control and food safety — the full span of a working kitchen.',

            'contact_eyebrow_ar' => 'تواصل',
            'contact_eyebrow_en' => 'Contact',
            'contact_title_ar'   => 'لنتحدّث',
            'contact_title_en'   => 'Let’s talk',
            'contact_lead_ar'    => 'مفتوحٌ لفرصٍ في المطاعم والفنادق داخل الرياض والمملكة.',
            'contact_lead_en'    => 'Open to restaurant and hotel roles in Riyadh and across the Kingdom.',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function home(): array
    {
        return [
            'hero_eyebrow_ar' => 'شيف تنفيذي · الرياض',
            'hero_eyebrow_en' => 'Executive Chef · Riyadh',
            'hero_lead_ar'    => 'شيفٌ تنفيذي متخصّص في المطبخين الساخن والبارد. أبني قوائم تحافظ على مستواها في أكثر الليالي ازدحاماً، وأقود فرقاً تعمل بهدوءٍ تحت الضغط.',
            'hero_lead_en'    => 'An executive chef specialising in hot and cold kitchens. I build menus that hold their standard on the busiest night of the week, and lead teams that stay calm under pressure.',
            'hero_cta_ar'     => 'شاهد الأطباق',
            'hero_cta_en'     => 'See the dishes',
            'hero_cta_alt_ar' => 'تواصل معي',
            'hero_cta_alt_en' => 'Get in touch',

            'intro_eyebrow_ar' => 'المبدأ',
            'intro_eyebrow_en' => 'The principle',
            'intro_title_ar'   => 'الطبق الأخير في الليلة يجب أن يشبه الأول',
            'intro_title_en'   => 'The last plate of the night should look like the first',
            'intro_body_ar'    => 'التميّز في المطبخ ليس لحظةَ إلهام، بل نظامٌ يُكرَّر. وصفاتٌ موزونة، محطّاتٌ مُجهّزة، فريقٌ مدرَّب، ومعايير سلامةٍ لا تُناقَش. هذا ما يجعل الجودة قابلةً للتكرار بدل أن تكون صدفة.',
            'intro_body_en'    => 'Excellence in a kitchen is not a moment of inspiration — it is a system you can repeat. Weighed recipes, prepped stations, a trained team, and food-safety standards that are never up for debate. That is what makes quality repeatable instead of accidental.',

            'services_eyebrow_ar' => 'الخدمات',
            'services_eyebrow_en' => 'Services',
            'services_title_ar'   => 'ما أقدّمه للمطبخ',
            'services_title_en'   => 'What I bring to a kitchen',

            'portfolio_eyebrow_ar' => 'المعرض',
            'portfolio_eyebrow_en' => 'Portfolio',
            'portfolio_title_ar'   => 'مختاراتٌ من الأطباق',
            'portfolio_title_en'   => 'Selected dishes',
            'portfolio_cta_ar'     => 'المعرض كاملاً',
            'portfolio_cta_en'     => 'View the full portfolio',

            'process_eyebrow_ar' => 'الطريقة',
            'process_eyebrow_en' => 'Method',
            'process_title_ar'   => 'كيف أبني مطبخاً',
            'process_title_en'   => 'How I build a kitchen',

            'experience_eyebrow_ar' => 'المسيرة',
            'experience_eyebrow_en' => 'Experience',
            'experience_title_ar'   => 'أين عملت',
            'experience_title_en'   => 'Where I have worked',
            'experience_cta_ar'     => 'المسيرة كاملة',
            'experience_cta_en'     => 'Full history',

            'cta_title_ar' => 'تبحث عن شيفٍ لمطبخك؟',
            'cta_title_en' => 'Looking for a chef for your kitchen?',
            'cta_body_ar'  => 'مفتوحٌ لفرصٍ بدوامٍ كامل، واستشاراتِ قوائم، وافتتاحاتٍ جديدة في الرياض.',
            'cta_body_en'  => 'Open to full-time roles, menu consulting, and new openings in Riyadh.',
            'cta_button_ar' => 'ابدأ محادثة',
            'cta_button_en' => 'Start a conversation',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function about(): array
    {
        return [
            'story_title_ar' => 'من أين بدأت',
            'story_title_en' => 'Where it started',
            'story_body_ar'  => "درست إدارة الفنادق في كلية السياحة بجامعة دمشق، ودرست الطهي والحلويات في مركز جلجامش. لكن التعلّم الحقيقي بدأ في مطبخ فندق شيراتون، حيث مررت على كل أقسام المطبخ: التحضير، والطهي، والتقديم، ومعايير الصحة.\n\nمن هناك انتقلت إلى مطعم لوسين مسؤولاً عن ضبط الجودة والعمليات اليومية، ثم إلى مطعم مضياف شيفاً تنفيذياً أقود المطبخ بالكامل.",
            'story_body_en'  => "I studied Hotel Management at the Faculty of Tourism, Damascus University, and trained in culinary arts and pastry at Gilgamesh Center. But the real education began in the kitchen at Sheraton Hotel, where I rotated through every section: preparation, cooking, service, and health standards.\n\nFrom there I moved to Lusin Restaurant as control chef, owning quality and daily operations, and then to Medhyaf Restaurant as executive chef, running the kitchen end to end.",

            'philosophy_title_ar' => 'كيف أدير مطبخاً',
            'philosophy_title_en' => 'How I run a kitchen',
            'philosophy_body_ar'  => 'المطبخ الهادئ ليس مطبخاً بطيئاً — بل مطبخٌ مُجهَّز. التحضير الجيّد قبل الخدمة يعني أن الضغط لا يتحوّل إلى فوضى. أدرّب فريقي على المعايير لا على الأوامر، حتى يعرف كلٌّ منهم لماذا يفعل ما يفعل، فيصمد المستوى حتى في أصعب الليالي.',
            'philosophy_body_en'  => 'A calm kitchen is not a slow kitchen — it is a prepared one. Good mise en place before service means pressure never turns into chaos. I train my team on standards rather than orders, so each person knows why they do what they do, and the level holds even on the hardest nights.',

            'skills_title_ar'    => 'المهارات',
            'skills_title_en'    => 'Skills',
            'education_title_ar' => 'التعليم والشهادات',
            'education_title_en' => 'Education & credentials',
            'languages_title_ar' => 'اللغات',
            'languages_title_en' => 'Languages',
            'languages_body_ar'  => 'العربية: اللغة الأم · الإنجليزية: مستوى متوسط',
            'languages_body_en'  => 'Arabic: native · English: intermediate',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function portfolio(): array
    {
        return [
            'note_ar'         => 'جميع الصور لأطباقٍ حضّرتها وقدّمتها بنفسي في المطابخ التي عملت فيها.',
            'note_en'         => 'Every photograph is a dish I prepared and plated myself in the kitchens I have worked in.',
            'pinterest_url'   => 'https://pin.it/1qkc5weJE',
            'pinterest_label_ar' => 'المزيد على Pinterest',
            'pinterest_label_en' => 'More on Pinterest',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function contact(): array
    {
        return [
            'email'    => 'nour963dom@gmail.com',
            'phone'    => '+966504325762',
            'whatsapp' => '966504325762',
            'city_ar'  => 'الرياض، المملكة العربية السعودية',
            'city_en'  => 'Riyadh, Saudi Arabia',

            'availability_ar' => 'متاح لفرصٍ جديدة',
            'availability_en' => 'Available for new roles',

            'form_title_ar' => 'أرسل رسالة',
            'form_title_en' => 'Send a message',
            'form_note_ar'  => 'أرد عادةً خلال يومَي عمل.',
            'form_note_en'  => 'I usually reply within two working days.',

            'success_ar' => 'وصلت رسالتك. شكراً لتواصلك — سأرد قريباً.',
            'success_en' => 'Your message arrived. Thank you for reaching out — I will reply shortly.',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function seo(): array
    {
        return [
            'title_ar'       => 'نور الدين الدوماني — شيف تنفيذي في الرياض',
            'title_en'       => 'Nour Aldeen Aldomani — Executive Chef in Riyadh',
            'description_ar' => 'شيفٌ تنفيذي في الرياض متخصّص في المطبخين الساخن والبارد، وبناء القوائم، وضبط التكلفة، ومعايير سلامة الغذاء HACCP وGMP.',
            'description_en' => 'Executive chef in Riyadh specialising in hot and cold kitchens, menu development, cost control, and HACCP/GMP food-safety standards.',
            'keywords_ar'    => 'شيف الرياض, شيف تنفيذي, طاهي محترف, تطوير قوائم, سلامة الغذاء',
            'keywords_en'    => 'chef riyadh, executive chef, professional cook, menu development, food safety, HACCP',
            'same_as'        => "https://pin.it/1qkc5weJE",
        ];
    }

    /**
     * Uploaded overrides for the repo-shipped imagery. Empty means "use the
     * config/site.php fallback".
     *
     * @return array<string, mixed>
     */
    public static function images(): array
    {
        return [
            'portrait' => '',
            'og'       => '',
        ];
    }
}
