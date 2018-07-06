<?php

use Illuminate\Database\Seeder;

class ManufacturerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('manufacturers')->insert([
            'name' => 'Square Pharma',
            'phone' => '5555555',
            'email' => 'something@squre.com',
            'address' => 'Dhaka'
        ]);
    }
}
