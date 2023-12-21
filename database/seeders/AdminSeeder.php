<?php

namespace Database\Seeders;

use App\Libs\Enums\RoleEnum;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'full_name' => 'Meremco Admin',
                'email' => 'admin@miremco.com',
                'password' => bcrypt('Password@123'),
                'phone_number' => '+2348100788859',
                'address' => 'Plot 43 FCT Abuja',
                'role' => RoleEnum::ADMIN
            ]
        ];
        collect($users)->each(function($user) {
            $create = (new \App\Models\User)->create([
                "email" =>  $user['email'],
                "password" =>  $user['password'],
                "email_verified_at"=>  now(),
                "role" =>  $user['role'],
            ]);
            $admin = (new \App\Models\Admin)->create([
                'user_id' => $create->id,
                'full_name' => $user['full_name'],
                'address' => $user['address'],
                'phone_number' => $user['phone_number'],
                'profile_image' =>  'https://res.cloudinary.com/meremco/image/upload/v1669888464/vhvcc7k5k2htninwyoxg.jpg'
            ]);
        });
    }

}
