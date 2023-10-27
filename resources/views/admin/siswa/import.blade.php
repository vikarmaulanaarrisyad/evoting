<x-modal id="import" data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Import Data
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="alert alert-light alert-dismissible">
                <h5><i class="icon fas fa-info"></i> Pengumuman!</h5>
                <ul>
                    <li>
                        <h6>
                            Silahkan download <a class="btn btn-sm btn-success"
                                href="{{ asset('assets/excel/contoh.xls') }}" <download><i class="fas fa-download"></i>
                                </download>
                                Template Excel</a>
                        </h6>
                    </li>
                    <li>
                        <h6>
                            Upload berulang tidak akan bermasalah
                        </h6>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <input type="file" class="custom-file-input" id="customFile" name="upload">
                <label class="custom-file-label" for="customFile">Choose file</label>
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
