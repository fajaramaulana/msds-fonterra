@extends('admin.template-admin.master')
@section('title', 'Testimoni')
@section('sub-judul', 'Testimoni')
@section('content')
    <a href="{{ route('testimoni.create') }}" class="btn btn-primary btn-sm">Tambah Testimoni</a>
    <div class="container mt-2">
        <div class="table-responsive">
            <table class="table table-striped" id="table-1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jasa</th>
                        <th>Nama Pelanggan</th>
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
                ajax: "{!! route('testimoni.index') !!}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'jasa',
                        name: 'jasa'
                    },
                    {
                        data: 'nama_pemesan',
                        name: 'nama_pemesan',
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
                text: `Apakah anda yakin ingin mengedit Testimoni ${title}`,
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
                    var base_url = `${window.location.origin}/testimoni/${id}/edit`
                    window.location.href = base_url
                }
            });
        };
    </script>
@endsection
