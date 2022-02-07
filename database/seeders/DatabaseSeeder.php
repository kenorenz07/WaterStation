<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Container;
use App\Models\DeliveryMan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

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
            "purok" => "purok 2",
            "image" => "cus_1643027079.jpeg",
            "brgy" => "brgy 2",
            "landmark" => "Mcdo",
            "city" => "Calbayog",
            "additional_address" => "additional_address 2",
            "password" => bcrypt(123123),
        ]);

        User::create([
            "name" => "Romnick Cian B. Jaropojop",
            "email" => "jromnick_cian@yahoo.com",
            "phone_number" => "09975882350",
            "image" => "cus_1643099198.jpeg",
            "purok" => "P-3",
            "city" => "Calbayog",
            "landmark" => "Near Crispy King",
            "brgy" => "Matobato",
            "additional_address" => "none",
            "password" => bcrypt(123123),
        ]);
        
        Admin::create([
            "username" => "admin1",
            "password" => bcrypt(123123),
        ]);

        Admin::create([
            "username" => "administrator",
            "password" => bcrypt(123123),
        ]);

        DeliveryMan::create([
            "username" => "delivery1",
            "name" => "John Doe d1",
            "phone_number" => "08928663354",
            "image" => "1635179660.jpeg",
            "password" => bcrypt(123123),
        ]);

        for($i = 1; $i <=10;$i++){
            Product::create([
                "name" => "product_".$i,
                "price" => $i + .01,
                //"image" => "pro_1643027575.jpeg",
                "description" => "size 1x".$i,
            ]);
        }
        Artisan::call('passport:install');
        Artisan::call('storage:link');
        Artisan::call('key:generate');
        // \App\Models\User::factory(10)->create();
    }
}
