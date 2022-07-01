<?php

namespace Database\Seeders;

use App\Models\Member;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker  = Factory::create();
        $gender = ['male', 'female'];
        $status = ['active', 'expired', 'locked', 'limited'];

        foreach (range(1, 100) as $item) {
            Member::create([
                'create_by'   => rand(1, 6),
                'name'        => $faker->name,
                'address'     => $faker->address,
                'photo'       => $faker->imageUrl,
                'blood_group' => $faker->bloodGroup(),
                'status'      => $status[array_rand($status)],
                'gender'      => $gender[array_rand($gender)],
                'mobile'      => '01' . rand(3, 9) . rand(00000000, 99999999),
                'member_id'   => date('Y') . str_pad($item, 6, 0, STR_PAD_LEFT),
            ]);
        }
    }
}
