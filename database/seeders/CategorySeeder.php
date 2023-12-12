<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'rent',
            'status' => 1,
            'discription' => 'discription  rent',
        ]);
        Category::create([
            'name' => 'buying',
            'status' => 1,
            'discription' => 'discription  buying',
        ]);
        Category::create([
            'name' => 'Partial rent',
            'status' => 1,
            'discription' => 'discription  Partial rent',
        ]);
    }
}