<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $nisn_siswa = $row['nisn_siswa'];

            // Transaksi Database
            DB::transaction(function () use ($row, $nisn_siswa) {
                $user = User::updateOrCreate(
                    ['username' => $nisn_siswa],
                    [
                        'name'     => $row['nama'],
                        'email'    => $row['email'],
                        'password' => Hash::make($nisn_siswa),
                        'role_id'  => 3,
                    ]
                );

                Siswa::updateOrCreate(
                    ['nisn_siswa' => $nisn_siswa],
                    [
                        'user_id'                => $user->id,
                        'nama_siswa'             => $row['nama'],
                        'nis_siswa'              => $row['nis_siswa'],
                        'tingkat_siswa'          => $row['tingkat'],
                        'tempat_lahir_siswa'     => $row['tempat_lahir'],
                        'tanggal_lahir_siswa'    => date("Y-m-d", strtotime($row['tanggal_lahir'])),
                        'status_pemilihan_siswa' => 'Belum Memilih',
                    ]
                );
            });
        }
    }
}
