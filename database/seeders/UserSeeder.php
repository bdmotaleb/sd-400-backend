<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $faker = Factory::create();

        User::create([
            "name"     => "Motaleb Hossain",
            "email"    => "admin@gmail.com",
            "avatar"   => $faker->imageUrl,
            "password" => Hash::make(123456)
        ]);

        foreach (range(1, 25) as $item) {
            User::create([
                "name"     => $faker->name,
                "email"    => $faker->unique()->email,
                "avatar"   => $faker->imageUrl,
                "password" => Hash::make(123456)
            ]);
        }

        DB::table('oauth_clients')->insert([
            "name"                   => "Laravel Personal Access Client",
            "secret"                 => "MxurHrbC8w8HwnrKEOj5h141SScfv74etuUELZ75",
            "provider"               => null,
            "redirect"               => "http://127.0.0.1:8000",
            "personal_access_client" => "1",
            "password_client"        => "0",
            "revoked"                => "0",
        ]);
        DB::table('oauth_clients')->insert([
            "name"                   => "Laravel Password Grant Client",
            "secret"                 => "3tya91HmOnWhFAEFJoeOESL7IiWHsEkDhjb4wq7n",
            "provider"               => "users",
            "redirect"               => "http://127.0.0.1:8000",
            "personal_access_client" => "0",
            "password_client"        => "1",
            "revoked"                => "0",
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            "client_id" => 1
        ]);
    }
}
