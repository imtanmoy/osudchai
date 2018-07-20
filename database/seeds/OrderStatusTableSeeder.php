<?php

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'name' => 'paid',
            'color' => 'green'
        ]);

        OrderStatus::create([
            'name' => 'pending',
            'color' => 'yellow'
        ]);

        OrderStatus::create([
            'name' => 'error',
            'color' => 'red'
        ]);

        OrderStatus::create([
            'name' => 'on-delivery',
            'color' => 'blue'
        ]);
    }
}
