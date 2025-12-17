<?php

namespace Modules\Lowongan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Lowongan\Database\Factories\DaftarFactory;

class daftar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [ 
        'posisi',
        'perusahaan',
        'lokasi_kerja',
        'deskripsi',
        'gaji',
    ];

    // protected static function newFactory(): DaftarFactory
    // {
    //     // return DaftarFactory::new();
    // }
}
