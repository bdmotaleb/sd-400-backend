<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $member       = Member::all();
        $expenseMonth = Expense::whereMonth('created_at', date('m'))->get();
        $incomeMonth  = Invoice::whereMonth('created_at', date('m'))->get();
        $incomeToDay  = Invoice::whereDate('created_at', date('Y-m-d'))->get();

        $data = [
            [
                'title'  => 'Active Members',
                'icon'   => 'people_alt',
                'value'  => $member->where('status', 'active')->count()
            ],
            [
                'title'  => 'Expired Members',
                'icon'   => 'people_alt',
                'value'  => $member->where('status', 'expired')->count()
            ],
            [
                'title'  => 'Locked Members',
                'icon'   => 'people_alt',
                'value'  => $member->where('status', 'locked')->count()
            ],
            [
                'title'  => 'Limited Members',
                'icon'   => 'people_alt',
                'value'  => $member->where('status', 'limited')->count()
            ],
            [
                'title'  => 'Total Members',
                'icon'   => 'people_alt',
                'value'  => $member->count()
            ],
            [
                'title'  => 'Today Collection',
                'icon'   => 'attach_money',
                'value'  => $incomeToDay->sum('amount')
            ],
            [
                'title'  => date('F') . ' Collection',
                'icon'   => 'attach_money',
                'value'  => $incomeMonth->sum('amount')
            ],
            [
                'title'  => date('F') . ' Expenses',
                'icon'   => 'attach_money',
                'value'  => $expenseMonth->sum('amount')
            ]
        ];

        return success_response((object) $data);
    }
}
