@extends('layouts.app')

@section('title', 'Siswa')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Siswa</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                <x-slot name="header">
                    @if (auth()->user()->hasRole('admin'))
                        <button onclick="addForm(`{{ route('siswa.store') }}`)" class="btn btn-primary"><i
                                class="fas fa-plus-circle"></i> Tambah</button>
                        <button onclick="importData(`{{ route('siswa.import_excel') }}`)" class="btn btn-success"><i
                                class="fas fa-file-excel"></i>
                            Import</button>
                    @else
                        <a href="{{ url('/siswa.store') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>
                            Tambah</a>
                    @endif
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>NISN</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Tingkat - Rombel</th>
                        <th>Umur</th>
                        <th>Status</th>
                        <th><i class="fas fa-cog"></i></th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @includeIf('admin.siswa.form')
    @includeIf('admin.siswa.import')
@endsection

@includeIf('includes.datatables')
@includeIf('includes.datepicker')
@include('includes.dropzone')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let modalImport = '#import';
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
                url: '{{ route('siswa.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nama_siswa',
                },
                {
                    data: 'nisn_siswa',
                },
                {
                    data: 'tempat_lahir_siswa',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'tanggal_lahir_siswa',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'kelas',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'umur',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'status_pemilihan_siswa',
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

        function addForm(url, title = 'Tambah Siswa Baru') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');
            $('#spinner-border').hide();
            resetForm(`${modal} form`);
        }

        function editForm1(url, title = 'Edit Data Siswa') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('PUT');

                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);

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

        function editForm(url) {
            window.location.href = url;
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
                    $(modalImport).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }
                    $(button).prop('disabled', false);
                    $('#spinner-border').hide();
                    table.ajax.reload();
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

        function importData(url, title = 'Upload Data Siswa') {
            $(modalImport).modal('show');
            $(`${modalImport} .modal-title`).text(title);
            $(`${modalImport} form`).attr('action', url);
            $(`${modalImport} [name=_method]`).val('POST');
            $(`${modalImport} #spinner-border`).hide();
            resetForm(`${modal} form`);
        }
    </script>
@endpush
