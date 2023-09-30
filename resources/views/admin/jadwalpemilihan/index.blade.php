@extends('layouts.app')

@section('title', 'Jadwal Pemilihan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Jadwal Pemilihan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                <x-slot name="header">
                    @if (auth()->user()->hasRole('admin'))
                        <button onclick="addForm(`{{ route('pemilihan.store') }}`)" class="btn btn-primary"><i
                                class="fas fa-plus-circle"></i> Tambah</button>
                    @else
                        <a href="{{ url('/pemilihan.store') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>
                            Tambah</a>
                    @endif
                </x-slot>

                @if (auth()->user()->hasRole('panitia'))
                    <div class="d-flex justify-content-between">
                        <div class="form-group">
                            <label for="status2">Status</label>
                            <select name="status2" id="status2" class="custom-select">
                                <option value="" selected>Semua</option>
                                <option value="publish" {{ request('status') == 'publish' ? 'selected' : '' }}>Publish
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Diarsipkan
                                </option>
                            </select>
                        </div>

                        <div class="d-flex">
                            <div class="form-group mx-3">
                                <label for="start_date2">Tanggal Awal</label>
                                <div class="input-group datepicker" id="start_date2" data-target-input="nearest">
                                    <input type="text" name="start_date2" class="form-control datetimepicker-input"
                                        data-target="#start_date2" />
                                    <div class="input-group-append" data-target="#start_date2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date2">Tanggal Akhir</label>
                                <div class="input-group datepicker" id="end_date2" data-target-input="nearest">
                                    <input type="text" name="end_date2" class="form-control datetimepicker-input"
                                        data-target="#end_date2" />
                                    <div class="input-group-append" data-target="#end_date2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th><i class="fas fa-cog"></i></th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @includeIf('admin.jadwalpemilihan.form')
@endsection

@includeIf('includes.datatables')
@includeIf('includes.datepicker')

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
                url: '{{ route('pemilihan.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'tanggal_pemilihan',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'deskripsi_pemilihan',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'status_pemilihan',
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

        function addForm(url, title = 'Tambah Agenda Pemilihan') {
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

        function editForm(url, title = 'Edit Data Agenda Pemilihan') {
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

        function updateStatus(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan mengubah status pelaksanaan ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
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
    </script>
@endpush
