@extends('admin.template-admin.master')
@section('title', 'MSDS')
@section('sub-judul', 'List MSDS')
@section('content')
    <a href="{{ route('msds.create') }}" class="btn btn-primary btn-sm">Tambah MSDS</a>
    <form method="POST" id="form-search" enctype="multipart/form-data">
        @csrf
        <div class="col-sm-4 float-right">
            <div class="form-group">
                <label>Departement<span style="color:red;">*</span></label>
                <select class="form-control" name="departement_id" id="departement_id">
                    <option value="0" holder @if ($reqId == null) selected @endif>Pilih Departemen</option>
                    @foreach ($departements as $departement)
                        <option value="{{ $departement->id }}" @if ($reqId == $departement->id) selected @endif>
                            {{ $departement->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block">Sort</button>
            </div>
        </div>
    </form>
    <div class="container mt-2">
        <div class="table-responsive">
            <table class="table table-striped" id="table-1" width="100%">
                <thead>
                    <tr>
                        <th>CAS Number</th>
                        <th>Nama Departement</th>
                        <th>Chemmical Common Name</th>
                        <th>SDS Issue Date</th>
                        <th>Exipred Date</th>
                        <th>Checmical Supplier</th>
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
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const departement_id = urlParams.get('departement_id');
            var table = $('#table-1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('msds.index') }}",
                    data: {
                        departement_id: departement_id,
                    }
                },
                columns: [{
                        data: 'cas_number',
                        name: 'cas_number'
                    },
                    {
                        data: 'name',
                        name: 'departements.name'
                    },
                    {
                        data: 'chemical_common_name',
                        name: 'chemical_common_name'
                    },
                    {
                        data: 'sds_issue_date',
                        name: 'sds_issue_date',
                    },
                    {
                        data: 'expired_date',
                        name: 'expired_date'
                    },
                    {
                        data: 'chemical_supplier',
                        name: 'chemical_supplier'
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
                text: `Apakah anda yakin ingin mengedit MSDS ${title}`,
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
                    var base_url = `${window.location.origin}/msds/${id}/edit`
                    window.location.href = base_url
                }
            });
        };

        $('form').submit(function(event) {
            event.preventDefault();
            let departement_id = $('#departement_id').val();
            let url;
            
            if (departement_id == 0) {
                url = `{{ route('msds.index') }}`
            }else{
                url = `{{ route('msds.index') }}?departement_id=${departement_id}`
            }
            window.location.href = url
        });
    </script>
@endsection