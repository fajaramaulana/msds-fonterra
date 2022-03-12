@extends('admin.template-admin.master')
@section('title', 'FAQ')
@section('sub-judul', 'Tambah Frequently Asked Question')
@section('content')
    <form method="POST" id="form-faq" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Pertanyaan</label>
            <input type="text" class="form-control" id="question" name="question"
                placeholder="Masukan Nama Pemesan">
        </div>
        <div class="form-group">
            <label>Jawaban</label>
            <textarea class="form-control" name="answer" id="answer" cols="30" rows="10"></textarea>
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
            <button class="btn btn-primary btn-block">Simpan FAQ</button>
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
                url: '{{ route('faqbackend.store') }}',
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
                            window.location.href = "{{ url('/faqbackend') }}";
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
