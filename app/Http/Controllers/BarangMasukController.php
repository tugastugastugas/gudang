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
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangMasukController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function BarangMasuk()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke BarangMasuk.',
        ]);

        $userId = Session::get('id'); // Ambil id user dari session

        $BarangMasuk = BarangMasuk::with('barang')->get();
        $barang = barang::all();

        echo view('header');
        echo view('menu');
        echo view('BarangMasuk', compact('BarangMasuk', 'barang'));
        echo view('footer');
    }

    public function t_BarangMasuk(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menambah Barang Masuk.',
        ]);

        try {
            // Validasi inputan
            $request->validate([
                'id_barang' => 'required',
                'harga_beli' => 'required',
                'jumlah' => 'required',
                'tanggal_masuk' => 'required',
            ]);

            $id_user = Session::get('id');
            // Ambil kelas pengguna berdasarkan id_user
       
            // Simpan data ke tabel user
            $BarangMasuk = new BarangMasuk(); // Ubah variabel dari $quiz menjadi $barang untuk kejelasan
            $BarangMasuk->id_barang = $request->input('id_barang');
            $BarangMasuk->harga_beli = $request->input('harga_beli');
            $BarangMasuk->jumlah = $request->input('jumlah');
            $BarangMasuk->tanggal_masuk = $request->input('tanggal_masuk');

            $jumlah = $request->input('jumlah');
            $harga = $request->input('harga_beli');

            $BarangMasuk->total_harga = $jumlah * $harga;


            // Simpan ke database
            $BarangMasuk->save();


            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            Log::error('Gagal : ' . $e->getMessage());
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }


    public function BarangMasuk_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Barang.',
        ]);
        // Cari data user berdasarkan ID
        $BarangMasuk = BarangMasuk::findOrFail($id);

        $BarangMasuk->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data user berhasil dihapus');
    }

    public function e_BarangMasuk($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Edit Barang.',
        ]);

        // Mencari pengguna berdasarkan ID
        $BarangMasuk = BarangMasuk::with('barang')->findOrFail($id);

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('e_BarangMasuk', compact( 'BarangMasuk'));
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
                'harga_beli' => 'required',
                'jumlah' => 'required',
                'tanggal_masuk' => 'required',
            ]);

            // Mencari buku berdasarkan ID
            $BarangMasuk = BarangMasuk::findOrFail($request->input('id'));

            // Update data buku
            $BarangMasuk->harga_beli = $request->harga_beli;
            $BarangMasuk->jumlah = $request->jumlah;
            $BarangMasuk->tanggal_masuk = $request->tanggal_masuk;

            $jumlah = $request->input('jumlah');
            $harga = $request->input('harga_beli');

            $BarangMasuk->total_harga = $jumlah * $harga;


            // Simpan perubahan
            $BarangMasuk->save();
            // Redirect dengan pesan sukses
            return redirect()->route('BarangMasuk', $BarangMasuk->id)->with('success', 'Detail pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memperbarui detail pengguna: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui detail pengguna. Silakan coba lagi.']);
        }
    }

    

}
