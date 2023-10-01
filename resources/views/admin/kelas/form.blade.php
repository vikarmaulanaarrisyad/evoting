<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah Daftar Kelas
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" autocomplete="off" placeholder="Nama Kelas">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <label for="kelas">Tingkat Kelas</label>
            <select name="kelas" id="kelas" class="form-control">
                <option disabled selected>Pilih tingkat kelas</option>
                @for ($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}">Tingkat {{ $i }}</option>
                @endfor
            </select>
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
