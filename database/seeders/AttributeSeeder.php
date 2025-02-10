<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Attribute::factory(30)->create();
    }
}
