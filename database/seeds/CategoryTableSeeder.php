<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Pharmacy',
            'children' => [
                ['name' => 'Medicine'],
                ['name' => 'Equipment'],
            ],
        ]);
    }
}
