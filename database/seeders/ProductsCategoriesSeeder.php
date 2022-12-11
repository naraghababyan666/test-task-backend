<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::query()->firstOrCreate([
            'id' => 1,
            'name' => 'Аксессуары для ноутбуков',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Category::query()->firstOrCreate([
            'id' => 2,
            'name' => 'Клавиатура',
            'parent_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Category::query()->firstOrCreate([
            'id' => 3,
            'name' => 'Игровой мышки',
            'parent_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Product::query()->firstOrCreate([
            'id' => 1,
            'name' => 'Gembird / клавиатура беспроводная механ /KBW-G510L',
            'price' => 2520,
            'category_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Product::query()->firstOrCreate([
            'id' => 2,
            'name' => 'Face2face / Игровая клавиатура механическая для компьютера с подсветкой',
            'price' => 3700,
            'category_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Product::query()->firstOrCreate([
            'id' => 3,
            'name' => 'Redragon . Игровая мышка для компьютера Griffin 7200 dpi',
            'price' => 1199,
            'category_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }
}
