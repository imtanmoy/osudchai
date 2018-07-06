<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@osudchai.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('administrator');
    }
}
