<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class DataController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function data()
    {
        // Log aktivitas
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Data.',
        ]);

        // Ambil id user dari session
        $userId = Session::get('id');

        // Query untuk menghitung keuntungan dan kerugian per barang
        $data = DB::table('barang as b')
            ->leftJoin('barang_masuk as bm', 'b.id_barang', '=', 'bm.id_barang')
            ->leftJoin('barang_keluar as bk', 'b.id_barang', '=', 'bk.id_barang')
            ->select(
                'b.kode_barang',
                'b.id_barang',
                'b.nama_barang',
                'bk.pembeli',
                DB::raw('COALESCE(SUM(bm.total_harga), 0) as total_harga_beli'),
                DB::raw('COALESCE(SUM(bk.total_harga), 0) as total_harga_jual'),
                DB::raw('(COALESCE(SUM(bk.total_harga), 0) - COALESCE(SUM(bm.total_harga), 0)) as keuntungan_kerugian')
            )
            ->groupBy('b.id_barang', 'b.nama_barang', 'b.kode_barang', 'bk.pembeli')
            ->get();

        // Tampilkan view dengan data yang telah diambil
        echo view('header');
        echo view('menu');
        echo view('data', compact('data'));
        echo view('footer');
    }

    public function laporan()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Laporan.',
        ]);

        // Ambil id user dari session
        $userId = Session::get('id');

        // Tampilkan view dengan data yang telah diambil
        echo view('header');
        echo view('menu');
        echo view('laporan');
        echo view('footer');
    }

    public function index(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal', '2000-01-01'); // Default tanggal jika tidak diisi
        $tanggal_akhir = $request->input('tanggal_akhir', date('Y-m-d')); // Default tanggal sekarang

        $query = "
            SELECT 
                b.kode_barang,
                b.id_barang,
                b.nama_barang,
                bk.pembeli,
                COALESCE(SUM(bm.total_harga), 0) AS total_harga_beli,
                COALESCE(SUM(bk.total_harga), 0) AS total_harga_jual,
                (COALESCE(SUM(bk.total_harga), 0) - COALESCE(SUM(bm.total_harga), 0)) AS keuntungan_kerugian
            FROM 
                barang b
            LEFT JOIN 
                barang_masuk bm ON b.id_barang = bm.id_barang 
                AND bm.tanggal_masuk BETWEEN ? AND ?
            LEFT JOIN 
                barang_keluar bk ON b.id_barang = bk.id_barang 
                AND bk.tanggal_keluar BETWEEN ? AND ?
            GROUP BY 
                b.id_barang, b.nama_barang, b.kode_barang, bk.pembeli
        ";
        $data = DB::select($query, [$tanggal_awal, $tanggal_akhir, $tanggal_awal, $tanggal_akhir]);
        $pdf = PDF::loadView('laporan.index', compact('data', 'tanggal_awal', 'tanggal_akhir'));
        return $pdf->stream('Laporan_Keuangan.pdf');
    }
}
