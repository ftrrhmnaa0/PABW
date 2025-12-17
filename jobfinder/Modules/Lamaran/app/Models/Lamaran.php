<?php

namespace Modules\Lamaran\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Lamaran\Database\Factories\LamaranFactory;

class Lamaran extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'lamarans';

    protected $fillable = [
        'user_id',
        'lowongan_id',
        'deskripsi_lamaran',
        'cv_file'
    ];

     public function lowongan()
    {
        return $this->belongsTo(
            \Modules\Lowongan\Models\Lowongan::class
        );
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // protected static function newFactory(): LamaranFactory
    // {
    //     // return LamaranFactory::new();
    // }
}

