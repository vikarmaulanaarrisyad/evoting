@extends('layouts.app')

@section('title', 'Detail Kandidat')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{ route('kandidat.index') }}">Daftar Kandidat</a></li>
    <li class="breadcrumb-item active">Detail Kandidat</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <x-card>
                <x-slot name="header">
                    <h5>
                        <a href="{{ route('kandidat.index') }}"> <i class="fas fa-arrow-alt-circle-left"></i>
                            Kembali</a>
                    </h5>
                </x-slot>
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <img src="{{ asset('assets/image/siswa_avatar.png') }}" width="100px" height="100px"
                            class="text-center items-center">
                    </div>

                    <div class="col-lg-9">
                        <x-table>
                            <tr>
                                <th>Nama lengkap</th>
                                <td>:</td>
                                <td>{{ $kandidat->siswa->nama_siswa }}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>:</td>
                                <td>{{ $kandidat->siswa->nisn_siswa }}</td>
                            </tr>
                            <tr>
                                <th>NIS</th>
                                <td>:</td>
                                <td>{{ $kandidat->siswa->nis_siswa }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td>:</td>
                                <td>{{ Str::title($kandidat->siswa->tempat_lahir_siswa) }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>:</td>
                                <td>{{ tanggal_indonesia($kandidat->siswa->tanggal_lahir_siswa) }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>:</td>
                                <td>{{ $kandidat->siswa->status_pemilihan_siswa }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>:</td>
                                <td>{{ $kandidat->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>:</td>
                                <td>{{ $kandidat->updated_at }}</td>
                            </tr>
                        </x-table>
                    </div>
                </div>

            </x-card>
        </div>

        <div class="col-6">
            <x-card>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Visi</th>
                                </tr>
                                <tr>
                                    <td class="text-justify">
                                        {{ $kandidat->visi_kandidat ?? 'Belum mengisi visi' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Misi</th>
                                </tr>
                                <tr>
                                    <td class="text-justify">
                                        {{ $kandidat->misi_kandidat ?? 'Belum mengisi visi' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Moto</th>
                                </tr>
                                <tr>
                                    <td class="text-justify"> {{ $kandidat->moto_kandidat ?? 'Belum mengisi visi' }}
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection
