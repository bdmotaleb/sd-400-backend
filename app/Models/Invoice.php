<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['member_id', 'start_date', 'end_date', 'amount', 'fee_type', 'payment_type', 'create_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'create_by')->select('id', 'name');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}
