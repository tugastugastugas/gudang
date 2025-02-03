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
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangKeluarController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function BarangKeluar()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke BarangKeluar.',
        ]);

        $userId = Session::get('id'); // Ambil id user dari session

        $BarangKeluar = BarangKeluar::with('barang')->get();
        $barang = barang::all();

        echo view('header');
        echo view('menu');
        echo view('BarangKeluar', compact('BarangKeluar', 'barang'));
        echo view('footer');
    }

    public function t_BarangKeluar(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menambah Barang Keluar.',
        ]);

        try {
            // Validasi inputan
            $request->validate([
                'id_barang' => 'required',
                'harga_jual' => 'required',
                'jumlah' => 'required',
                'tanggal_keluar' => 'required',
            ]);

            $id_user = Session::get('id');
            // Ambil kelas pengguna berdasarkan id_user
       
            // Simpan data ke tabel user
            $BarangKeluar = new BarangKeluar(); // Ubah variabel dari $quiz menjadi $barang untuk kejelasan
            $BarangKeluar->id_barang = $request->input('id_barang');
            $BarangKeluar->harga_jual = $request->input('harga_jual');
            $BarangKeluar->jumlah = $request->input('jumlah');
            $BarangKeluar->tanggal_keluar = $request->input('tanggal_keluar');

            $jumlah = $request->input('jumlah');
            $harga = $request->input('harga_jual');

            $BarangKeluar->total_harga = $jumlah * $harga;


            // Simpan ke database
            $BarangKeluar->save();


            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            Log::error('Gagal : ' . $e->getMessage());
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }


    public function BarangKeluar_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Barang Keluar.',
        ]);
        // Cari data user berdasarkan ID
        $BarangKeluar = BarangKeluar::findOrFail($id);

        $BarangKeluar->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data user berhasil dihapus');
    }

    public function e_BarangKeluar($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Edit Barang Keluar.',
        ]);

        // Mencari pengguna berdasarkan ID
        $BarangKeluar = BarangKeluar::with('barang')->findOrFail($id);

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('e_BarangKeluar', compact( 'BarangKeluar'));
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
                'harga_jual' => 'required',
                'jumlah' => 'required',
                'tanggal_keluar' => 'required',
            ]);

            // Mencari buku berdasarkan ID
            $BarangKeluar = BarangKeluar::findOrFail($request->input('id'));

            // Update data buku
            $BarangKeluar->harga_jual = $request->harga_jual;
            $BarangKeluar->jumlah = $request->jumlah;
            $BarangKeluar->tanggal_keluar = $request->tanggal_keluar;

            $jumlah = $request->input('jumlah');
            $harga = $request->input('harga_jual');

            $BarangKeluar->total_harga = $jumlah * $harga;


            // Simpan perubahan
            $BarangKeluar->save();
            // Redirect dengan pesan sukses
            return redirect()->route('BarangKeluar', $BarangKeluar->id)->with('success', 'Detail pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memperbarui detail pengguna: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui detail pengguna. Silakan coba lagi.']);
        }
    }

    

}
