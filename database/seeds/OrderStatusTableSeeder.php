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
        factory(OrderStatus::class)->create([
            'name' => 'paid',
            'color' => 'green'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'pending',
            'color' => 'yellow'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'error',
            'color' => 'red'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'on-delivery',
            'color' => 'blue'
        ]);
    }
}
