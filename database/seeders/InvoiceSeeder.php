<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fee_type     = ['admission', 'monthly', 'package'];
        $payment_type = ['bKash', 'Cash', 'Card', 'Rocket'];

        foreach (range(1, 100) as $item) {
            Invoice::create([
                'member_id'    => date('Y') . str_pad(rand(1, 100), 6, 0, STR_PAD_LEFT),
                'start_date'   => date('Y-m-d'),
                'end_date'     => date('Y-m-d', strtotime('+3 month')),
                'amount'       => rand(500, 1000),
                'fee_type'     => $fee_type[array_rand($fee_type)],
                'payment_type' => $payment_type[array_rand($payment_type)],
                'create_by'    => rand(1, 6)
            ]);
        }
    }
}
