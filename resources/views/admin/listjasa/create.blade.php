@extends('admin.template-admin.master')
@section('title', 'List Jasa')
@section('sub-judul', 'Tambah List Jasa')
@section('content')
    <form method="POST" id="form-listjasa" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Jasa</label>
            <input type="text" class="form-control" id="namajasa" name="namajasa" placeholder="Masukkan Nama Jasa">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                placeholder="Masukan Deksripsi Singkat">
        </div>
        <div class="form-group" id="preview-available" style="display: none;">
            <label>Preview</label>
            <div class="preview imgs">
                <img src="" id="ims" style="width: 20%; height: auto;">
            </div>
        </div>
        <div class="form-group">
            <label>Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar" onChange="validate(this.value)">
            <span style="color: red;">Ukuran Gambar <b>Harus</b> 370x215</span>
        </div>
        <div class="form-group">
            <label>Meta Title</label>
            <input type="text" class="form-control" id="metatitle" name="metatitle" placeholder="Masukkan Meta Title Untuk Keperluan SEO">
        </div>
        <div class="form-group">
            <label>Meta Description</label>
            <input type="text" class="form-control" id="metadescription" name="metadescription" placeholder="Masukkan Meta Description Untuk Keperluan SEO">
        </div>
        <div class="form-group">
            <label>Meta Keyword</label>
            <input type="text" class="form-control" id="metakeyword" name="metakeyword" placeholder="Masukkan Meta Keyword Untuk Keperluan SEO">
            <span><b>Format Isi, Contoh:</b> Laser Cutting, Mesin Potong Acrylic, Jual Mesin Grafir Murah, Harga Mesin Cutting Laser</span>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select class="form-control " name="status" id="status">
                <option value="" holder disabled>PILIH Status</option>
                <option value="1">Active</option>
                <option value="0">Non Active</option>
            </select>
        </div>
        <div class="spinner-border"></div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Simpan Banner</button>
        </div>
    </form>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $('form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('listjasa.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("#preloder").fadeIn();
                },
                complete: function() {
                    $("#preloder").hide();
                },
                success: function(result) {
                    if (result.success == 1) {
                        swal({
                            title: "Good Job",
                            text: result.message,
                            timer: 10000,
                            button: false,
                            type: "success",
                            icon: 'success'
                        }).then(() => {
                            window.location.href = "{{ url('/listjasa') }}";
                        })
                    } else if(result.success == 2){
                        swal({
                            title: "Pesan Eror",
                            text: result.message,
                            timer: 10000,
                            button: false,
                            type: "error",
                            icon: 'error'
                        })
                    } else {
                        var values = '';
                        jQuery.each(result.message, function(key, value) {
                            values += `\n ${value}`
                        });

                        swal({
                            title: "Error Validation",
                            text: values,
                            timer: 10000,
                            button: false,
                            type: "error",
                            icon: 'error'
                        })
                    }

                },
                error: function(data) {
                    swal('Error', `${data}`, 'warning');
                }
            });

        });

        function validate(file) {
            let fileCover = document.getElementById('gambar')
            var ext = file.split(".");
            ext = ext[ext.length - 1].toLowerCase();
            var arrayExtensions = ["jpg", "jpeg", "png", "JPG", "JPEG", "PNG"];
            let sizeImage = returnFileSize(fileCover.files[0].size)
            let previewImage = document.getElementById("ims")
            if (arrayExtensions.lastIndexOf(ext) == -1) {
                swal("Wrong Extension File Image!", `List of allowed extensions (${arrayExtensions.join(', ')})`, "error");
                $("#gambar").val("");
                previewImage.src = ""
                $('.imgs').css('display', 'none')
            } else {
                if (sizeImage.realSize > 1048576) {
                    swal("Your File Is Too Large!", `Your File size is ${sizeImage.converted}, maximum allowed is 1MB `,
                        "error");
                    $("#gambar").val("");
                    previewImage.src = ""
                    $('.imgs').css('display', 'none')
                } else {
                    const [file] = gambar.files
                    if (file) {
                        previewImage.src = URL.createObjectURL(file)
                        $('.imgs').css('display', 'block')
                        $('#preview-available').css('display', 'block')
                    }
                }
            }
        }
    </script>
@endsection
