@extends('admin.template-admin.master')
@section('title', 'Berita')
@section('sub-judul', 'Edit Berita')
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
<form action="{{ route('beritadashboard.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label>Judul</label>
        <input type="text" class="form-control" value="{{ $berita->judul}}" name="judul">
    </div>
    <div class="form-group">
        <label>Rangkuman</label>
        <input type="text" class="form-control" value="{{ $berita->rangkuman}}" name="rangkuman">
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10" >{{ $berita->deskripsi }}</textarea>
    </div>
    <div class="form-group">
        <label>Gambar</label>
        <input type="file" class="form-control" name="gambar">
    </div>

    <div class="form-group">
        <button class="btn btn-primary btn-block">Update Berita</button>
    </div>
</form>

<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('deskripsi');
</script>

@endsection