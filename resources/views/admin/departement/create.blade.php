@extends('admin.template-admin.master')
@section('title', 'Departement')
@section('sub-judul', 'Tambah Departement')
@section('content')
    <form method="POST" id="form-faq" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Departement</label>
            <input type="text" class="form-control" id="name" name="name"
                placeholder="Masukan Nama Departement">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="email" name="email"
                placeholder="Masukan Email">
        </div>
        <div class="spinner-border"></div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Simpan Departement</button>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $('form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('departement.store') }}',
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
                            window.location.href = "{{ url('/departement') }}";
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
    </script>
@endsection
