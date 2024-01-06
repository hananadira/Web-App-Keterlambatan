@extends('layouts.template')

@section('content')

    @if(Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
<div class="">
  <h3>Data Keterlambatan</h3>
  <p><a href="{{ route('dashboardps') }}">Home</a> / <a href="{{ route('ps.late.index') }}">Data Keterlambatan</a></p>
</div>
    <div id="awal">
      <button type="button" class="btn btn-info mb-4"><a href="{{ route('ps.late.export-excel.ps') }}">Export Data Keterlambatan</a></button>

    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="">Keseluruhan Data</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('ps.late.rekapitulasi') }}">Rekapitulasi Data</a>
      </li>
    </ul>

    {{-- <table class="table table-striped table-bordered table-hover"> --}}
      <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Informasi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($lates as $late)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $late->student->nis }} <br>
                        {{ $late->student->name }}
                    </td>
                    <td>{{ $late->date_time_late }}</td>
                    <td>{{ $late->information }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
    </div>

@endsection