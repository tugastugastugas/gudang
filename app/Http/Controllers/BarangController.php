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
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

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
            'user_id' => Session::get('id'),
            'description' => 'User Menambah Barang.',
        ]);

        try {
            // Validasi input
            $request->validate([
                'nama_barang' => 'required',
                'stok' => 'required',
                'satuan' => 'required',
                'foto_barang' => 'required',
            ]);

            $lastBarang = Barang::orderBy('kode_barang', 'desc')->first();
            $kode_barang = $lastBarang ? 'BRG' . str_pad(((int)substr($lastBarang->kode_barang, 3)) + 1, 7, '0', STR_PAD_LEFT) : 'BRG0000001';

            // Generate QR Code
            $qrCodePath = 'uploads/qrcode/' . $kode_barang . '.png';
            $qrCodeFullPath = public_path($qrCodePath);

            // Buat folder jika belum ada
            if (!file_exists(public_path('uploads/qrcode'))) {
                mkdir(public_path('uploads/qrcode'), 0777, true);
            }

            // Menghasilkan QR Code dengan data kode_barang composer require simplesoftwareio/simple-qrcode
            QrCode::format('png')
                ->size(300) // Ukuran QR Code
                ->errorCorrection('H') // Tingkat koreksi kesalahan (L, M, Q, H)
                ->generate($kode_barang, $qrCodeFullPath); // Menyimpan QR Code ke path yang ditentukan

            // Simpan data barang
            $barang = new Barang();
            $barang->kode_barang = $kode_barang;
            $barang->nama_barang = $request->input('nama_barang');
            $barang->stok = $request->input('stok');
            $barang->satuan = $request->input('satuan');

            if ($request->hasFile('foto_barang')) {
                $foto_barang = $request->file('foto_barang');
                $foto_barang_name = $foto_barang->getClientOriginalName();
                $barang->foto_barang = $foto_barang->storeAs('foto_barang', $foto_barang_name, 'public');
            }

            // Menyimpan path QR Code ke dalam database
            $barang->barcode = $qrCodePath;
            $barang->save();

            return redirect()->back()->with('msg', 'Berhasil Menambahkan Barang.');
        } catch (\Exception $e) {
            Log::error('Gagal : ' . $e->getMessage());
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan barang. Silakan coba lagi.']);
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
        echo view('e_barang', compact('barang'));
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
                'foto_barang' => 'required',
            ]);

            // Mencari buku berdasarkan ID
            $barang = barang::findOrFail($request->input('id'));

            // Update data buku
            $barang->nama_barang = $request->nama_barang;
            $barang->stok = $request->stok;
            $barang->satuan = $request->satuan;

            if ($request->hasFile('foto_barang')) {
                $foto_barang = $request->file('foto_barang');
                $foto_barang_name = $foto_barang->getClientOriginalName();
                $barang->foto_barang = $foto_barang->storeAs('foto_barang', $foto_barang_name, 'public');
            }

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


    public function scan(Request $request)
    {
        $kode_barang = $request->input('kode_barang');

        // Debugging input
        Log::info("Barcode yang diterima: " . $kode_barang);

        // Cek apakah barcode ada di database
        $barang = Barang::where('kode_barang', $kode_barang)->first();

        if ($barang) {
            return redirect()->back()->with('success', 'Barang ditemukan: ' . $barang->nama_barang);
        } else {
            Log::warning("Barcode tidak ditemukan di database: " . $kode_barang);
            return redirect()->back()->withErrors(['msg' => 'Barang tidak ditemukan. Silakan coba lagi.']);
        }
    }

    public function getBarangByKode($kode_barang)
    {
        // Ambil data barang berdasarkan kode_barang
        $barang = Barang::where('kode_barang', $kode_barang)->first();

        if ($barang) {
            // Jika barang ditemukan, kembalikan data dalam format JSON
            return response()->json([
                'nama_barang' => $barang->nama_barang,
                'stok' => $barang->stok,
                'satuan' => $barang->satuan,
                'foto_barang' => $barang->foto_barang, // Jika ada foto, kirimkan URL foto
            ]);
        } else {
            return response()->json(null); // Jika barang tidak ditemukan
        }
    }
}
