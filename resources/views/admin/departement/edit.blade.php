@extends('admin.template-admin.master')
@section('title', 'Departement')
@section('sub-judul', 'Edit Departement')
@section('content')

    <form enctype="multipart/form-data" id="form-departement">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Departement</label>
            <input type="text" class="form-control" value="{{ $departement->name }}" name="name" id="name">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" value="{{ $departement->email }}" name="email" id="email">
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Update Departement</button>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $('#form-departement').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('departement.update', $departement->id) }}',
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
                            window.location.href = "{{ url('/departement') }}";
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
