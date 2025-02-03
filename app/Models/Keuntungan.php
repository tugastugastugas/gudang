<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keuntungan extends Authenticatable
{
    use HasFactory;

    protected $table = 'keuntungan'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_keuntungan'; // Menetapkan primary key yang benar

 

    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'id_keluar',
        'total_keuntungan',
        'created_at',
        'update_at'
    ];

}
