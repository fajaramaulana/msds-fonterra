@extends('admin.template-admin.master')
@section('title', 'Bahan')
@section('sub-judul', 'List Bahan')
@section('content')
    <a href="{{ route('bahan.create') }}" class="btn btn-primary btn-sm">Tambah Bahan</a>
    <div class="container mt-2">
        <div class="table-responsive">
            <table class="table table-striped" id="table-1" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jasa</th>
                        <th>Nama Bahan</th>
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
                ajax: "{!! route('bahan.index') !!}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'jasa',
                        name: 'jasa'
                    },
                    {
                        data: 'nama_bahan',
                        name: 'nama_bahan'
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
                text: `Apakah anda yakin ingin mengedit bahan ${title}`,
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
                    var base_url = `${window.location.origin}/bahan/${id}/edit`
                    window.location.href = base_url
                }
            });
        };
    </script>
@endsection
