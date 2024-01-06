@extends('layouts.template')

@section('content')
<div class="">
    <h3>Tambah Data Siswa</h3>
    <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('student.index') }}">Data Siswa</a> / <a href="{{ route('student.student.create') }}">Edit Data Siswa</a></p>
</div>
    <form action="{{ route('student.student.store') }}" method="POST" class="card p-5">
        @csrf
        {{-- @method('PATCH') --}}

        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="mb-3 row">
            <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                <input type="number" class="form-control" id="nis" name="nis">
        </div>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                <input type="string" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3 row">
            <label for="rombel_id" class="col-sm-2 col-form-label">Rombel :</label>
                <select name="rombel_id" id="rombel_id" class="form-select">
                    <option value="" selected disabled hidden>Pilih</option>
                        @foreach($rombel as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->rombel }}
                            </option>
                        @endforeach
                </select> 
        </div>
        <div class="mb-3 row">
            <label for="rayon_id" class="col-sm-2 col-form-label">Rayon :</label>
                <select name="rayon_id" id="rayon_id" class="form-select">
                    <option value="" selected disabled hidden>Pilih</option>
                        @foreach($rayon as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->rayon }}
                            </option>
                        @endforeach
                </select>  
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
@endsection
