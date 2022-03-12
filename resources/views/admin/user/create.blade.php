@extends('admin.template-admin.master')
@section('title', 'List User')
@section('sub-judul', 'Tambah User')
@section('content')

    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama User</label>
            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama User">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan Email User">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Masukkan Password User"
                id="lihatPassword">
            <input type="checkbox" onclick="fungsiLihatPassword()"><label>Show Password</label>
        </div>
        <div class="form-group">
            <label>Departement</label>
            <select class="form-control" name="departement_id">
                <option value="" holder>Pilih Departement</option>
                @foreach ($departement as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block">Simpan User Baru</button>
        </div>
    </form>

    <script>
        function fungsiLihatPassword() {
            var x = document.getElementById("lihatPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
