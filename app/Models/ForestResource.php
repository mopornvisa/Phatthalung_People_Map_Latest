<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestResource extends Model
{
    protected $connection = 'mysql_help';

    protected $table = 'forest_resources';

    protected $fillable = [
        'forest_name',
        'forest_count',
        'forest_area',
    ];
}