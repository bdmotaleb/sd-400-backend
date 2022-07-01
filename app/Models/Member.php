<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'name', 'gender', 'mobile', 'blood_group', 'address', 'photo', 'start_date', 'end_date', 'lock', 'card_no', 'create_by', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'create_by');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'member_id', 'member_id');
    }
}
