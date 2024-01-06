<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rayon;
use Illuminate\Http\Request;

class RayonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rayon = Rayon::with('user')->simplePaginate(10);
        return view('administrator.rayon.index', compact('rayon'));
        // $rayons = Rayon::all();
        // return view('administrator.rayon.index', compact('rayons'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('administrator.rayon.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rayon' => 'required',
            'user_id' => 'required',
        ]);
    
        Rayon::create([
            'rayon' => $request->rayon,
            'user_id' => $request->user_id,
        ]);
    
        return redirect()->route('rayon.index')->with('success', 'Berhasil menambahkan data rayon!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rayon  $rayon
     * @return \Illuminate\Http\Response
     */
    public function show(Rayon $rayon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rayon  $rayon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rayon = Rayon::with('user')->find($id);
        $users = User::all(); // Ambil data User untuk dropdown pembimbing
    
        return view('administrator.rayon.edit', compact('rayon', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rayon  $rayon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rayon' => 'required',
            'user_id' => 'required',
        ]);
    
        Rayon::where('id', $id)->update([
            'rayon' => $request->rayon,
            'user_id' => $request->user_id,
        ]); 
    
        return redirect()->route('rayon.index')->with('success', 'Berhasil mengubah data rayon!');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rayon  $rayon
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     Rayon::where('id', $id)->delete();

    //     return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    // }

    public function destroy($id)
    {
        $rayon = Rayon::find($id);

        if (!$rayon) {
            return redirect()->back()->with('gagal', 'Data tidak ditemukan!');
        }

        // Ganti dengan relasi yang sesuai, contohnya 'siswa'
        $siswaUsingrayon = $rayon->students()->exists(); 

        if ($siswaUsingrayon) {
            return redirect()->back()->with('gagal', 'rayon masih digunakan oleh data keterlambaran!');
        }

        $rayon->delete();

        return redirect()->route('rayon.index')->with('deleted', 'Berhasil menghapus data!');
    }
}
