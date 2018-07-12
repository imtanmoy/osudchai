<?php

use App\Models\CustomerGroup;
use Illuminate\Database\Seeder;

class CustomerGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerGroup::create(["name"=> "Default", "description"=>"Default group for all customers"]);
    }
}
