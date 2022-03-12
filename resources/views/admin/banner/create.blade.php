@extends('admin.template-admin.master')
@section('title', 'Banner')
@section('sub-judul', 'Tambah Banner')
@section('content')
    <form method="POST" id="form-banner" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" id="judul" name="judul">
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" class="form-control" id="rangkuman" name="rangkuman">
        </div>
        <div class="form-group">
            <label>Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
        </div>
        <div class="spinner-border"></div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Simpan Banner</button>
        </div>
    </form>

    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $('form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('banner.store') }}',
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
                            window.location.href = "{{ url('/banner') }}";
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
    </script>
@endsection
