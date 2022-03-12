@extends('admin.template-admin.master')
@section('title', 'List User')
@section('sub-judul', 'Edit User')
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
<form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" value="{{ $user->name}}" name="name">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" value="{{ $user->email}}" name="email" readonly>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="Masukkan Password Baru" id="lihatPassword">
        <input type="checkbox" onclick="fungsiLihatPassword()"><label>Show Password</label>
    </div>
    <div class="form-group">
        <label>Tipe User</label>
        <select class="form-control" name="departement_id">
            <option value="">Pilih Departement</option>
            @foreach($departements as $departement)
            <option value="{{ $departement->id }}" {{ $user->departement_id == $departement->id ? 'selected' : '' }}>{{ $departement->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary btn-block">Update User</button>
    </div>
</form>
@endsection