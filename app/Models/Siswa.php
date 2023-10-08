<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    public function statusColor()
    {
        $color = '';

        switch ($this->status_pemilihan_siswa) {
            case 'Belum Memilih':
                $color = 'danger';
                break;
            case 'Sudah Memilih':
                $color = 'success';
                break;
            default:
                break;
        }

        return $color;
    }
}
