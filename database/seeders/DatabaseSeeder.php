<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\AttributeProduct;
use App\Models\Category;
use App\Models\MeasureUnit;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();

        $categories = [
            [
                'title' => 'Электрооборудование',
                'lft' => 1,
                'rgt' => 14,
            ],
            [
                'title' => 'Электрощитовое оборудование',
                'lft' => 2,
                'rgt' => 9,
            ],
            [
                'title' => 'Корпуса металлические',
                'lft' => 3,
                'rgt' => 4,
            ],
            [
                'title' => 'Корпуса пластиковые',
                'lft' => 5,
                'rgt' => 6,
            ],
            [
                'title' => 'Корпуса в сборе готовые',
                'lft' => 7,
                'rgt' => 8,
            ],
            [
                'title' => 'Система прокладки кабеля и электромонтажные изделия',
                'lft' => 10,
                'rgt' => 13,
            ],
            [
                'title' => 'Металлорукав',
                'lft' => 11,
                'rgt' => 12,
            ],
            [
                'title' => 'Светотехника',
                'lft' => 15,
                'rgt' => 22,
            ],
            [
                'title' => 'Источники света (лампы)',
                'lft' => 16,
                'rgt' => 21,
            ],
            [
                'title' => 'Светодиодные лампы',
                'lft' => 17,
                'rgt' => 18,
            ],
            [
                'title' => 'Лампы накаливания',
                'lft' => 19,
                'rgt' => 20,
            ],
        ];
        $measureUnits = [
            [
                'title' => 'кг',
            ],
            [
                'title' => 'г',
            ],
            [
                'title' => 'см',
            ],
            [
                'title' => 'Вт',
            ],
            [
                'title' => 'Лм',
            ],
            [
                'title' => 'мм',
            ],
            [
                'title' => 'град',
            ],
        ];
        $attributes = [
            [
                'title' => 'Бренд',
                'measure_unit_id' => null,
            ],
            [
                'title' => 'Степень защиты',
                'measure_unit_id' => null,
            ],
            [
                'title' => 'Вес',
                'measure_unit_id' => 1,
            ],
            [
                'title' => 'Вес',
                'measure_unit_id' => 2,
            ],
            [
                'title' => 'Ширина',
                'measure_unit_id' => 3,
            ],
            [
                'title' => 'Длина',
                'measure_unit_id' => 3,
            ],
            [
                'title' => 'Высота',
                'measure_unit_id' => 3,
            ],
            [
                'title' => 'Мощность',
                'measure_unit_id' => 4,
            ],
            [
                'title' => 'Световой поток',
                'measure_unit_id' => 5,
            ],
            [
                'title' => 'Тип цоколя',
                'measure_unit_id' => null,
            ],
            [
                'title' => 'Диаметр',
                'measure_unit_id' => 6,
            ],
            [
                'title' => 'Гарантия',
                'measure_unit_id' => null,
            ],
            [
                'title' => 'Типоразмер',
                'measure_unit_id' => null,
            ],
            [
                'title' => 'Назначение',
                'measure_unit_id' => null,
            ],
            [
                'title' => 'Индекс цветопередачи Ra',
                'measure_unit_id' => null,
            ],
            [
                'title' => 'Угол свечения',
                'measure_unit_id' => 7,
            ],
            [
                'title' => 'Способ установки',
                'measure_unit_id' => null,
            ],
        ];
        $attributeCategory = [
            [
                'category_id' => 1,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 2,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 2,
                'attribute_id' => 5,
            ],
            [
                'category_id' => 3,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 3,
                'attribute_id' => 5,
            ],
            [
                'category_id' => 4,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 4,
                'attribute_id' => 5,
            ],
            [
                'category_id' => 5,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 5,
                'attribute_id' => 5,
            ],
            [
                'category_id' => 6,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 6,
                'attribute_id' => 6,
            ],
            [
                'category_id' => 7,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 7,
                'attribute_id' => 6,
            ],
            [
                'category_id' => 8,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 9,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 9,
                'attribute_id' => 9,
            ],
            [
                'category_id' => 10,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 10,
                'attribute_id' => 9,
            ],
            [
                'category_id' => 11,
                'attribute_id' => 1,
            ],
            [
                'category_id' => 11,
                'attribute_id' => 9,
            ],
        ];
        $products = [
            [
                'title' => 'Бокс пластиковый ЩРН-П-12',
                'description' => 'У нас вы можете купить бокс щитка распределительный навесной ЩРН-П на 12 модулей.
                    Продукция выпущена компанией IEK. Интернет-магазин электротехнического оборудования «Минимакс»
                    предлагает 1200 моделей распределительных щитков по доступным ценам. ',
                'image' => null,
                'count' => 109,
                'price' => 1353.05,
                'old_price' => null,
                'is_published' => 1,
                'category_id' => 4,
            ],
            [
                'title' => 'Бокс пластиковый ЩРН-П-18 IP40 навесной City9 Box 221х364х100 SE EZ9E118S2SRU',
                'description' => null,
                'image' => null,
                'count' => 35,
                'price' => 1698,
                'old_price' => null,
                'is_published' => 1,
                'category_id' => 4,
            ],
            [
                'title' => 'Щит распределительный металлический ЩРн-24з-1 36 УХЛ3 IP31 с замком 395х310х120 (ВхШхГ) MKM14-N-24-31-Z IEK',
                'description' => 'Предназначены для сборки распределительных электрощитов с использованием модульной
                    аппаратуры, для ввода и распределения электроэнергии, а также для защиты сетей напряжением 230/400 В от токов перегрузки и короткого замыкания.',
                'image' => null,
                'count' => 262,
                'price' => 3512.99,
                'old_price' => 3800.99,
                'is_published' => 1,
                'category_id' => 3,
            ],
            [
                'title' => 'Лампа светодиодная 10Вт E14 P47 4000К 800Лм матовая 220-240В Шар Value 4058075579743 OSRAM',
                'description' => 'Лампа светодиодная 10 Вт Value 800Лм, 4000К (нейтральный свет) E14, колба P Шар матовый,
                    220-240В 4058075579743 OSRAM позволит существенно сократить расходы на электроэнергию. Обладает мощностью
                    10 ватт и световым потоком 800 люмен. Рассчитана на напряжение сети 220-240 вольт.
                    Цвет свечения нейтральный и цветовая температура 4000 Кельвинов.
                    Отличается продолжительным сроком службы - в течение нескольких лет не потребует замены на новую лампу.
                    Экологически безопасная (не содержит ртути и тяжелых металлов). Мягкое и равномерное распределение света
                     повышает зрительный комфорт и снижает утомляемость глаз. У производителя Osram контроль качества
                     продукции является важной составляющей его производства. В наличии есть все соответствующие сертификаты.',
                'image' => null,
                'count' => 458,
                'price' => 127.70,
                'old_price' => null,
                'is_published' => 1,
                'category_id' => 10,
            ],
            [
                'title' => 'Лампа светодиодная 5.5Вт PLED-SP-G45 Е14 5000K 350Lm 5=40W 230/50 шар, холодный .1033468 Jazzway',
                'description' => null,
                'image' => null,
                'count' => 1,
                'price' => 122.90,
                'old_price' => 159.99,
                'is_published' => 1,
                'category_id' => 10,
            ],
            [
                'title' => 'Лампа светодиодная 40 Вт E40 ED90 4000К 5600Лм прозрачная 175-250В цилиндр Profi
                (LED-ED90-40W/NW/E40/CL GLP05TR)',
                'description' => 'Лампа светодиодная 40 Вт E40 ED90 4000К 5600Лм прозрачная 175-250В цилиндр Profi
                (LED-ED90-40W/NW/E40/CL GLP05TR) UL-00003762 Uniel',
                'image' => null,
                'count' => 22,
                'price' => 3165.50,
                'old_price' => null,
                'is_published' => 1,
                'category_id' => 10,
            ],
            [
                'title' => 'Лампа светодиодная 7 Вт GU5.3 MR16 4000K 600Лм 220В рефлектор D80110 диммируемая
                4058075229037 OSRAM',
                'description' => null,
                'image' => null,
                'count' => 1,
                'price' => 400.30,
                'old_price' => null,
                'is_published' => 1,
                'category_id' => 10,
            ],
            [
                'title' => 'Лампа светодиодная 25Вт E27 А70 2000Лм 4000К LVCLA200 25SW/840 230VFR 10X1RU
                4058075696358 OSRAM',
                'description' => null,
                'image' => null,
                'count' => 3,
                'price' => 222.90,
                'old_price' => null,
                'is_published' => 1,
                'category_id' => 10,
            ],
        ];
        $attributeProduct = [
            [
                'product_id' => 1,
                'attribute_id' => 1,
                'value' => 'IEK',
            ],
            [
                'product_id' => 1,
                'attribute_id' => 5,
                'value' => 30,
            ],
            [
                'product_id' => 2,
                'attribute_id' => 1,
                'value' => 'Shneider Electric',
            ],
            [
                'product_id' => 2,
                'attribute_id' => 5,
                'value' => 40,
            ],
            [
                'product_id' => 3,
                'attribute_id' => 1,
                'value' => 'IEK',
            ],
            [
                'product_id' => 3,
                'attribute_id' => 5,
                'value' => 40,
            ],
            [
                'product_id' => 4,
                'attribute_id' => 1,
                'value' => 'OSRAM',
            ],
            [
                'product_id' => 4,
                'attribute_id' => 9,
                'value' => 500,
            ],
            [
                'product_id' => 5,
                'attribute_id' => 1,
                'value' => 'Jazzway',
            ],
            [
                'product_id' => 5,
                'attribute_id' => 9,
                'value' => 400,
            ],
            [
                'product_id' => 6,
                'attribute_id' => 1,
                'value' => 'Jazzway',
            ],
            [
                'product_id' => 6,
                'attribute_id' => 9,
                'value' => 400,
            ],
            [
                'product_id' => 7,
                'attribute_id' => 1,
                'value' => 'Jazzway',
            ],
            [
                'product_id' => 7,
                'attribute_id' => 9,
                'value' => 400,
            ],
            [
                'product_id' => 8,
                'attribute_id' => 1,
                'value' => 'Jazzway',
            ],
            [
                'product_id' => 8,
                'attribute_id' => 9,
                'value' => 400,
            ],
        ];

        Category::insert($categories);
        MeasureUnit::insert($measureUnits);
        Attribute::insert($attributes);
        AttributeCategory::insert($attributeCategory);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        Product::insert($products);
        AttributeProduct::insert($attributeProduct);

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
