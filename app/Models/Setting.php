<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'favicon', 'email', 'mobile', 'fb_link', 'youtube_link', 'create_by'];
}
