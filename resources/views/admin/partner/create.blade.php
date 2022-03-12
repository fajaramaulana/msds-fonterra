@extends('admin.template-admin.master')
@section('title', 'Partner')
@section('sub-judul', 'Tambah Partner')
@section('content')

@if(count($errors)>0)
@foreach($errors->all() as $error)
<div class="alert alert-danger" role="alert">
    {{ $error }}
</div>

@endforeach
@endif
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session('success')}}
</div>
@endif
<form action="{{ route('partner.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="judul">
    </div>
    <div class="form-group">
        <label>Gambar</label>
        <input type="file" class="form-control" name="gambar">
    </div>

    <div class="form-group">
        <button class="btn btn-primary btn-block">Simpan Partner</button>
    </div>
</form>


@endsection