@extends('admin.template-admin.master')
@section('title', 'List User')
@section('sub-judul', 'List User')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif
    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Tambah User</a>
    <br>
    <br>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped" id="table-1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Departemen</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $result => $hasil)
                        <tr>
                            <td>{{ $result + $user->firstitem() }}</td>
                            <td>{{ $hasil->name }}</td>
                            <td>{{ $hasil->email }}</td>
                            <td>{{ $hasil->departement->name }}</td>
                            <td>
                                <form action="{{ route('user.destroy', $hasil->id) }}" method="post" id="deleteButton">
                                    @method('DELETE')
                                    @csrf
                                    <a href="{{ route('user.edit', $hasil->id) }}" class="btn btn-primary btn-sm">Edit</a>
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
    {{-- <script>
    $('.btn-danger').click(function (e) {
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

</script> --}}

@endsection
