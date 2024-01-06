@extends('layouts.template')

@section('content')

    @if(Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if(Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif

    <div class="">
        <h2>Data Siswa</h2>
        <p><a href="{{ route('dashboardps') }}">Home</a> / <a href="{{ route('ps.student.index.ps') }}">Data Siswa</a></p>
    </div>
    {{-- <table class="table table-striped table-bordered table-hover"> --}}
        <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nis</th>
                <th>Nama</th>
                <th>Rombel</th>
                <th>Rayon</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($students as $student)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $student['nis'] }}</td>
                    <td>{{ $student['name'] }}</td>
                    <td>{{ $student->rombel->rombel }}</td>
                    <td>{{ $student->rayon->rayon }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
@endsection