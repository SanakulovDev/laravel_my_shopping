<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    //
    protected $fillable = [
        'id',
        'region_id',
        'name_uz',
        'name_oz',
        'name_ru',
        'created_at',
        'updated_at',
    ];
}
