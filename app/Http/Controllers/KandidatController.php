<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kandidats = Kandidat::with('siswa')->get();
        return view('admin.kandidat.index', compact('kandidats'));
    }

    /**
     * Display a listing of the datatable.
     */
    public function data(Request $request)
    {
        $query = Kandidat::with('siswa');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('foto', function ($kandidat) {
                return ''; // Anda mungkin ingin menampilkan gambar profil di sini
            })
            ->editColumn('siswa', function ($kandidat) {
                return $kandidat->siswa->nama_siswa;
            })
            ->editColumn('tanggal_lahir', function ($kandidat) {
                return $kandidat->siswa->tanggal_lahir_siswa;
            })
            ->editColumn('kelas', function ($kandidat) {
                return '
                    <span class="badge badge-info">Aktif tanpa rombel</span>
                ';
            })
            ->addColumn('aksi', function ($kandidat) {
                return '
            <a href="' . route('kandidat.show', $kandidat->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-search-plus"></i></a>
            <button onclick="deleteData(`' . route('kandidat.destroy', $kandidat->id) . '`, `' . $kandidat->siswa->nama_siswa . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
        ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'siswa_id' => 'required|array',
        ];

        $message = [
            'siswa_id.required' => 'Kandidat wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silahkan periksa kembali inputan anda.'], 422);
        }

        foreach ($request->siswa_id as  $siswaId) {
            Kandidat::updateOrCreate(
                ['siswa_id' => $siswaId,],
                ['siswa_id' => $siswaId]
            );;
        }

        return response()->json(['message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kandidat $kandidat)
    {
        return view('admin.kandidat.show', compact('kandidat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kandidat $kandidat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kandidat $kandidat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kandidat $kandidat)
    {
        $kandidat->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
