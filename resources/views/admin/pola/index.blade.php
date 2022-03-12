@extends('admin.template-admin.master')
@section('title', 'Pola')
@section('sub-judul', 'List Pola')
@section('content')
    <a href="{{ route('pola.create') }}" class="btn btn-primary btn-sm">Tambah Pola</a>
    <div class="container mt-2">
        <div class="table-responsive">
            <table class="table table-striped" id="table-1" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jasa</th>
                        <th>Nama Pola</th>
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
                ajax: "{!! route('pola.index') !!}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'jasa',
                        name: 'jasa'
                    },
                    {
                        data: 'nama_pola',
                        name: 'nama_pola'
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
                    var base_url = `${window.location.origin}/pola/${id}/edit`
                    window.location.href = base_url
                }
            });
        };
    </script>
@endsection
