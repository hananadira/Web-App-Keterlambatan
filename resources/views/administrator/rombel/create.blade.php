@extends('layouts.template')

@section('content')
<div class="">
    <h3>Tambah Data Rombel</h3>
    <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('rombel.index') }}">Data Rombel</a> / <a href="{{ route('rombel.create') }}">Tambah Data Rombel</a></p>
</div>
    <form action="{{ route('rombel.store') }}" method="post" class="card p-5">
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
            <label for="rombel" class="col-sm-2 col-form-label">Rombel :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rombel" name="rombel" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
@endsection
