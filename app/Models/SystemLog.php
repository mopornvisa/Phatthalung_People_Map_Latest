<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $connection = 'mysql_help';
    protected $table = 'system_logs';

    protected $fillable = [
        'user_id',
        'username',
        'role',
        'agency',
        'action',
        'detail',
        'ip_address',
        'user_agent',
    ];
}