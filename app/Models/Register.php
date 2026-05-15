<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $connection = 'mysql_help';

    protected $table = 'registers';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [

        'register_User',
        'register_Password',

        'register_Name',
        'register_Same',

        'register_Number',
        'register_Phone',
        'register_Gmail',

        'register_Type',
        'register_Agency',

        // เพิ่มตรงนี้
        'register_Status',
    ];
}