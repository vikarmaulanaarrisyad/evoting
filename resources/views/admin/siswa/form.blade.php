<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah Daftar Siswa
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="nama_siswa">Nama Lengkap <span class="text-red">*</span></label>
                <input type="text" name="nama_siswa" class="form-control" id="nama_siswa" autocomplete="off"
                    placeholder="Nama lengkap">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="nisn_siswa">NISN Siswa <span class="text-red">*</span></label>
                <input type="text" name="nisn_siswa" class="form-control" id="nisn_siswa" autocomplete="off"
                    placeholder="NISN">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="nis_siswa">NIS Siswa <span class="text-red">*</span></label>
                <input type="text" name="nis_siswa" class="form-control" id="nis_siswa" autocomplete="off"
                    placeholder="NIS">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="tempat_lahir_siswa">Tempat Lahir <span class="text-red">*</span></label>
                <input type="text" name="tempat_lahir_siswa" class="form-control" id="tempat_lahir_siswa"
                    autocomplete="off" placeholder="Tempat Lahir">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="tanggal_lahir_siswa">Tanggal Lahir <span class="text-red">*</span></label>
                <div class="input-group datepicker1" id="tanggal_lahir_siswa" data-target-input="nearest">
                    <input type="text" id="tanggal_lahir_siswa" name="tanggal_lahir_siswa"
                        class="form-control datetimepicker-input" data-target="#tanggal_lahir_siswa"
                        data-toggle="datetimepicker" autocomplete="off" />
                    <div class="input-group-append" data-target="#tanggal_lahir_siswa" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="email">Email <span class="text-red">*</span></label>
                <input type="email" name="email" class="form-control" id="email" autocomplete="off"
                    placeholder="Email">
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
