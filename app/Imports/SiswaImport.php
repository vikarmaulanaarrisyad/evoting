<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $tanggal_lahir = $row['tanggal_lahir'];
            $tanggal_lahir_valid = date("Y-m-d", strtotime($tanggal_lahir));

            $user =  User::create([
                'name'     => $row['nama'],
                'username'     => $row['nisn_siswa'],
                'email'    => $row['email'],
                'password' => Hash::make($row['nisn_siswa']),
                'role_id' => 3,
            ]);

            $siswa =  Siswa::create([
                'user_id'     => $user->id,
                'nama_siswa'    => $row['nama'],
                'nisn_siswa'    => $row['nisn_siswa'],
                'nis_siswa' => $row['nis_siswa'],
                'tingkat_siswa' => $row['tingkat'],
                'tempat_lahir_siswa' => $row['tempat_lahir'],
                'tanggal_lahir_siswa' => $tanggal_lahir_valid,
                'status_pemilihan_siswa' => 'Belum Memilih',
            ]);
        }
    }
}
