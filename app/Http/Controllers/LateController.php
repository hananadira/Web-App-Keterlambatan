<?php

namespace App\Http\Controllers;

use App\Models\Late;
use App\Models\Student;
use Barryvdh\DomPDF\PDF;
use App\Exports\LatesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class LateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lates = Late::with('student'); // Objek query utama

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

        return view('administrator.late.index', compact('lates'));
    }


    public function rekapitulasi(Request $request)
    {
        $lates = Late::with('student'); // Objek query utama

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

        return view('administrator.late.rekapitulasi', compact('lates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = Student::all();
        return view('administrator.late.create', compact('students'));
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
            'name_id' => 'required',
            'date_time_late' => 'required',
            'information' => 'required',
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif', 
        ],
        [
            'name_id.required' => 'nama siswa harus dipilih',
            'information.required' => 'informasi harus diisi',
            'bukti.required' => 'gambar harus diisi',
        ]);
    
        $imageName = time() . '.' . $request->bukti->extension(); // Generate unique image name
        $request->bukti->move(public_path('img'), $imageName); // Move uploaded file to 'public/img' directory
    
        Late::create([
            'name_id' => $request->name_id,
            'date_time_late' => $request->date_time_late,
            'information' => $request->information,
            'bukti' => $imageName, // Save image name in the database
        ]);
    
        return redirect()->route('late.index')->with('success', 'Berhasil menambahkan data keterlambatan!');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @ret     urn \Illuminate\Http\Response
     */
    public function show(string $name_id)
    {
        $lates = Late::where('name_id', $name_id)->get();
        return view('administrator.late.detail', compact('lates'));
    }  
    
    public function showPrint($id) {
        $lates = Late::find($id);
        if ($id) {
            return view('administrator.late.print', compact('lates'));
        }
    
        $lates = Late::with('student')->simplePaginate(10);
        return view('administrator.late.print', compact('lates'));
    }
    
    public function downloadPDF($id) {
        $lates = Late::find($id)->toArray();

        $lates = Late::find($id);

        view()->share('lates', $lates);
        $pdf = \PDF::loadView('administrator.late.download-pdf', compact('lates'));


        return $pdf->download('surat-keterlambatan.pdf');
    }

    public function exportExcel() {
        $File = 'data_keterlambatan.xlsx';
        return Excel::download(new LatesExport, $File);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

   // Controller Function (edit method)
    // public function edit(Student $student, $id)
    // {
    //     $lates = Late::with('student')->find($id);
    //     $students = Student::all();

    //     return view('administrator.student.edit', compact('lates', 'students'));
    // }


    public function edit($id)
    {
        $lates = Late::with('student')->find($id);
        $students = Student::all();

        return view('administrator.late.edit', compact('lates', 'students'));
    }

    /**
     * Update the specified resource in storage.
     *z
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_id' => 'required',
            'date_time_late' => 'required',
            'information' => 'required',
            'bukti' => 'sometimes|required_without:name_id,date_time_late,information|mimes:png,jpg,jpeg|max:2048',
        ]);        
    
        // Mengambil data terlambat berdasarkan ID
        $lates = Late::findOrFail($id);
    
        $lateData = [
            'name_id' => $request->name_id,
            'date_time_late' => $request->date_time_late,
            'information' => $request->information,
        ];
    
        if ($request->hasFile('bukti') && $request->file('bukti')->isValid()) {
            if ($lates->bukti) {
                Storage::disk('public')->delete($lates->bukti);
            }
    
            $file = $request->file('bukti');
            $path = $file->store('photouser', 'public');
    
            $lateData['bukti'] = $path;
        }
    
        $lates->update($lateData);
    

        return redirect()->route('late.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Late::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }
}
