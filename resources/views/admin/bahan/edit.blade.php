@extends('admin.template-admin.master')
@section('title', 'Bahan')
@section('sub-judul', 'Edit Bahan')
@section('content')

    <form enctype="multipart/form-data" id="form-listjasa">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Jasa</label>
            <select class="form-control " name="id_jasa" id="">
                <option value="0" holder>Pilih Jasa</option>
                @foreach ($jasas as $jasa)
                    <option value="{{ $jasa->id }}" {{ $jasa->id == $bahans->id ? 'selected' : '' }}>
                        {{ $jasa->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nama Bahan</label>
            <input type="text" class="form-control" value="{{ $bahans->nama_bahan }}" name="nama_bahan" id="nama_bahan">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" id="description" class="form-control">{{ $bahans->description }}</textarea>
        </div>
        @if ($bahans->image != null)
            <div class="form-group">
                <label>Preview</label>
                <div class="preview-img">
                    <img src="{{ env('PATH_IMAGE') . $bahans->image }}" style="width: 20%; height: auto;"
                        alt="{{ $bahans->name }}">
                    <button class="btn btn-danger btn-sm"
                        onclick="event.preventDefault(); removeImage({{ $bahans->id }})">X</button>
                </div>
            </div>
        @else
            <div class="form-group" id="preview-available" style="display: none;">
                <label>Preview</label>
                <div class="preview imgs">
                    <img src="" id="ims" style="width: 20%; height: auto;">
                </div>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" class="form-control" name="gambar" id="gambar" onChange="validate(this.value)">
                <span style="color: red;">Ukuran Gambar <b>Maximal</b> 1mb, 370px x 359px</span>
            </div>
        @endif
        <div class="form-group">
            <select class="form-control " name="status" id="">
                <option value="" holder disabled>PILIH Status</option>
                <option value="1" {{ $bahans->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $bahans->status == 0 ? 'selected' : '' }}>Non Active</option>
            </select>
        </div>


        <div class="form-group">
            <button class="btn btn-primary btn-block">Update Bahan</button>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('assets/modules/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace('description', {
            toolbar: [{
                    name: 'document',
                    items: ['Source']
                },
                {
                    name: 'basicstyles',
                    groups: ['basicstyles', 'cleanup'],
                    items: ['Bold', 'Italic', 'Strike']
                },
            ],
            height: 400,
            resize_enabled: true,
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: false,
                countHTML: false,
                maxWordCount: 2,
                maxCharCount: 2
            }
        });

        removeImage = (id) => {
            var formDataRemove = new FormData();
            formDataRemove.append('id', id);

            swal({
                title: `Warning`,
                text: `Apakah anda yakin ingin menghapus gambar ini?`,
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Ya',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((result) => {
                if (result == true) {
                    $.ajax({
                        url: '{{ route('bahan.removeImage') }}',
                        type: 'POST',
                        data: formDataRemove,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $("#preloder").fadeIn();
                        },
                        complete: function() {
                            $("#preloder").hide();
                        },
                        success: function(result) {
                            $("#preloder").hide();
                            if (result.success == 1) {
                                swal({
                                    title: "Good Job",
                                    text: result.message,
                                    timer: 5000,
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
                                    icon: 'success'
                                }).then(() => {
                                    window.location.href =
                                        "{{ url('/bahan') }}";
                                })
                            } else {
                                swal({
                                    title: "Pesan Eror",
                                    text: result.message,
                                    timer: 10000,
                                    showConfirmButton: false,
                                    icon: 'error'
                                })
                            }

                        },
                        error: function(data) {
                            $("#preloder").hide();
                            swal('Error', `${data}`, 'warning');
                        }
                    });
                }
            });
        }

        function validate(file) {
            let fileCover = document.getElementById('gambar')
            var ext = file.split(".");
            ext = ext[ext.length - 1].toLowerCase();
            var arrayExtensions = ["jpg", "jpeg", "png", "JPG", "JPEG", "PNG"];
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

        $('#form-listjasa').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('bahan.update', $bahans->id) }}',
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
                    $("#preloder").hide();
                    if (result.success == 1) {
                        swal({
                            title: "Good Job",
                            text: result.message,
                            timer: 10000,
                            showConfirmButton: false,
                            icon: 'success'
                        }).then(() => {
                            window.location.href = "{{ url('/bahan') }}";
                        })
                    } else if (result.success == 2) {
                        swal({
                            title: "Pesan Eror",
                            text: result.message,
                            timer: 10000,
                            showConfirmButton: false,
                            icon: 'error'
                        })
                    } else {
                        var values = '';
                        jQuery.each(result.message, function(key, value) {
                            values += `\n ${value}`
                        });

                        swal({
                            title: "Pesan Eror",
                            text: values,
                            timer: 10000,
                            showConfirmButton: false,
                            icon: 'error'
                        })
                    }

                },
                error: function(data) {
                    $("#preloder").hide();
                    swal('Error', `${data}`, 'warning');
                }
            });

        });
    </script>
@endsection
