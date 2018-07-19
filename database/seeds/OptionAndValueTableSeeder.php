<?php

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionAndValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $option = Option::create(['name' => 'Bottle']);

        $option->values()->createMany([
            [
                'value' => '100 ml Oil',
            ],
            [
                'value' => '200 ml Shampoo',
            ],
        ]);
    }
}
