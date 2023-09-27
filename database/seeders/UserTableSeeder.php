<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User;
        $admin->name = 'Administrator';
        $admin->username = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('admin');
        $admin->role_id = 1;
        $admin->email_verified_at = Date('Y-m-d H:i:s');
        $admin->remember_token = rand(1000000, 10000000000);
        $admin->save();

        $panitia = new User;
        $panitia->name = 'Panitia';
        $panitia->username = 'panitia';
        $panitia->email = 'panitia@gmail.com';
        $panitia->password = bcrypt('panitia');
        $panitia->role_id = 2;
        $panitia->email_verified_at = Date('Y-m-d H:i:s');
        $panitia->remember_token = rand(1000000, 10000000000);
        $panitia->save();

        $pemilih = new User;
        $pemilih->name = 'Pemilih';
        $pemilih->username = 'pemilih';
        $pemilih->email = 'pemilih@gmail.com';
        $pemilih->password = bcrypt('pemilih');
        $pemilih->role_id = 3;
        $pemilih->email_verified_at = Date('Y-m-d H:i:s');
        $pemilih->remember_token = rand(1000000, 10000000000);
        $pemilih->save();
    }
}
