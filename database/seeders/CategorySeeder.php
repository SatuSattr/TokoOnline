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
        Category::create([
            'name' => 'electronics',
            'display_name' => 'Electronics'
        ]);
        
        Category::create([
            'name' => 'sports',
            'display_name' => 'Sports'
        ]);
        
        Category::create([
            'name' => 'clothing',
            'display_name' => 'Clothing'
        ]);
        
        Category::create([
            'name' => 'books',
            'display_name' => 'Books'
        ]);
    }
}
