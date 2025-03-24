<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    protected $fillable = [
        'id',
        'name_uz',
        'name_oz',
        'name_ru',
        'created_at',
        'updated_at',
    ];
}
