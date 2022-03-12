@extends('admin.template-admin.master')
@section('title', 'List Jasa')
@section('sub-judul', 'Edit List Jasa')
@section('content')

    <form enctype="multipart/form-data" id="form-listjasa">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Jasa</label>
            <input type="text" class="form-control" value="{{ $listjasa->name }}" name="namajasa" id="namajasa">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" class="form-control" value="{{ $listjasa->description }}" name="deskripsi" id="deskripsi">
        </div>
        @if ($listjasa->image != null)
            <div class="form-group">
                <label>Preview</label>
                <div class="preview-img">
                    <img src="{{ env('PATH_IMAGE') . $listjasa->image }}" style="width: 20%; height: auto;"
                        alt="{{ $listjasa->name }}">
                    <button class="btn btn-danger btn-sm"
                        onclick="event.preventDefault(); removeImage({{ $listjasa->id }})">X</button>
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
                <span style="color: red;">Ukuran Gambar <b>Harus</b> 370x215</span>
            </div>
        @endif
        <div class="form-group">
            <label>Meta Title</label>
            <input type="text" class="form-control" id="metatitle" name="metatitle" value="{{ $listjasa->meta_title }}"
                placeholder="Masukkan Meta Title Untuk Keperluan SEO">
        </div>
        <div class="form-group">
            <label>Meta Description</label>
            <input type="text" class="form-control" id="metadescription" name="metadescription"
                value="{{ $listjasa->meta_description }}" placeholder="Masukkan Meta Description Untuk Keperluan SEO">
        </div>
        <div class="form-group">
            <label>Meta Keyword</label>
            <input type="text" class="form-control" id="metakeyword" name="metakeyword"
                value="{{ $listjasa->meta_keywords }}" placeholder="Masukkan Meta Keyword Untuk Keperluan SEO">
            <span><b>Format Isi, Contoh:</b> Laser Cutting, Mesin Potong Acrylic, Jual Mesin Grafir Murah, Harga Mesin
                Cutting Laser</span>
        </div>
        <div class="form-group">
            <select class="form-control " name="status" id="">
                <option value="" holder disabled>PILIH Status</option>
                <option value="1" {{ $listjasa->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $listjasa->status == 0 ? 'selected' : '' }}>Non Active</option>
            </select>
        </div>


        <div class="form-group">
            <button class="btn btn-primary btn-block">Update Jasa</button>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
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
                        url: '{{ route('listjasa.removeImage') }}',
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
                                    window.location.href = "{{ url('/listjasa') }}";
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

        $('#form-listjasa').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('listjasa.update', $listjasa->id) }}',
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
                            window.location.href = "{{ url('/listjasa') }}";
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
