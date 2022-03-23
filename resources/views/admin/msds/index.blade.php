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

    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" style="z-index: 123123 !important; margin-left: 10% !important;" id="toggle-modal">
        <div class="modal-dialog modal-lg" style="min-width: 900px" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-sm-8">
                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    </div>
                    <div class="col-sm-3 pull-right">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label style="font-weight: 800">Chemical Common Name</label>
                            <p id="chemical_common_name"></p>
                        </div>
                        <div class="col-sm-6">
                            <label style="font-weight: 800">Chemical Supplier</label>
                            <p id="chemical_supplier"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label style="font-weight: 800">SDS Issue Date</label>
                            <p id="sds_issue_date"></p>
                        </div>
                        <div class="col-sm-6">
                            <label style="font-weight: 800">Expired Date</label>
                            <p id="expired_date"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label style="font-weight: 800">CAS Number</label>
                            <p id="cas_number"></p>
                        </div>
                        <div class="col-sm-6">
                            <label style="font-weight: 800">Trade Name</label>
                            <p id="trade_name"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label style="font-weight: 800">Location of Chemical</label>
                            <p id="location_of_chemical"></p>
                        </div>
                        <div class="col-sm-6">
                            <label style="font-weight: 800">Dokumen</label><br>
                            <a id="document" class="btn btn-sm btn-primary">Download Dokumen</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-backdrop {
            position: unset !important;
        }

    </style>
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

        $('#toggle-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient = button.data('throw'); // Extract info from data-* attributes
            $.ajax({
                type: 'GET',
                url: '{{ route('msds.getbyid',) }}',
                data: {
                    idlog: recipient,
                },
                success: function(data) {
                    console.log(data)
                    $('#staticBackdropLabel').html(`MSDS ${data.chemical_common_name}`);
                    $('#chemical_common_name').html(data.chemical_common_name);
                    $('#chemical_supplier').html(data.chemical_supplier);
                    $('#sds_issue_date').html(data.sds_issue_date);
                    $('#expired_date').html(data.expired_date);
                    $('#cas_number').html(data.cas_number);
                    $('#trade_name').html(data.trade_name);
                    $('#location_of_chemical').html(data.location_of_chemical);
                    let a = document.getElementById('document');
                    a.href = "{{ asset('dokumen/') }}"+"/"+data.path_pdf;
                }
            })
        });

        $('form').submit(function(event) {
            event.preventDefault();
            let departement_id = $('#departement_id').val();
            let url;

            if (departement_id == 0) {
                url = `{{ route('msds.index') }}`
            } else {
                url = `{{ route('msds.index') }}?departement_id=${departement_id}`
            }
            window.location.href = url
        });
    </script>
@endsection
