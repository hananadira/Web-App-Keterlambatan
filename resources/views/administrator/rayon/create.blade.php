@extends('layouts.template')

@section('content')

<div class="">
    <h3>Tambah Data Rayon</h3>
    <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('rombel.index') }}">Data Rombel</a> / <a href="{{ route('rayon.create') }}">Tambah Data Rayon</a></p> 
</div>
    <form action="{{ route('rayon.store') }}" class="card p-5" method="post">
        @csrf
        {{-- validasi error message --}}
        @if ($errors->any())
        <ul class="alert alert-danger p-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        @if (Session::has('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif

        <div class="mb-3 row">
            <label for="rayon" class="col-sm-2 col-form-label">Rayon</label>
                <input type="text" name="rayon" id="rayon" class="form-control">
        </div>
        <div class="mb-3 row">
            <label for="user_id" class="col-sm-2 col-form-label">Pembimbing Siswa</label>
                <select name="user_id" id="user_id" class="form-select">
                    <option selected hidden disabled>Pilih Pembimbing Siswa</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
        </div>
        <button type="submit" class="btn btn-block btn-lg btn-primary" style="width:130px;">Tambah DAta</button>
    </form>
</div>
@endsection
