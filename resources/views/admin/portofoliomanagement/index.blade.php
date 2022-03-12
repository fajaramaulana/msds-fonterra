@extends('admin.template-admin.master')
@section('title', 'Portofolio')
@section('sub-judul', 'Portofolio')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif
    <a href="{{ route('portofoliomanagement.create') }}" class="btn btn-primary btn-sm">Tambah Portofolio</a>
    <div class="container mt-2">
        <div class="table-responsive">
            <table class="table table-striped" id="table-1" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jasa</th>
                        <th>Title</th>
                        <th>Gambar</th>
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
                ajax: "{!! route('portofoliomanagement.index') !!}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'jasa',
                        name: 'jasa'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar',
                        orderable: false,
                        searchable: false
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
                text: `Apakah anda yakin ingin mengedit portofolio ${title}`,
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
                    var base_url = `${window.location.origin}/portofoliomanagement/${id}/edit`
                    window.location.href = base_url
                }
            });
        };
    </script>
@endsection
