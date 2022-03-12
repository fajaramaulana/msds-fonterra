@extends('admin.template-admin.master')
@section('title', 'FAQ')
@section('sub-judul', 'Frequently Asked Question')
@section('content')
    <a href="{{ route('faqbackend.create') }}" class="btn btn-primary btn-sm">Tambah FAQ</a>
    <div class="container mt-2">
        <div class="table-responsive">
            <table class="table table-striped" id="table-1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {

            var table = $('#table-1').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('faqbackend.index') !!}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'answer',
                        name: 'answer',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });

        function edit(id, title) {
            swal({
                title: `Warning`,
                text: `Apakah anda yakin ingin mengedit Pertanyaan ${title}`,
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
                    var base_url = `${window.location.origin}/faqbackend/${id}/edit`
                    window.location.href = base_url
                }
            });
        };
    </script>
@endsection
