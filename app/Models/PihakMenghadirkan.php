<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PihakMenghadirkan extends Model
{
    use HasFactory;

    protected $table = 'pihak_menghadirkan';

    protected $fillable = [
        "no_perkara",
        'jenis_perdata',
        'pihak',
        'nama',
        'no_telp',
        'jumlah_saksi',
        "hadir",
    ];
}






