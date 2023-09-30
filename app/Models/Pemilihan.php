<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemilihan extends Model
{
    use HasFactory;

    public function statusColor()
    {
        $color = '';

        switch ($this->status_pemilihan) {
            case 'Belum Dimulai':
                $color = 'danger';
                break;
            case 'Sedang Berlangsung':
                $color = 'warning';
                break;
            case 'Selesai':
                $color = 'success';
                break;
            default:
                break;
        }

        return $color;
    }
}
