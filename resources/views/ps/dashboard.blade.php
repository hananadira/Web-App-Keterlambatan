@extends('layouts.template')

@section('content')
<style>
  .card-body h1 {
    margin-right: 170px; 
    margin-top: 15px; 
    float: right;
  }
</style>
<div class="card-title">
               <h4>Dasboard</h4>
               <p>Home / Dashboard</p>
           </div>
<div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col w-45">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Peserta Didik Rayon {{ App\Models\Rayon::where('user_id', Auth::user()->id)->pluck('rayon')->first(); }}</h5>
                <i><svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
              </svg></i>
              @php 
                $userId = Auth::user()->id;
                $students = optional(App\Models\Rayon::where('user_id', $userId)->first())->students()->with('rombel', 'rayon')->simplePaginate(10);
              @endphp
              <h1>{{ $students->count() }}</h1>
            </div>
          </div>
        </div>
        <div class="col w-18">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Keterlambatan  {{ App\Models\Rayon::where('user_id', Auth::user()->id)->pluck('rayon')->first(); }} hari ini</h5>
              <p id="tanggalDiv"></p>
              <i><svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
              </svg></i>
              @php 
                  $lates = App\Models\Late::whereIn('name_id', 
                      App\Models\Rayon::where('user_id', Auth::user()->id)->pluck('id')
                          ->flatMap(function ($rayonId) {
                              return App\Models\Student::where('rayon_id', $rayonId)->pluck('id');
                          })
                  )
                  ->whereDate('date_time_late', Illuminate\Support\Carbon::today())
                  ->get();
              @endphp
            <h1>{{ $lates->count() }}</h1>
            </div>
          </div>
        </div>
      </div>
@endsection
