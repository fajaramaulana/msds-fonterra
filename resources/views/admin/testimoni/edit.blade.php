@extends('admin.template-admin.master')
@section('title', 'Testimoni')
@section('sub-judul', 'Edit Testimoni')
@section('content')

    <form enctype="multipart/form-data" id="form-testimoni">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Jasa</label>
            <select class="form-control " name="id_jasa" id="">
                <option value="0" holder>Pilih Jasa</option>
                @foreach ($jasas as $jasa)
                    <option value="{{ $jasa->id }}" {{ $jasa->id == $testi->id ? 'selected' : '' }}>
                        {{ $jasa->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Nama Pemesan</label>
            <input type="text" class="form-control" value="{{ $testi->nama_pemesan }}" name="nama_pemesan"
                id="nama_pemesan">
        </div>
        <div class="form-group">
            <label>Pesan</label>
            <textarea class="" name="message" id="message"
                style="width: 100%; height: 200px !important;">{{ $testi->message }}</textarea>
        </div>
        <div class="form-group">
            <select class="form-control " name="status" id="">
                <option value="" holder disabled>PILIH Status</option>
                <option value="1" {{ $testi->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $testi->status == 0 ? 'selected' : '' }}>Non Active</option>
            </select>
        </div>


        <div class="form-group">
            <button class="btn btn-primary btn-block">Update Testimoni</button>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $('#form-testimoni').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);

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
                        url: '{{ route('testimoni.update', $testi->id) }}',
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
                                    window.location.href = "{{ url('/testimoni') }}";
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
                }
            });
        });
    </script>
@endsection
