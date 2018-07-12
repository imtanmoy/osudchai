<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $users = array(
            ['name' => 'Tanmoy Banik', 'email' => 'imtanmoybanik@gmail.com', 'password' => bcrypt('123456'), 'is_verified' => 1],
            ['name' => 'Alpo Banik', 'email' => 'alpobanik@gmail.com', 'password' => bcrypt('123456'), 'is_verified' => 1],
        );
        foreach ($users as $user) {
            $newer = User::create($user);
            $newer->customerGroup()->attach(1);
        }
    }
}
