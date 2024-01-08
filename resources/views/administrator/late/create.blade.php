
@extends('layouts.template')

@section('content')
<div>
    <h3>Tambah Data Keterlambatan</h3>
    <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('late.rekapitulasi') }}">Data keterlambatan</a> / 
        <a href="{{ route('late.create') }}">Tambah Data Keterlambatan</a></p>
</div>
<form action="{{ route('late.store') }}" method="post" class="card p-5" enctype="multipart/form-data">
        @csrf

        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Siswa</label>
                <select name="name_id" id="name_id" class="form-select">
                    <option selected hidden disabled>Pilih Nama</option>
                    @foreach ($students as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
        </div>
       
            {{-- <label for="name_id" class="col-sm-2 col-form-label">Siswa : </label>
                <input type="text" class="form-control" id="name_id" name="name_id" required> --}}
                
        <div class="mb-3 row">
            <label for="date_time_late" class="col-sm-2 col-form-label">Tanggal :</label>
            @php
            use Carbon\Carbon;
            $waktu_wib = Carbon::now('Asia/Jakarta')->format('Y-m-d\TH:i:s');
            @endphp
                <input type="datetime-local" name="date_time_late" id="date_time_late" class="form-control" required
                       value="{{ $waktu_wib }}">
        </div>
        <div class="mb-3 row">
            <label for="information" class="col-sm-2 col-form-label">Keterangan Keterlambatan :</label>
                <input type="text" name="information" id="information" class="form-control" required>
        </div>
        <div class="mb-3 row">
            <label for="bukti" class="col-sm-2 col-form-label">Bukti :</label>
                <input type="file" name="bukti" id="bukti" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
@endsection