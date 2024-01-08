@extends('layouts.template')

@section('content')

    @if(Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if(Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <div class="">
        <h3>Data Keterlambatan</h3>
        <p><a href="{{ route('dashboardps') }}">Home</a> / <a href="{{ route('ps.late.index') }}">Data Keterlambatan</a></p>
    </div>
    <div id="awal">
        <button type="button" class="btn btn-info mb-4"><a href="{{ route('ps.late.export-excel.ps') }}">Export Data Keterlambatan</a></button>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route('ps.late.index') }}">Keseluruhan Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Rekapitulasi Data</a>
            </li>
        </ul>

        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jumlah Keterlambatan</th>
                    <th class="text-center">Cetak Surat</th>
                </tr>
            </thead>
            <tbody>
                @php
                $lateCounts = []; 
                @endphp
                @foreach ($lates as $late)
                    @php
                    $studentId = $late->student->id;
                    if (!isset($lateCounts[$studentId])) {
                        $lateCounts[$studentId] = 1; 
                    } else {
                        $lateCounts[$studentId] += 1; 
                    }
                    @endphp
                @endforeach

                @php $no = 1; @endphp
                @foreach ($lateCounts as $studentId => $count)
                    @php
                    $late = $lates->firstWhere('student.id', $studentId); 
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $late->student->nis }}</td>
                        <td>{{ $late->student->name }}</td>
                        <td>{{ $count }}</td>
                        <td class="d-flex justify-content-center">
                          {{-- detail rekapitulasi --}}
                        <a href="{{ route('ps.late.show.ps', ['name_id' => $late->name_id]) }}" style="color: rgb(75, 124, 191);">Lihat</a>
                          
                        @if ($count >= 3)
                        <a href="{{ route('ps.late.print.ps', ['id' => $late->id]) }}" class="btn btn-primary" style="margin-left: 25px;" onclick="setTanggal()">Cetak Surat Pernyataan</a>
                        @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/tanggal.js') }}"></script>

@endsection
