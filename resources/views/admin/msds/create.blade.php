@extends('admin.template-admin.master')
@section('title', 'MSDS')
@section('sub-judul', 'Tambah Hazardous')
@section('content')
    <form method="POST" id="form-portofolio" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Departement<span style="color:red;">*</span></label>
                    <select class="form-control " name="departement_id" id="departement_id">
                        <option value="0" holder>Pilih Departement</option>
                        @foreach ($departements as $departement)
                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Chemical Common Name<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="chemical_common_name" name="chemical_common_name"
                        placeholder="Masukan Chemical Common Name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Trade Name<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="trade_name" name="trade_name"
                        placeholder="Masukan Trade Name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>HSNO Class<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="hsno_class" name="hsno_class"
                        placeholder="Masukan HSNO Class">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>SDS Isue Date<span style="color:red;">*</span></label>
                    <input type="date" class="form-control" id="sds_issue_date" name="sds_issue_date"
                        placeholder="Masukan SDS Isue Date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>UN Number<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="un_number" name="un_number"
                        placeholder="Masukan UN Number">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>CAS Number<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="cas_number" name="cas_number"
                        placeholder="Masukan CAS Number">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Chemical Supplier<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="chemical_supplier" name="chemical_supplier"
                        placeholder="Masukan Chemical Supplier">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Quantity Volume / Liter<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="quantity_volume" name="quantity_volume"
                        placeholder="Masukan Quantity Volume">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Concentration<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="concentration" name="concentration"
                        placeholder="Masukan Concentration">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Packaging Size<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="packaging_size" name="packaging_size"
                        placeholder="Masukan Packaging Size">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Type of Container<span style="color:red;">*</span></label>
                    <select class="form-control " name="type_of_container" id="type_of_container">
                        <option value="0" holder>Type of Container</option>
                        <option value="jerigen">Jerigen</option>
                        <option value="plastik">Plastik</option>
                        <option value="karung">Karung</option>
                        <option value="drum">Drum</option>
                        <option value="botol">Botol</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Location of Chemical<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="location_of_chemical" name="location_of_chemical"
                        placeholder="Masukan Location of Chemical">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bulk Storage Tank<span style="color:red;">*</span></label>
                    <select class="form-control " name="bulk_storage_tank" id="bulk_storage_tank">
                        <option value="0" holder>Status</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Signage In Place<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="signage_in_place" name="signage_in_place"
                        placeholder="Masukan Signage In Place">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bund Capacity<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="bund_capacity" name="bund_capacity"
                        placeholder="Masukan Bund Capacity">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bunding Material<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="bunding_material" name="bunding_material"
                        placeholder="Masukan Bunding Material">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Dokumen</label>
                    <input type="file" class="form-control" id="dokumen" name="dokumen"
                        onChange="validate(this.value)">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Comments/Other</label>
                    <textarea class="form-control" name="comments_other" id="comments_other" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Signage</label>
                    <input type="file" class="form-control" id="signage_doc" name="signage_doc"
                        onChange="validate(this.value)">
                </div>
            </div>
        </div>

        <div class="spinner-border"></div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Simpan
                Hazardous</button>
        </div>
    </form>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/modules/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace('description', {
            toolbar: [{
                    name: 'document',
                    items: ['Source']
                },
                {
                    name: 'basicstyles',
                    groups: ['basicstyles', 'cleanup'],
                    items: ['Bold', 'Italic', 'Strike']
                },
            ],
            height: 400,
            resize_enabled: true,
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: false,
                countHTML: false,
                maxWordCount: 2,
                maxCharCount: 2
            }
        });

        $('form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '{{ route('msds.store') }}',
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
                            window.location.href = "{{ url('/msds') }}";
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

        function validate(file) {
            let fileCover = document.getElementById('dokumen')
            var ext = file.split(".");
            ext = ext[ext.length - 1].toLowerCase();
            var arrayExtensions = ["pdf", "docx", "doc", "xls", "xlsx"];
            let sizeImage = returnFileSize(fileCover.files[0].size)
            if (arrayExtensions.lastIndexOf(ext) == -1) {
                swal("Wrong Extension File Documents!", `List of allowed extensions (${arrayExtensions.join(', ')})`,
                    "error");
            } else {
                const [file] = dokumen.files
            }
        }
    </script>
@endsection
