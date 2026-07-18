<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Seeder;

/**
 * The 14 curated photographs shipped in public/images/dishes.
 *
 * Three further source photographs were deliberately left out: they carry
 * another chef's watermark and are not Nour's work to publish.
 */
final class DishSeeder extends Seeder
{
    public function run(): void
    {
        $dishes = [
            [
                'key'            => 'beef-wellington',
                'image'          => 'images/dishes/beef-wellington.jpeg',
                'title_ar'       => 'بيف ولينغتون',
                'title_en'       => 'Beef Wellington',
                'category_ar'    => 'أطباق ساخنة',
                'category_en'    => 'Hot dishes',
                'description_ar' => 'لحم بقري مغلَّف بعجين هش مُشبَّك يدوياً، يُقدَّم مع خضار مشوية وصلصتين جانبيتين.',
                'description_en' => 'Beef encased in a hand-latticed puff pastry, served with grilled vegetables and two sauces.',
                'is_featured'    => true,
            ],
            [
                'key'            => 'seafood-bisque',
                'image'          => 'images/dishes/seafood-bisque.jpeg',
                'title_ar'       => 'بيسك المأكولات البحرية',
                'title_en'       => 'Seafood Bisque',
                'category_ar'    => 'شوربات',
                'category_en'    => 'Soups',
                'description_ar'  => 'حساء بحري كريمي بلون الزعفران، يعلوه برج من ثمار البحر وروبيان مشوي.',
                'description_en' => 'A saffron-hued creamy shellfish bisque, crowned with a tower of seafood and a grilled prawn.',
                'is_featured'    => true,
            ],
            [
                'key'            => 'eggplant-timbale',
                'image'          => 'images/dishes/eggplant-timbale.jpeg',
                'title_ar'       => 'تمبال الباذنجان بالرمان',
                'title_en'       => 'Eggplant Timbale',
                'category_ar'    => 'مقبلات وسلطات',
                'category_en'    => 'Cold dishes & salads',
                'description_ar' => 'طبقات باذنجان مطهو ببطء، مع حبّ الرمان والجوز والنعناع الطازج.',
                'description_en' => 'Layers of slow-cooked eggplant finished with pomegranate seeds, walnuts and fresh mint.',
                'is_featured'    => true,
            ],
            [
                'key'            => 'kibbeh',
                'image'          => 'images/dishes/kibbeh.jpeg',
                'title_ar'       => 'كبة مقلية',
                'title_en'       => 'Kibbeh',
                'category_ar'    => 'أطباق ساخنة',
                'category_en'    => 'Hot dishes',
                'description_ar' => 'كبة بُرغل محشوّة، تُقدَّم على خبز مرقوق مع مقبّلات ولبنة وسلطات جانبية.',
                'description_en' => 'Stuffed bulgur kibbeh on markouk bread, served with mezze, labneh and side salads.',
                'is_featured'    => true,
            ],
            [
                'key'            => 'tabbouleh',
                'image'          => 'images/dishes/tabbouleh.jpeg',
                'title_ar'       => 'تبّولة',
                'title_en'       => 'Tabbouleh',
                'category_ar'    => 'مقبلات وسلطات',
                'category_en'    => 'Cold dishes & salads',
                'description_ar' => 'بقدونس مفروم يدوياً مع البرغل والطماطم والنعناع والليمون الطازج.',
                'description_en' => 'Hand-chopped parsley with bulgur, tomato, mint and fresh lemon.',
                'is_featured'    => true,
            ],
            [
                'key'            => 'saffron-crepe',
                'image'          => 'images/dishes/saffron-crepe.jpeg',
                'title_ar'       => 'كريب الزعفران',
                'title_en'       => 'Saffron Crêpe',
                'category_ar'    => 'أطباق ساخنة',
                'category_en'    => 'Hot dishes',
                'description_ar' => 'صرّة كريب بالزعفران على كريمة كرنب مزهر، مع تويل مقرمش وشبت طازج.',
                'description_en' => 'A saffron crêpe purse over cauliflower velouté, with a crisp tuile and fresh dill.',
                'is_featured'    => true,
            ],
            [
                'key'            => 'beef-roulade',
                'image'          => 'images/dishes/beef-roulade.jpeg',
                'title_ar'       => 'رولاد اللحم بصلصة الطماطم',
                'title_en'       => 'Beef Roulade',
                'category_ar'    => 'أطباق ساخنة',
                'category_en'    => 'Hot dishes',
                'description_ar' => 'رولاد لحم بقري مع بطاطا مهروسة وخضار، في صلصة طماطم غنيّة.',
                'description_en' => 'Beef roulade with potato purée and vegetables in a rich tomato sauce.',
                'is_featured'    => false,
            ],
            [
                'key'            => 'seafood-chowder',
                'image'          => 'images/dishes/seafood-chowder.jpeg',
                'title_ar'       => 'شوربة بحرية كريمية',
                'title_en'       => 'Seafood Chowder',
                'category_ar'    => 'شوربات',
                'category_en'    => 'Soups',
                'description_ar' => 'شوربة كريمية بالخضار المكعّبة وروبيان مشوي وشبت طازج.',
                'description_en' => 'A creamy chowder with diced vegetables, grilled prawn and fresh dill.',
                'is_featured'    => false,
            ],
            [
                'key'            => 'chicken-galantine',
                'image'          => 'images/dishes/chicken-galantine.jpeg',
                'title_ar'       => 'غالانتين الدجاج',
                'title_en'       => 'Chicken Galantine',
                'category_ar'    => 'مقبلات وسلطات',
                'category_en'    => 'Cold dishes & salads',
                'description_ar' => 'شرائح غالانتين باردة بالفلفل الملوّن، مع تويل مقرمش وصلصة طماطم حارّة.',
                'description_en' => 'Cold galantine slices studded with peppers, with crisp tuiles and a spiced tomato relish.',
                'is_featured'    => false,
            ],
            [
                'key'            => 'pasta-timbale',
                'image'          => 'images/dishes/pasta-timbale.jpeg',
                'title_ar'       => 'باستا بصلصة الجبن والبيستو',
                'title_en'       => 'Pasta with Pesto Cream',
                'category_ar'    => 'أطباق ساخنة',
                'category_en'    => 'Hot dishes',
                'description_ar' => 'لفائف باستا بجبن البارميزان على كريمة البيستو مع الصنوبر والريحان.',
                'description_en' => 'Rolled pasta with parmesan over a pesto cream, with pine nuts and basil.',
                'is_featured'    => false,
            ],
            [
                'key'            => 'chicken-mandi',
                'image'          => 'images/dishes/chicken-mandi.jpeg',
                'title_ar'       => 'مندي دجاج',
                'title_en'       => 'Chicken Mandi',
                'category_ar'    => 'أطباق ساخنة',
                'category_en'    => 'Hot dishes',
                'description_ar' => 'أرز مندي متبّل مع دجاج مشوي ولوز محمّص وصلصة حارّة جانبية.',
                'description_en' => 'Spiced mandi rice with roasted chicken, toasted almonds and a chilli sauce on the side.',
                'is_featured'    => false,
            ],
            [
                'key'            => 'sambousek',
                'image'          => 'images/dishes/sambousek.jpeg',
                'title_ar'       => 'سمبوسك مشكّل',
                'title_en'       => 'Assorted Sambousek',
                'category_ar'    => 'أطباق ساخنة',
                'category_en'    => 'Hot dishes',
                'description_ar' => 'تشكيلة سمبوسك محشوّة بالسمسم والحبة السوداء، تُقدَّم ساخنة.',
                'description_en' => 'An assortment of filled sambousek with sesame and nigella, served hot.',
                'is_featured'    => false,
            ],
            [
                'key'            => 'citrus-walnut-salad',
                'image'          => 'images/dishes/citrus-walnut-salad.jpeg',
                'title_ar'       => 'سلطة الحمضيات والجوز',
                'title_en'       => 'Citrus & Walnut Salad',
                'category_ar'    => 'مقبلات وسلطات',
                'category_en'    => 'Cold dishes & salads',
                'description_ar' => 'خس طازج مع شرائح الحمضيات والجوز وصلصة كريمية خفيفة.',
                'description_en' => 'Crisp lettuce with citrus segments, walnuts and a light creamy dressing.',
                'is_featured'    => false,
            ],
            [
                'key'            => 'caesar-salad',
                'image'          => 'images/dishes/caesar-salad.jpeg',
                'title_ar'       => 'سلطة سيزر',
                'title_en'       => 'Caesar Salad',
                'category_ar'    => 'مقبلات وسلطات',
                'category_en'    => 'Cold dishes & salads',
                'description_ar' => 'خس روماني مع خبز محمّص وبارميزان وصلصة سيزر كلاسيكية.',
                'description_en' => 'Romaine with croutons, parmesan and a classic Caesar dressing.',
                'is_featured'    => false,
            ],
        ];

        foreach ($dishes as $index => $dish) {
            Dish::query()->updateOrCreate(
                ['key' => $dish['key']],
                [...$dish, 'sort_order' => $index + 1],
            );
        }
    }
}
