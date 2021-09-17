<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\DeliveryMan;
use App\Models\User;
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
        User::create([
            "name" => "User 1",
            "email" => "user1@gmail.com",
            "phone_number" => "08928663354",
            "password" => bcrypt(123123),
        ]);

        Admin::create([
            "username" => "admin1",
            "password" => bcrypt(123123),
        ]);

        DeliveryMan::create([
            "username" => "delivery1",
            "name" => "John Doe d1",
            "phone_number" => "08928663354",
            "password" => bcrypt(123123),
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
