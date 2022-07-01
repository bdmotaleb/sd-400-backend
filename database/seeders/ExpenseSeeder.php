<?php

namespace Database\Seeders;

use App\Models\Expense;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $type  = ['regular', 'fixed', 'investment'];

        foreach (range(1, 25) as $item) {
            Expense::create([
                'name'      => substr($faker->text, 0, 20),
                'amount'    => rand(500, 1000),
                'date'      => date('Y-m-d'),
                'type'      => $type[array_rand($type)],
                'create_by' => rand(1, 5),
            ]);
        }
    }
}
