@extends('admin.template-admin.master')
@section('title', 'Berita')
@section('sub-judul', 'Berita')
@section('content')
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session('success')}}
</div>
@endif
<a href="{{ route('beritadashboard.create')}}" class="btn btn-primary btn-sm">Tambah Berita</a>
<br>
<br>
<div class="container">
    <div class="table-responsive">
        <table class="table table-striped" id="table-1">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Judul</th>
                    <th>Rangkuman</th>
                    <th>Deskripsi Produk</th>
                    <th>Creator</th>
                    <th>Gambar</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($beritas as $result => $hasil)
                <tr>
                    <td>{{ $result +$beritas ->firstitem() }}</td>
                    <td>{{ $hasil -> judul}}</td>
                    <td>{{ $hasil -> rangkuman}}</td>
                    <td>{!! $hasil -> deskripsi !!}</td>
                    <td><span class="badge badge-info">{{ $hasil ->users->name }}</span></td>
                    <td><img class="img-fluid" style="max-width:120px;" src="{{ asset( $hasil->gambar) }}" alt=""></td>
                    <td>
                        <form action="{{ route('beritadashboard.destroy', $hasil->id)}}" method="post" id="deleteButton">
                            @method('DELETE')
                            @csrf
                            <a href="{{ route('beritadashboard.edit', $hasil->id )}}" class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-sm btn-danger" type="submit" value="Delete">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="assets/js/page/modules-datatables.js"></script>
<!-- <script>
    $('.btn-danger').click(function(e) {
        var $form = $(this).closest("form"); //Get the form here.
        e.preventDefault();
        swal({
            title: 'Anda yakin ingin mengapus?',
            text: "Ketika dihapus, data tersebut tidak bisa dikembalikan lagi",
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
        }).then((Delete) => {
            console.log(Delete); //This will be true when delete is clicked
            if (Delete) {
                $('#deleteButton').submit(); //Use same Form Id to submit the Form.
            }
        });
    });
</script> -->
@endsection