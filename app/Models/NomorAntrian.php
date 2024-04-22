<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorAntrian extends Model
{
    use HasFactory;

    protected $table = 'nomorantrian';

    protected $fillable = ['nama', 'nik', 'ruangan', 'nomor', 'status', 'waktu', 'prioritas', 'status_prioritas'];

    protected $casts = [
        'status_prioritas' => 'array',
    ];
}
