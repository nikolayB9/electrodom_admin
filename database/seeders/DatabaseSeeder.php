<?php

namespace Database\Seeders;

use App\Models\Category;
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
        Category::insert($categories);

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
