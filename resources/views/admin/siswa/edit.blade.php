@extends('layouts.app')

@section('title', $siswa->nama_siswa)
@section('header', 'Detail Siswa ' . $siswa->nama_siswa)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{ route('siswa.index') }}">Daftar Siswa</a></li>
    <li class="breadcrumb-item active">Detail Siswa</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <x-card>
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <img src="{{ asset('assets/image/siswa_avatar.png') }}" width="100px" height="100px"
                            class="text-center items-center">
                    </div>

                    <div class="col-lg-10">
                        <x-table>
                            <tr>
                                <th>Nama lengkap</th>
                                <td>:</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>:</td>
                                <td>{{ $siswa->nisn_siswa }}</td>
                            </tr>
                            <tr>
                                <th>NIS</th>
                                <td>:</td>
                                <td>{{ $siswa->nis_siswa }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td>:</td>
                                <td>{{ Str::title($siswa->tempat_lahir_siswa) }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>:</td>
                                <td>{{ tanggal_indonesia($siswa->tanggal_lahir_siswa) }}</td>
                            </tr>
                            <tr>
                                <th>Status Pemilihan</th>
                                <td>:</td>
                                <td>{{ $siswa->status_pemilihan_siswa }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>:</td>
                                <td>{{ $siswa->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>:</td>
                                <td>{{ $siswa->updated_at }}</td>
                            </tr>
                        </x-table>
                    </div>
                </div>

            </x-card>
        </div>
    </div>
@endsection
