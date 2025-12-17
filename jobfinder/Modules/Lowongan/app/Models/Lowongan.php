<?php

namespace Modules\Lowongan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Lowongan\Database\Factories\LowonganFactory;

class Lowongan extends Model
{
    use HasFactory;
        protected $table = 'lowongans';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'posisi',
        'perusahaan',
        'lokasi_kerja',
        'deskripsi',
        'gaji'
    ];


    // protected static function newFactory(): LowonganFactory
    // {
    //     // return LowonganFactory::new();
    // }
}
