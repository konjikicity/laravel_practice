<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['title' => 'programing'],
            ['title' => 'design'],
            ['title' => 'management']
        ];

        //登録処理
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
