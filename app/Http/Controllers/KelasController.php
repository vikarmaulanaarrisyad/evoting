<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kelas.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function data()
    {
        $query = Kelas::orderBy('kelas', 'ASC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('jumlah_siswa', function ($query) {
                return '';
            })
            ->addColumn('aksi', function ($query) {
                return '
                <button onclick="editForm(`' . route('kelas.show', $query->id) . '`)" class="btn btn-sm bg-indigo"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="deleteData(`' . route('kelas.destroy', $query->id) . '`, `' . $query->nama_kelas . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
            'nama_kelas' => 'required',
            'kelas' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'nama_kelas' => $request->nama_kelas,
            'kelas' => $request->kelas,
        ];

        Kelas::create($data);

        return response()->json(['data' => $data, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kelas = Kelas::findOrfail($id);

        return response()->json(['data' => $kelas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'nama_kelas' => 'required',
            'kelas' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'nama_kelas' => $request->nama_kelas,
            'kelas' => $request->kelas,
        ];

        $kelas = Kelas::findOrfail($id);

        $kelas->update($data);

        return response()->json(['data' => $data, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrfail($id);

        $kelas->delete();

        return response()->json(['data' => NULL, 'message' => 'Data berhasil dihapus.']);
    }
}
