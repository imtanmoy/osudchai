<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $this->call(UsersTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(ManufacturerTableSeeder::class);
        $this->call(ProductTypeTableSeeder::class);
        $this->call(CategoryTableSeeder::class);

        Model::reguard();
    }
}
