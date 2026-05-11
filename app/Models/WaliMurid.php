<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliMurid extends Model
{
    use HasFactory;

    protected $table = 'wali_murids';

    protected $fillable = [
        'nik',
        'nama',
        'phone',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'jenis_kelamin',
        'agama',
        'pendidikan',
        'pekerjaan'
    ];
}
