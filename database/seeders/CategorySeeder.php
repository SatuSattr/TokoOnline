<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::updateOrCreate(
            ['name' => 'electronics'],
            ['display_name' => 'Electronics']
        );
        
        Category::updateOrCreate(
            ['name' => 'sports'],
            ['display_name' => 'Sports']
        );
        
        Category::updateOrCreate(
            ['name' => 'clothing'],
            ['display_name' => 'Clothing']
        );
        
        Category::updateOrCreate(
            ['name' => 'books'],
            ['display_name' => 'Books']
        );
    }
}
