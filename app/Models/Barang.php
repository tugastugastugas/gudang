<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Authenticatable
{
    use HasFactory;

    protected $table = 'barang'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_barang'; // Menetapkan primary key yang benar

 

    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'nama_barang',
        'stok',
        'satuan',
        'foto_barang',
        'created_at',
        'update_at',
    ];
    public function barang_masuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang', 'id_barang');
    }

    public function barang_keluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_barang', 'id_barang');
    }
}
