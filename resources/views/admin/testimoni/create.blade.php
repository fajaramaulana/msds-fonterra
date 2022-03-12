@extends('admin.template-admin.master')
@section('title', 'Testimoni')
@section('sub-judul', 'Tambah Testimoni')
@section('content')
    <form method="POST" id="form-testimoni" enctype="multipart/form-data">
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
            <label>Nama</label>
            <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan"
                placeholder="Masukan Nama Pemesan">
        </div>
        <div class="form-group">
            <label>Pesan</label>
            <textarea class="form-control" name="message" id="message" cols="30" rows="10"></textarea>
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
            <button class="btn btn-primary btn-block">Simpan Portofolio</button>
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
                url: '{{ route('testimoni.store') }}',
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
                            window.location.href = "{{ url('/testimoni') }}";
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
