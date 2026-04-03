<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $connection = 'sqlsrv';   // ✅ ใช้ SQL Server
    protected $table = 'register';
    protected $primaryKey = 'register_Id';

    public $timestamps = false; // 👉 ถ้าไม่มี created_at / updated_at ให้ใช้ false

    protected $fillable = [
        'register_User',
        'register_Password',
        'register_Name',
        'register_Same',
        'register_Number',
        'register_Phone',
        'register_Gmail',
        'register_Type',
    ];
}