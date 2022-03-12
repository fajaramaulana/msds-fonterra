@extends('admin.template-admin.master')
@section('title', 'FAQ')
@section('sub-judul', 'Edit Frequently Asked Question')
@section('content')

    <form enctype="multipart/form-data" id="form-faq">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Pertanyaan</label>
            <input type="text" class="form-control" value="{{ $faq->question }}" name="question" id="question">
        </div>
        <div class="form-group">
            <label>Jawaban</label>
            <textarea name="answer" id="answer" style="width: 100%; height: 200px !important;">{{ $faq->answer }}</textarea>
        </div>
        <div class="form-group">
            <select class="form-control " name="status" id="">
                <option value="" holder disabled>PILIH Status</option>
                <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>Non Active</option>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Update FAQ</button>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $('#form-faq').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('faqbackend.update', $faq->id) }}',
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
                            window.location.href = "{{ url('/faq') }}";
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
