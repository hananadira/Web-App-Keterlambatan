@extends('layouts.template')

@section('content')
<div class="">
    <h3>Edit Data Keterlambatan </h3>
    <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('late.rekapitulasi') }}">Data Keterlambatan</a> / <a href="{{ route('late.edit', $lates['id']) }}">Edit Data Keterlambatan</a></p> 
</div>
    <form action="{{ route('late.update', $lates['id']) }}" method="post" class="card p-5">
        @csrf
        @method('PATCH')

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
            <label for="name_id" class="col-sm-2 col-form-label" >Nis</label>
            <div class="col-sm-10">
                <select name="name_id" id="name_id" class="form-select">
                    @foreach ($students as $item)
                        <option value="{{ $item->id }}" {{ $item->id === $lates->name_id ? 'selected' : '' }}>{{ $item->nis }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        

        {{-- <div class="mb-3 row">
            <label for="name_id" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name_id" name="name_id" value="{{ $lates->student->name }}">
            </div>
        </div>         --}}
        <div class="mb-3 row">
            <label for="date_time_late" class="col-sm-2 col-form-label">Tanggal :</label>
            <div class="col-sm-10">
                <input type="datetime" name="date_time_late" id="date_time_late" class="form-control" required value="{{ $lates['date_time_late'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="information" class="col-sm-2 col-form-label">Keterangan Keterlambatan :</label>
            <div class="col-sm-10">
                <input type="text" name="information" id="information" class="form-control" required value="{{ $lates['information'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="bukti" class="col-sm-2 col-form-label">Bukti :</label>
            <div class="col-sm-10">
                <input type="file" name="bukti" id="bukti" class="form-control" required value="{{ $lates['bukti'] }}">
            </div>
        </div>
        <div class="mb-3 row" style="width: 330px">
            <img src="{{ asset('img/' . $lates->bukti) }}" alt="Bukti">
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Edit Data</button>
    </form>
@endsection