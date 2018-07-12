<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CityAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city = City::create(['name' => 'Dhaka']);

        $city->areas()->createMany([
            [
                'name' => 'Dhanmondi',
            ],
            [
                'name' => 'Mirpur',
            ],
        ]);
    }
}
