@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('AdminLTE') }}/plugins/dropzone/min/dropzone.min.css">
@endpush


@push('scripts_vendor')
    <script src="{{ asset('AdminLTE') }}/plugins/dropzone/min/dropzone.min.js"></script>
@endpush

@push('scripts')
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').attr("content");

        Dropzone.autoDiscover = false;
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(document.body, {
            url: "{{ route('siswa.store') }}",
            thumbnailWidth: 20,
            thumbnailHeight: 20,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false,
            previewsContainer: "#previews",
            clickable: ".fileinput-button"
        });

        myDropzone.on("addedfile", function(file) {
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file);
            };
        });

        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

        myDropzone.on("sending", function(file, xhr, formData) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            document.querySelector("#total-progress").style.opacity = "1";
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });

        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0";
        });

        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        };
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true);
        };
    </script>
@endpush
