<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotDetection extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'route',
    ];
}
