<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'nis',
        'namalengkap',
        'nomor_anggota',
        'alamat',
        'no_hp',
        'jenis',
        'kelas',
    ];
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }
    
}
