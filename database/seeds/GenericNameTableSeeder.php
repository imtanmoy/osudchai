<?php

use App\Models\GenericName;
use Illuminate\Database\Seeder;

class GenericNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GenericName::create(["name" => "Paracetamol"]);
    }
}
