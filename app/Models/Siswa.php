<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

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

    public function kandidat()
    {
        return $this->hasMany(Kandidat::class);
    }
}
