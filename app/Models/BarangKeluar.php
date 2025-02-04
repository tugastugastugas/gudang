<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluar extends Authenticatable
{
    use HasFactory;

    protected $table = 'barang_keluar'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_keluar'; // Menetapkan primary key yang benar

 

    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'id_barang',
        'pembeli',
        'jumlah',
        'harga_jual',
        'total_harga',
        'tanggal_keluar',
        'created_at',
        'update_at'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

}
