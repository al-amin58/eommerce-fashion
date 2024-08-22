<?php

namespace Database\Seeders;

use App\Http\Helpers\Properties;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Admin",
            "email" => "admin@admin.com",
            "phone" => "01522222235",
            "type" => Properties::$admin,
            "password" => Hash::make(12345678)
        ]);

        User::create([
            "name" => "Customer",
            "email" => "cm@cm.com",
            "phone" => "01655558457",
            "type" => Properties::$customer,
            "password" => Hash::make(12345678)
        ]);

//        User::create([
//            "name" => "Customer 2",
//            "email" => "customer@gmail.com",
//            "phone" => "01655558458",
//            "type" => Properties::$customer,
//            "password" => Hash::make(12345678)
//        ]);
//
//        User::factory()
//            ->count(100)
//            ->hasCustomer(1)
//            ->hasAddresses(5)
//            ->create();
//
//        User::factory()
//            ->count(50)
//            ->hasAddresses(7)
//            ->create();
//
//        User::factory()
//            ->count(100)
//            ->hasCustomer(1)
//            ->hasAddresses(3)
//            ->create();
//
//        User::factory()
//            ->count(10)
//            ->hasCustomer(1)
//            ->create();
    }
}
