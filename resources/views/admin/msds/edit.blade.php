@extends('admin.template-admin.master')
@section('title', 'MSDS')
@section('sub-judul', 'Edit MSDS')
@section('content')
    <form method="POST" id="form-portofolio" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Departement<span style="color:red;">*</span></label>
                    <select class="form-control " name="departement_id" id="departement_id">
                        <option value="0" holder>Pilih Departement</option>
                        @foreach ($departements as $departement)
                            <option value="{{ $departement->id }}"
                                {{ $departement->id == $msds->departement_id ? 'selected' : '' }}>
                                {{ $departement->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Chemical Common Name<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="chemical_common_name" name="chemical_common_name"
                        placeholder="Masukan Chemical Common Name" value="{{ $msds->chemical_common_name }}">
                        <input type="hidden" name="id" value="{{$msds->id}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Trade Name<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="trade_name" name="trade_name"
                        placeholder="Masukan Trade Name" value="{{ $msds->trade_name }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>HSNO Class<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="hsno_class" name="hsno_class"
                        placeholder="Masukan HSNO Class" value="{{ $msds->hsno_class }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>SDS Isue Date<span style="color:red;">*</span></label>
                    <input type="date" class="form-control" id="sds_issue_date" name="sds_issue_date"
                        placeholder="Masukan SDS Isue Date" value="{{ $msds->sds_issue_date }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>UN Number<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="un_number" name="un_number"
                        placeholder="Masukan UN Number" value="{{ $msds->un_number }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>CAS Number<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="cas_number" name="cas_number"
                        placeholder="Masukan CAS Number" value="{{ $msds->cas_number }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Chemical Supplier<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="chemical_supplier" name="chemical_supplier"
                        placeholder="Masukan Chemical Supplier" value="{{ $msds->chemical_supplier }}">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Quantity Volume<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="quantity_volume" name="quantity_volume"
                        placeholder="Masukan Quantity Volume" value="{{ $msds->quantity_volume }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Concentration<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="concentration" name="concentration"
                        placeholder="Masukan Concentration" value="{{ $msds->concentration }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Packaging Size<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="packaging_size" name="packaging_size"
                        placeholder="Masukan Packaging Size" value="{{ $msds->packaging_size }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Type of Container<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="type_of_container" name="type_of_container"
                        placeholder="Masukan Type of Container" value="{{ $msds->type_of_container }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Location of Chemical<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="location_of_chemical" name="location_of_chemical"
                        placeholder="Masukan Location of Chemical" value="{{ $msds->location_of_chemical }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Departement<span style="color:red;">*</span></label>
                    <select class="form-control " name="bulk_storage_tank" id="bulk_storage_tank">
                        <option value="0" holder>Status</option>
                        <option value="1" {{ $msds->bulk_storage_tank == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $msds->bulk_storage_tank == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Signage In Place<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="signage_in_place" name="signage_in_place"
                        placeholder="Masukan Signage In Place" value="{{ $msds->signage_in_place }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bund Capacity<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="bund_capacity" name="bund_capacity"
                        placeholder="Masukan Bund Capacity" value="{{ $msds->bund_capacity }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bunding Material<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" id="bunding_material" name="bunding_material"
                        placeholder="Masukan Bunding Material" value="{{ $msds->bunding_material }}">
                </div>
            </div>
            <div class="form-group">
                <label>Dokumen<span style="color:red;">*</span></label>
                @if ($msds->path_pdf == null)
                    <input type="file" class="form-control" id="dokumen" name="dokumen" onChange="validate(this.value)">
                @else
                    <div>
                        <a class="btn btn-sm btn-primary" href="{{ asset('dokumen/' . $msds->path_pdf) }}"
                            target="_blank">Download Document Here</a>
                        <button class="btn btn-sm btn-danger" onclick="event.preventDefault(); removePdf({{ $msds->id }})">Delete Document</button>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label>Comments/Other<span style="color:red;">*</span></label>
            <textarea class="form-control" name="comments_other" id="comments_other" cols="30"
                rows="10">{{ $msds->comments_other }}</textarea>
        </div>
        <div class="spinner-border"></div>
        <div class="form-group">
            <a class="btn btn-danger btn-sm" onclick="history.back()" style="color: white;">Back</a>
            <button class="btn btn-primary btn-sm" type="submit">Update MSDS</button>
        </div>
    </form>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/modules/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        removePdf = (id) => {
            var formDataRemove = new FormData();
            formDataRemove.append('id', id);
            swal({
                title: `Warning`,
                text: `Apakah anda yakin ingin menghapus Dokumen ini? Sekali anda menghapus anda tidak akan bisa melakukan restore terhadap data tersebut.`,
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
                    $.ajax({
                        url: '{{ route('msds.removePdf') }}',
                        type: 'POST',
                        data: formDataRemove,
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
                                    timer: 5000,
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
                                    icon: 'success'
                                }).then(() => {
                                    window.location.href =
                                        "{{ url('/bahan') }}";
                                })
                            } else {
                                swal({
                                    title: "Pesan Eror",
                                    text: result.message,
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
                }
            });
        }

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
                url: '{{ route('msds.update', $msds->id) }}',
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
