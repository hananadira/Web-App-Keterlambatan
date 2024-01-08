@extends('layouts.template')

@section('content')
<div class="">
    <h2>Edit Data Siswa</h2>
    <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('student.index') }}">Data Siswa</a> / <a href="{{ route('student.edit', $students['id']) }}">Edit Data Siswa</a></p> 
</div>
    <form action="{{ route('student.student.update', $students['id']) }}" method="POST" class="card p-5">
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
            <label for="nis" class="col-sm-2 col-form-label">Nis</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nis" name="nis" value="{{ $students['nis'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $students['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rombel" class="col-sm-2 col-form-label">Rombel :</label>
            <div class="col-sm-10">
                <select name="rombel_id" id="rombel" class="form-select">
                    <option selected disabled hidden>Pilih</option>
                    @foreach($rombel as $item)
                    <option value="{{ $item->id }}" @if($students->rombel_id == $item->id) selected @endif>{{ $item->rombel }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rayon" class="col-sm-2 col-form-label">Rayon :</label>
            <div class="col-sm-10">
                <select name="rayon_id" id="rayon" class="form-select">
                    <option selected disabled hidden>Pilih</option>
                    @foreach($rayon as $item)
                    <option value="{{ $item->id }}" @if($students->rayon_id == $item->id) selected @endif>{{ $item->rayon }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ubah Data</button>
    </form>
@endsection
