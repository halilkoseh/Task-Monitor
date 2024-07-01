<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{





    public function run(): void
    {

        $user = [

            "name" => "admin",
            "email" => "admin@mfe.com",
            "username" => "admin",
            "gorev" => "admin",
            "password" => bcrypt("password"),
            "is_admin" => 1,



        ];

        User::create($user);



    }
}
