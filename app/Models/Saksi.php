<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saksi extends Model
{
    use HasFactory;

    protected $table = 'saksis';

    protected $fillable = [
        "agenda",
        'jenis_pidana',
        'no_perkara',
        'pihak_menghadirkan',
        'pihak',
        'nama_badan_hukum',
        "nama",
        "nomor_telepon",
        "tanggal",
    ];
}





