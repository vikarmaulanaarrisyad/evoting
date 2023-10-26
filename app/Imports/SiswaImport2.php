<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            $user =  new User([
                'name'     => $row['nama'],
                'username'     => $row['nisn_siswa'],
                'email'    => $row['email'],
                'password' => Hash::make($row['nisn_siswa']),
                'role_id' => 3,
            ]);
            // Simpan user ke database
            $user->save();

            $siswa = new Siswa([
                'user_id'     => $user->id,
                'nama_siswa'    => $row['nama'],
                'nisn_siswa'    => $row['nisn_siswa'],
                'nis_siswa' => $row['nis_siswa'],
                'tingkat_siswa' => $row['tingkat'],
                'tempat_lahir_siswa' => $row['tempat_lahir'],
                'tanggal_lahir_siswa' => $row['tanggal_lahir'],
                'status_pemilihan_siswa' => 'Belum Memilih',
            ]);

            // Simpan siswa ke database
            $siswa->save();


            // Jika semuanya berjalan dengan baik, Anda dapat melakukan commit
            DB::commit();
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
        }
    }
}
