<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthNcd extends Model
{
    protected $connection = 'mysql_help';
    protected $table = 'health_ncd_major_all';
    public $timestamps = false;
}