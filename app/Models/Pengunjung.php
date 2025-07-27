<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    protected $table = 'pengunjung';

    protected $fillable = [
        'name',
        'type',
        'kelas',
        'tujuan',
        'waktu_kunjung',
        'alamat',
        'kesan_pesan',
    ];
}
