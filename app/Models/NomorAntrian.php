<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorAntrian extends Model
{
    use HasFactory;

    protected $table = 'nomorantrian';

    protected $fillable = ['nama', 'nik', 'ruangan', 'nomor', 'status', 'waktu', 'prioritas', 'status_prioritas', 'waktu_dilayani', 'waktu_total_sistem', 'riwayat_waktu'];

    protected $casts = [
        'status_prioritas' => 'array',
        'riwayat_waktu' => 'array',
    ];

}
