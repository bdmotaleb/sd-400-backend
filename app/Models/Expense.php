<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'amount', 'date', 'type', 'create_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'create_by');
    }
}
