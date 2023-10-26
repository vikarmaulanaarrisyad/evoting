<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.siswa.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function data()
    {
        $query = Siswa::orderBy('nama_siswa', 'ASC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('umur', function ($query) {
                return hitung_umur($query->tanggal_lahir_siswa);
            })
            ->addColumn('kelas', function ($query) {
                return '
                    <span class="badge badge-info">Aktif tanpa rombel</span>
                ';
            })
            ->editColumn('status_pemilihan_siswa', function ($query) {
                return '
                    <span class="badge bg-' . $query->statusColor() . '">' . $query->status_pemilihan_siswa . '</span>
                ';
            })
            ->addColumn('aksi', function ($query) {
                return '
                <button class="btn btn-sm btn-primary" onclick=editForm(`' . route('siswa.show', $query->id) . '`)><i class="fa fa-search" aria-hidden="true"></i></button>
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
            'nama_siswa' => 'required',
            'nisn_siswa' => 'required|unique:siswas,nisn_siswa',
            'nis_siswa' => 'required|unique:siswas,nis_siswa',
            'tempat_lahir_siswa' => 'required',
            'tanggal_lahir_siswa' => 'required',
            'email' => 'required|unique:users,email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silahkan periksa kembali isian anda.'], 422);
        }

        try {
            DB::beginTransaction();
            //insert to users table
            $user = new User;

            $user->name = $request->nama_siswa;
            $user->email = $request->email;
            $user->username = $request->nisn_siswa;
            $user->password = Hash::make($request->nisn_siswa);
            $user->role_id = 3;
            $user->save();

            //inset to siswas table
            $siswa = new Siswa;
            $siswa->user_id = $user->id;
            $siswa->nama_siswa = $request->nama_siswa;
            $siswa->nisn_siswa = $request->nisn_siswa;
            $siswa->nis_siswa = $request->nis_siswa;
            $siswa->tempat_lahir_siswa = $request->tempat_lahir_siswa;
            $siswa->tanggal_lahir_siswa = $request->tanggal_lahir_siswa;
            $siswa->save();

            DB::commit();

            return response()->json(['data' => $siswa, 'message' => 'Data berhasil disimpan.']);
        } catch (\Throwable $th) {
            return $th;
            DB::rollBack();
            return response()->json(['errors' => $th, 'message' => 'Data gagal disimpan'], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $rules = [
            'nama_siswa' => 'required',
            'nisn_siswa' => 'required|unique:siswas,nisn_siswa',
            'nis_siswa' => 'required|unique:siswas,nis_siswa',
            'tempat_lahir_siswa' => 'required',
            'tanggal_lahir_siswa' => 'required',
            'email' => 'required|unique:users,email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silahkan periksa kembali isian anda.'], 422);
        }

        try {
            DB::beginTransaction();
            // Update to siswa table

            DB::commit();

            return response()->json(['data' => $siswa, 'message' => 'Data berhasil disimpan.']);
        } catch (\Throwable $th) {
            return $th;
            DB::rollBack();
            return response()->json(['errors' => $th, 'message' => 'Data gagal disimpan'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $user = User::where('id', $siswa->user_id)->first();

        $siswa->delete();
        $user->delete();

        return response()->json(['data' => $siswa, 'message' => 'Data berhasil dihapus.']);
    }

    /**
     * Import File Excel
     */

    public function importExcel(Request $request)
    {
        // validasi inputan
        $rules = [
            'upload' => 'required|mimes:xls,xlsx,csv',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Gagal di unggah, silahkan cek kembali file unggahan anda.'], 422);
        }

        // mendapatkan file input
        $file = $request->file('upload');

        Excel::import(new SiswaImport, $file);

        return response()->json(['message' => 'Data berhasil diunggah']);
    }
}
