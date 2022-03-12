@extends('admin.template-admin.master')
@section('title', 'Pola')
@section('sub-judul', 'Tambah Pola')
@section('content')
    <form method="POST" id="form-portofolio" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Jasa</label>
            <select class="form-control " name="id_jasa" id="">
                <option value="0" holder>Pilih Jasa</option>
                @foreach ($jasas as $jasa)
                    <option value="{{ $jasa->id }}">{{ $jasa->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nama Pola</label>
            <input type="text" class="form-control" id="nama_pola" name="nama_pola" placeholder="Masukan Nama Pola">
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
            <span style="color: red;">Ukuran Gambar <b>Maximal</b> 1mb</span>
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
            <button class="btn btn-primary btn-block">Simpan Pola</button>
        </div>
    </form>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $('form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('pola.store') }}',
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
                            window.location.href = "{{ url('/pola') }}";
                        })
                    } else if (result.success == 2) {
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
                const [file] = gambar.files
                if (file) {
                    previewImage.src = URL.createObjectURL(file)
                    $('.imgs').css('display', 'block')
                    $('#preview-available').css('display', 'block')
                }
            }
        }
    </script>
@endsection
