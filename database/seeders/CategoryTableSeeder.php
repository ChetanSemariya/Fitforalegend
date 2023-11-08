<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryRecords = [
            ['id'=>1, 'category_name'=>'clothing', 'category_image'=>'', 'status'=>'Active'],
            ['id'=>2, 'category_name'=>'Appliances', 'category_image'=>'', 'status'=>'Active'],
            ['id'=>3, 'category_name'=>'Electronics', 'category_image'=>'', 'status'=>'Active'],
            ['id'=>4, 'category_name'=>'Accessories', 'category_image'=>'', 'status'=>'Active'],
        ];

        Category::insert($categoryRecords);
    }
}
