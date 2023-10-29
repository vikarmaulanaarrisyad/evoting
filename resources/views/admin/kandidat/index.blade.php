@extends('layouts.app')

@section('title', 'Daftar Kandidat')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Daftar Kandidat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                <x-slot name="header">
                    @if (auth()->user()->hasRole('admin'))
                        <button onclick="addForm(`{{ route('kandidat.store') }}`)" class="btn btn-primary"><i
                                class="fas fa-plus-circle"></i> Tambah</button>
                    @else
                        <a href="{{ url('/kandidat.store') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>
                            Tambah</a>
                    @endif
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </x-slot>
                </x-table>

            </x-card>
        </div>
    </div>

    @includeIf('admin.kandidat.form')
@endsection

@includeIf('includes.datatables')
@include('includes.select2')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let button = '#submitBtn';
        let table;

        $(function() {
            $('#spinner-border').hide();
        });

        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ordering: false,
            responsive: true,
            language: {
                "processing": "Mohon bersabar..."
            },
            ajax: {
                url: '{{ route('kandidat.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'foto',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'siswa',
                },
                {
                    data: 'tanggal_lahir',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'kelas',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ]
        });

        function addForm(url, title = 'Tambah Kelas Baru') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');
            $('#spinner-border').hide();
            $("#status_pemilihan").hide();
            $(button).show();
            $('[name=deskripsi_pemilihan]').prop('disabled', false);
            $('[name=tanggal_mulai_pemilihan]').prop('disabled', false);
            $('[name=tanggal_selesai_pemilihan]').prop('disabled', false);

            $(button).prop('disabled', false);
            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Edit Data Kelas') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('PUT');

                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);

                    let statusPemilih = response.data.status_pemilihan;
                    console.log(statusPemilih);

                    if (statusPemilih === 'Selesai') {
                        $("#status_pemilihan").hide();
                        $(button).prop('disabled', true);
                        $(button).hide();
                        $('[name=deskripsi_pemilihan]').prop('disabled', true);
                        $('[name=tanggal_mulai_pemilihan]').prop('disabled', true);
                        $('[name=tanggal_selesai_pemilihan]').prop('disabled', true);
                    } else {
                        $("#status_pemilihan").show();
                        $(button).show();
                        $('[name=deskripsi_pemilihan]').prop('disabled', false);
                        $('[name=tanggal_mulai_pemilihan]').prop('disabled', false);
                        $('[name=tanggal_selesai_pemilihan]').prop('disabled', false);
                    }

                    resetForm(`${modal} form`);
                    loopForm(response.data);
                })
                .fail(errors => {
                    Swall.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                });
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();
            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            location.reload();
                            $(button).prop('disabled', false);
                            $('#spinner-border').hide();
                            table.ajax.reload();
                        })
                    }

                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }

        function deleteData(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menghapus ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya !',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            }
                            table.ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            });

                            // Refresh tabel atau lakukan operasi lain yang diperlukan
                            table.ajax.reload();

                        }
                    });
                }
            });
        }

        $('#nama_siswa').select2({
            placeholder: 'Pilih kandidat',
            ajax: {
                url: '{{ route('siswa.search') }}',
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.nama_siswa
                            }
                        })
                    }
                }
            }
        });
    </script>
@endpush
