<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah Daftar Dosen
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="deskripsi_pemilihan">Judul</label>
                <input type="text" name="deskripsi_pemilihan" class="form-control" id="deskripsi_pemilihan"
                    autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="tanggal_mulai_pemilihan">Tanggal Mulai</label>
                <div class="input-group datepicker" id="tanggal_mulai_pemilihan" data-target-input="nearest">
                    <input type="text" id="tanggal_mulai_pemilihan" name="tanggal_mulai_pemilihan" class="form-control datetimepicker-input"
                        data-target="#tanggal_mulai_pemilihan" data-toggle="datetimepicker" autocomplete="off" />
                    <div class="input-group-append" data-target="#tanggal_mulai_pemilihan" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="tanggal_selesai_pemilihan">Tanggal Selesai</label>
                <div class="input-group datepicker" id="tanggal_selesai_pemilihan" data-target-input="nearest">
                    <input type="text" name="tanggal_selesai_pemilihan" class="form-control datetimepicker-input"
                        data-target="#tanggal_selesai_pemilihan" data-toggle="datetimepicker" autocomplete="off" />
                    <div class="input-group-append" data-target="#tanggal_selesai_pemilihan"
                        data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="status_pemilihan" style="display: none;">
        <div class="col-md-12">
            <div class="form-group">
                <label for="status_pemilihan">Status</label>
                <div class="custom-control custom-radio">
                    <input type="radio" name="status_pemilihan" class="custom-control-input" id="Belum Dimulai"
                        value="Belum Dimulai">
                    <label class="custom-control-label font-weight-normal" for="Belum Dimulai">Belum Dimulai</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" name="status_pemilihan" class="custom-control-input" id="Sedang Berlangsung"
                        value="Sedang Berlangsung">
                    <label class="custom-control-label font-weight-normal" for="Sedang Berlangsung">Sedang Berlangsung</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" name="status_pemilihan" class="custom-control-input" id="Selesai"
                        value="Selesai">
                    <label class="custom-control-label font-weight-normal" for="Selesai">Selesai</label>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-primary" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
