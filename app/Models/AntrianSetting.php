<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianSetting extends Model
{
    use HasFactory;

    protected $table = 'antrian_settings';

    protected $fillable = [
        'is_active',
    ];
}
