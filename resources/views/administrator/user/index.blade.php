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
      <h3>Data User</h3>
      <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('user.index') }}">Data User</a></p>
    </div>
    <div class="d-flex justify-content mb-3">
      <a class="btn btn-primary" href="{{ route('user.create') }}">Tambah User</a>
    </div>

    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($users as $user)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['role'] }}</td>
                    <td class="d-flex justify-content-center">
                      <a href="{{ route('user.edit', $user['id']) }}" class="btn btn-primary me-3">Edit</a>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-user-{{ $user['id'] }}">
                          Hapus
                      </button>
                  </td>
                </tr>
                <div class="modal" tabindex="-1" id="delete-user-{{ $user['id'] }}">
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
                          <form action="{{ route('user.delete', $user['id']) }}" method="post">
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