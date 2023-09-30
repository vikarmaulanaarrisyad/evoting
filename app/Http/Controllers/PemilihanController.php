<?php

namespace App\Http\Controllers;

use App\Models\Pemilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemilihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.jadwalpemilihan.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $query = Pemilihan::orderBy('id', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('tanggal_pemilihan', function ($query) {
                if ($query->status_pemilihan == 'Selesai') {
                    return tanggal_indonesia($query->tanggal_mulai_pemilihan);
                }
                return tanggal_indonesia($query->tanggal_mulai_pemilihan) . ' <br> <span class="badge badge-info">' . hitung_hari($query->tanggal_mulai_pemilihan, $query->tanggal_selesai_pemilihan) .  '</span>';
            })
            ->addColumn('status_pemilihan', function ($query) {
                return '<span class="badge bg-' . $query->statusColor() . '">' . $query->status_pemilihan . '</span>';
            })
            ->addColumn('aksi', function ($query) {
                // if ($query->status_pemilihan === 'Selesai') {
                //     return '';
                // } else {
                // }
                return '
                <button onclick="editForm(`' . route('pemilihan.show', $query->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="deleteData(`' . route('pemilihan.show', $query->id) . '`, `' . $query->deskripsi_pemilihan . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
            'tanggal_mulai_pemilihan' => 'required|before_or_equal:tanggal_selesai_pemilihan',
            'tanggal_selesai_pemilihan' => 'required',
            'deskripsi_pemilihan' => 'required|min:5',
        ];

        $message = [
            'tanggal_mulai_pemilihan.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai_pemilihan.required' => 'Tanggal selesai wajib diisi.',
            'deskripsi_pemilihan.required' => 'Judul wajib diisi.',
            'deskripsi_pemilihan.min' => 'Judul minimal 5 karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'tanggal_mulai_pemilihan' => $request->tanggal_mulai_pemilihan,
            'tanggal_selesai_pemilihan' => $request->tanggal_selesai_pemilihan,
            'deskripsi_pemilihan' => $request->deskripsi_pemilihan,
        ];

        $result = Pemilihan::create($data);

        return response()->json(['data' => $result, 'message' => 'Data berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemilihan $pemilihan)
    {
        return response()->json(['data' => $pemilihan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemilihan $pemilihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemilihan $pemilihan)
    {
        $rules = [
            'tanggal_mulai_pemilihan' => 'required|before_or_equal:tanggal_selesai_pemilihan|date_format:Y-m-d',
            'tanggal_selesai_pemilihan' => 'required|date_format:Y-m-d',
            'deskripsi_pemilihan' => 'required|min:5',
        ];

        $message = [
            'tanggal_mulai_pemilihan.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai_pemilihan.required' => 'Tanggal selesai wajib diisi.',
            'deskripsi_pemilihan.required' => 'Judul wajib diisi.',
            'deskripsi_pemilihan.min' => 'Judul minimal 5 karakter.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Silakan periksa kembali isian Anda dan coba kembali.'], 422);
        }

        $data = [
            'tanggal_mulai_pemilihan' => $request->tanggal_mulai_pemilihan,
            'tanggal_selesai_pemilihan' => $request->tanggal_selesai_pemilihan,
            'deskripsi_pemilihan' => $request->deskripsi_pemilihan,
            'status_pemilihan' => $request->status_pemilihan,
        ];

        // Cek status pemilihan saat ini
        $cekPemilihan = Pemilihan::findOrfail($pemilihan->id); // Sedang Berlangsung

        if (!$cekPemilihan) {
            return response()->json(['message' => 'Pemilihan tidak ditemukan.'], 404);
        }

        if ($request->status_pemilihan === 'Sedang Berlangsung') {
            // Cek apakah ada pemilihan lain yang sudah berstatus "Sedang Berlangsung"
            $PemilihanCount = Pemilihan::where('status_pemilihan', 'Sedang Berlangsung')->count();

            if ($PemilihanCount > 0) {
                return response()->json(['message' => 'Ada pemilihan lain yang sedang berlangsung, sehingga tidak dapat memulai pemilihan baru.'], 422);
            }
        }

        $cekPemilihan->update($data);

        return response()->json(['data' => $cekPemilihan, 'message' => 'Status pemilihan berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemilihan $pemilihan)
    {
        if ($pemilihan->status_pemilihan === 'Selesai') {
            return response()->json(['message' => 'Pemilihan ini ' . $pemilihan->status_pemilihan . ' , sehingga tidak dapat dihapus.'], 422);
        }

        if ($pemilihan->status_pemilihan === 'Sedang Berlangsung') {
            return response()->json(['message' => 'Pemilihan ini ' . $pemilihan->status_pemilihan . ' , sehingga tidak dapat dihapus.'], 422);
        }

        $pemilihan->delete();

        return response()->json(['data' => NULL, 'message' => 'Pemilihan berhasil dihapus']);
    }
}
