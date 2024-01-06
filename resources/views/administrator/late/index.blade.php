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
  <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('late.index') }}">Data Keterlambatan</a></p>
</div>
    <div id="awal">
      <button type="button" class="btn btn-primary mb-4"><a href="{{ route('late.create') }}">Tambah</a></button>
      <button type="button" class="btn btn-info mb-4"><a href="{{ route('late.export-excel') }}">Export Data Keterlambatan</a></button>

    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="">Keseluruhan Data</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('late.rekapitulasi') }}">Rekapitulasi Data</a>
      </li>
    </ul>

    <table id="example" class="table table-striped" style="width:100%">
      <thead>
          <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Tanggal</th>
              <th>Informasi</th>
              <th class="text-center">Aksi</th>
          </tr>
      </thead>
      <tbody>
          @php $no = 1; @endphp
          @foreach ($lates as $late)
              <tr>
                  <td>{{ $no++ }}</td>
                  <td>
                      {{ $late->student->nis }} <br>
                      {{ $late->student->name }}
                  </td>
                  <td>{{ $late->date_time_late }}</td>
                  <td>{{ $late->information }}</td>
                  <td class="text-center">
                      <a href="{{ route('late.edit', $late['id']) }}" class="btn btn-primary me-3">Edit</a>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#edit-stock{{ $late['id'] }}">
                          Hapus
                      </button>
                  </td>
              </tr>

              <div class="modal" tabindex="-1" id="edit-stock{{ $late['id'] }}">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">Konfirmasi Hapus</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <p>Yakin ingin menghapus data ini? </p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <form action="{{ route('late.delete', $late['id']) }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger">Hapus</button>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          @endforeach
      </tbody>
  </table>
</div>

@endsection