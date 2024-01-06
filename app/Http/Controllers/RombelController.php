<?php

namespace App\Http\Controllers;

use App\Models\Rombel;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rombel = Rombel::all();
        return view('administrator.rombel.index', compact('rombel'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.rombel.create');
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
            'rombel'=>'required|min:3',
        ]);

        Rombel::create([
            'rombel'=> $request->rombel,
        ]);

        return redirect()->route('rombel.index')->with('success', 'Berhasil menambahkan data rombel!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function show(Rombel $rombel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rombel = Rombel::find($id);

        return view('administrator.rombel.edit', compact('rombel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rombel'=>'required|min:3',
        ]);

        Rombel::where('id', $id)->update([
            'rombel'=> $request->rombel,
        ]); 

        return redirect()->route('rombel.index')->with('success', 'Berhasil mengubah data rombel!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rombel  $rombel
     * @return \Illuminate\Http\Response
     */

     public function destroy($id)
    {
        try {
            $rombel = Rombel::findOrFail($id);

            $keterlambatan = $rombel->student()->first(); 

            if ($keterlambatan) {
                return redirect()->back()->with('gagal', 'Rombel masih digunakan oleh data keterlambatan!');
            }

            $rombel->delete();

            return redirect()->route('rombel.index')->with('deleted', 'Berhasil menghapus data!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



     
}
