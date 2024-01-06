<?php

namespace App\Http\Controllers;

use App\Models\Late;
use App\Models\Rayon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Exports\PsLatesExport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;



class PsLateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lates = Late::with('student');

        $lateId = Auth::user()->id;
        $rayon = Rayon::where('user_id', $lateId)->first(); 

        if($rayon) {
            $lates->whereHas('student', function ($studentQuery) use ($rayon) {
                $studentQuery->where('rayon_id', $rayon->id);
            });
        }

        $query = $request->input('search');

        if ($query) {
            $lates->where(function ($lateQuery) use ($query) {
                $lateQuery->whereHas('student', function ($studentQuery) use ($query) {
                    $studentQuery->where('name', 'like', '%' . $query . '%');
                })
                ->orWhere('date_time_late', 'like', '%' . $query . '%')
                ->orWhere('information', 'like', '%' . $query . '%')
                ->orWhere('bukti', 'like', '%' . $query . '%');
            });

            // Jika tidak ada $rayon, tambahkan filter untuk student dengan rayon_id
            if (!$rayon) {
                $lates->whereHas('student', function ($studentQuery) use ($query) {
                    $studentQuery->where('name', 'like', '%' . $query . '%');
                }); 
            }
        }

        $rayonName = $rayon ? $rayon->rayon : '' ;

        $lates = $lates->get();
        return view('ps.late.index')->with(['lates' => $lates, 'rayonName' => $rayonName]);
    }

    



    public function rekapitulasi(Request $request)
    {
        $lateId = Auth::user()->id;

        $rayon = Rayon::where('user_id', $lateId)->first(); 

        $lates = Late::with('student');

        if($rayon) {
            $lates->whereHas('student', function ($studentQuery) use ($rayon) {
                $studentQuery->where('rayon_id', $rayon->id);
            });
        }


        $query = $request->input('search');

        if ($query) {
            $lates->where(function ($lateQuery) use ($query) {
                $lateQuery->whereHas('student', function ($studentQuery) use ($query) {
                    $studentQuery->where('name', 'like', '%' . $query . '%');
                })
                ->orWhere('date_time_late', 'like', '%' . $query . '%')
                ->orWhere('information', 'like', '%' . $query . '%')
                ->orWhere('bukti', 'like', '%' . $query . '%');
            });
        }

        $lates = $lates->get();

        return view('ps.late.rekapitulasi', compact('lates'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function PSshow($name_id)
    {
        $lates = Late::where('name_id', $name_id)->get(); // Mengambil semua data dengan name_id yang sesuai
        return view('ps.late.detail', compact('lates'));
    }

    public function PSshowPrint($id) {
        // Fetch a single late record by ID
        $lates = Late::find($id);
    
        // If the $id is provided, use the specific Late record
        if ($id) {
            return view('ps.late.print', compact('lates'));
        }
    
        // If $id is not provided, use the paginated list of Late records
        $lates = Late::with('student')->simplePaginate(10);
        return view('ps.late.print', compact('lates'));
    }


    public function PSdownloadPDF($id) {
        $lates = Late::find($id);
        if(!$lates){
            // Handle jika data tidak ditemukan
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $pdf = \PDF::loadView('ps.late.download-pdf', compact('lates'));

        return $pdf->download('surat-keterlambatan_ps.pdf');
    }


    public function PSexportExcel() {
        $File = 'data_keterlambatan_ps.xlsx';
        return Excel::download(new PsLatesExport, $File);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
