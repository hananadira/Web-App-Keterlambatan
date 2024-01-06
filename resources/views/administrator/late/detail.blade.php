@extends('layouts.template')

@section('content')

<style>
    span {
        color: blue;
    }
    p {
        margin-left: 10px;
    }
    .card {
        margin-bottom: 20px;
    }
    .card-img {
        width: 220px;
        margin-left: 60px;
        margin-bottom: 10px;
    }
</style>
<div class="container">
    <div class="text">
        <h1>Detail Data Keterlambatan</h1>
        <p><a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('late.rekapitulasi') }}">Data Keterlambatan</a> / 
            @php
            $first = true;
            @endphp
        
        @foreach ($lates as $late)
            @if ($first)
                <a href="{{ route('late.rekapitulasi.show', ['name_id' => $late->name_id]) }}">Detail Data Keterlambatan</a>
                @php
                    $first = false;
                @endphp
            @endif
        @endforeach
        
    </div>
    @foreach ($lates as $late)
    {{ $late->student->nis . ' / ' . $late->student->name . ' / ' . 
    optional(json_decode($late->student->rombel))->rombel . ' / ' . optional(json_decode($late->student->rayon))->rayon }}
    @break
@endforeach


    <div class="row row-cols-1 row-cols-md-3 g-4">
        @php $no = 1; @endphp 
        @foreach($lates as $late)
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="text-body-secondary">Keterlambatan Ke {{ $no++ }}</h5>
                    <p class="card-text">{{ $late->date_time_late }} <br><span>{{ $late->information }}</span></p>
                </div>
               <div class="img">
                <img src="{{ asset('img/' . $late->bukti) }}" alt="Bukti">
               </div>
            </div>
        </div>
        @endforeach
    </div>
</div>



@endsection
