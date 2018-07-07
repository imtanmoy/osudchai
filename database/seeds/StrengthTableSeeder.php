<?php

use App\Models\Strength;
use Illuminate\Database\Seeder;

class StrengthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Strength::create(["value" => "5mg"]);
    }
}
