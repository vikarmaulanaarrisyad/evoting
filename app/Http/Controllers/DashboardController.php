<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            $jumlahPemilih = Siswa::count();
            $pemilihBelumMemilih = Siswa::where('status_pemilihan_siswa', 'Belum Memilih')->count();
            $pemilihSudahMemilih = Siswa::where('status_pemilihan_siswa', 'Sudah Memilih')->count();
            $jumlahKandidat = Kandidat::count();

            return view('admin.dashboard.index', compact('jumlahPemilih', 'jumlahKandidat', 'pemilihBelumMemilih', 'pemilihSudahMemilih'));
        } else if (auth()->user()->hasRole('panitia')) {
            return view('panitia.dashboard.index');
        } else {
            return view('pemilih.dashboard.index');
        }
    }
}
