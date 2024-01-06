@extends('layouts.template')

@section('content')
<div class="container">
    <h3>Edit Data User</h3>
    <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('user.index') }}">Data User</a> / <a href="{{ route('user.edit', $users['id']) }}">Edit Data User</a></p>
</div>
    <form action="{{ route('user.update', $users['id']) }}" method="post" class="card p-5">
        @csrf
        @method('PATCH')

        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
            
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama : </label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $users['name'] }}">
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email : </label>
                <input type="text" name="email" id="email" class="form-control" value="{{ $users['email'] }}">
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe Pengguna : </label>
               <select name="role" id="role" class="form-select">
                    <option selected disabled hidden>Pilih</option>
                    <option value="admin" {{ $users['role'] == 'admin' ? 'selected' : '' }}>admin</option>
                    <option value="ps" {{ $users['role'] == 'ps' ? 'selected' : '' }}>ps</option>
               </select>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Ubah password : </label>
                <input type="password" name="password" id="password" class="form-control" >
        </div>
        <button type="submit" class="btn btn-primary mt-3">Edit</button>
    </form>
@endsection