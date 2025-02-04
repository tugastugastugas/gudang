<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Authenticatable
{
    use HasFactory;

    protected $table = 'barang_masuk'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_masuk'; // Menetapkan primary key yang benar

 

    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'id_barang',
        'supplier',
        'jumlah',
        'harga_beli',
        'total_harga',
        'tanggal_masuk',    
        'keterangan',
        'created_at',
        'update_at'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
