<?php

namespace Database\Seeders;

use App\Models\Setting;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Setting::create([
            'name'      => "Super Fit GYM",
            'logo'      => $faker->imageUrl,
            'favicon'   => $faker->imageUrl,
            'email'     => "gym@gym.com",
            'mobile'    => "01700000000",
            'create_by' => 1
        ]);
    }
}
