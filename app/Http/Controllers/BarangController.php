<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function Barang()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Barang.',
        ]);

        $userId = Session::get('id'); // Ambil id user dari session

        $barang = barang::all();

        echo view('header');
        echo view('menu');
        echo view('barang', compact('barang'));
        echo view('footer');
    }

    public function t_barang(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menambah Barang.',
        ]);

        try {
            // Validasi inputan
            $request->validate([
                'nama_barang' => 'required',
                'stok' => 'required',
                'satuan' => 'required',
            ]);
            
            $lastBarang = Barang::orderBy('kode_barang', 'desc')->first();

            if ($lastBarang) {
                // Ambil angka dari kode terakhir dan tambahkan 1
                $lastNumber = (int) substr($lastBarang->kode_barang, 3);
                $newNumber = $lastNumber + 1;
                $kode_barang = 'BRG' . str_pad($newNumber, 7, '0', STR_PAD_LEFT);
            } else {
                // Jika belum ada data, mulai dari BRG0000001
                $kode_barang = 'BRG0000001';
            }
            $id_user = Session::get('id');
            // Ambil kelas pengguna berdasarkan id_user
       
            // Simpan data ke tabel user
            $barang = new barang(); // Ubah variabel dari $quiz menjadi $barang untuk kejelasan
            $barang->kode_barang = $kode_barang; 
            $barang->nama_barang = $request->input('nama_barang');
            $barang->stok = $request->input('stok');
            $barang->satuan = $request->input('satuan');

            // Simpan ke database
            $barang->save();


            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            Log::error('Gagal : ' . $e->getMessage());
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }


    public function barang_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Barang.',
        ]);
        // Cari data user berdasarkan ID
        $barang = barang::findOrFail($id);

        $barang->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data user berhasil dihapus');
    }

    public function e_barang($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Edit Barang.',
        ]);

        // Mencari pengguna berdasarkan ID
        $barang = barang::findOrFail($id);

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('e_barang', compact( 'barang'));
        echo view('footer');
    }

    public function updateDetail(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Mengupdate Barang.',
        ]);

        try {
            // Validasi input
            $request->validate([
                'nama_barang' => 'required',
                'stok' => 'required',
                'satuan' => 'required',
            ]);

            // Mencari buku berdasarkan ID
            $barang = barang::findOrFail($request->input('id'));

            // Update data buku
            $barang->nama_barang = $request->nama_barang;
            $barang->stok = $request->stok;
            $barang->satuan = $request->satuan;
         

            // Simpan perubahan
            $barang->save();
            // Redirect dengan pesan sukses
            return redirect()->route('barang', $barang->id)->with('success', 'Detail pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memperbarui detail pengguna: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui detail pengguna. Silakan coba lagi.']);
        }
    }

   

}
