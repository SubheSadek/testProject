<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'event',
        'app_platform',
        'app_version_code',
        'device',
        'created_at',
        'updated_at',
    ];
}
