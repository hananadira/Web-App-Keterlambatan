@extends('layouts.template')

@section('content')

    @if(Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if(Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    @if(Session::get('gagal'))
        <div class="alert alert-warning">{{ Session::get('gagal') }}</div>
    @endif
<div class="">
  <h3>Data Rombel</h3>
  <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('rombel.index') }}">Data Rombel</a></p>
</div>

<table id="example" class="table table-striped" style="width:100%">
  <div class="d-flex justify-content mb-3">
      <a class="btn btn-primary" href="{{ route('rombel.create') }}">Tambah Rombel</a>
  </div>
         <thead>
            <tr>
                <th>No</th>
                <th>Rombel</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($rombel as $rombel)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $rombel['rombel'] }}</td>
                    <td class="d-flex justify-content-center">
                      <a href="{{ route('rombel.edit', $rombel['id']) }}" class="btn btn-primary me-3">Edit</a>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-rombel-{{ $rombel['id'] }}">
                          Hapus
                      </button>
                  </td>
                </tr>
                <div class="modal" tabindex="-1" id="delete-rombel-{{ $rombel['id'] }}">
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
                          <form action="{{ route('rombel.delete', $rombel['id']) }}" method="post">
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

@endsection