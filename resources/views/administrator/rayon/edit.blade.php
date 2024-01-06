@extends('layouts.template')

@section('content')

<div class="">
    <h3>Edit Data Rayon </h3>
    <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('rombel.index') }}">Data Rombel</a> / <a href="{{ route('rayon.edit', $rayon['id']) }}">Edit Data Rayon</a></p> 
</div>
        
        <form action="{{ route('rayon.update', $rayon['id']) }}" class="card p-5" method="post">
            @csrf
            @method('PATCH') 
            
            {{-- validasi error message --}}
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif
            
            <div class="mb-3 row">
                <label for="rayon" class="col-sm-2 col-form-label">Rayon :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="rayon" name="rayon" required  value="{{ $rayon['rayon'] }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="ps" class="col-sm-2 col-form-label" >Pembimbing Siswa</label>
                <div class="col-sm-10">
                    <select name="user_id" id="user_id" class="form-select">
                        @foreach ($users as $item)
                            <option value="{{ $item->id }}" {{ $item->id === $rayon->user_id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-lg btn-primary" style="width:130px;">Edit Data</button>
        </form>
    </div>
@endsection
