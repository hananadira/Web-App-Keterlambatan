<?php

namespace App\Http\Controllers;

use App\Models\Rayon;
use App\Models\Rombel;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with(['rombel', 'rayon'])->simplePaginate(10);
    
        return view('administrator.student.index', compact('students'));
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rombel = Rombel::all();
        $rayon = Rayon::all();
        return view('administrator.student.create', compact('rombel', 'rayon'));

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
            'nis'=>'required',
            'name'=>'required',
            'rombel_id'=>'required',
            'rayon_id'=>'required',
        ],
         [
            'nis.required' => 'nis siswa harus diisi',
            'name.required' => 'nama siswa harus diisi',
            'rombel_id.required' => 'rombel harus dipilih',
            'rayon_id.required' => 'rayon siswa harus dipilih',
        ]);

        Student::create([
            'nis' => $request->nis,
            'name'=> $request->name,
            'rombel_id' => $request->rombel_id,
            'rayon_id' => $request->rayon_id,
        ]);

        return redirect()->route('student.index')->with('success', 'Berhasil menambahkan data student!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student, $id)
    {
        $students = Student::with('rombel', 'rayon')->find($id);
        $rombel = Rombel::all();
        $rayon = Rayon::all();

        return view('administrator.student.edit', compact('students', 'rombel', 'rayon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nis'=>'required|min:8',
            'name'=>'required',
            'rombel_id'=>'required',
            'rayon_id'=>'required',
        ]);

        Student::where('id', $id)->update([
            'nis'=> $request->nis,
            'name'=> $request->name,
            'rombel_id'=> $request->rombel_id,
            'rayon_id'=> $request->rayon_id,
        ]); 

        return redirect()->route('student.index')->with('success', 'Berhasil mengubah data student!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $students = Student::find($id);

        if (!$students) {
            return redirect()->back()->with('gagal', 'Data tidak ditemukan!');
        }

        $siswaUsingstudent = $students->replicate()->exists(); 

        if ($siswaUsingstudent) {
            return redirect()->back()->with('gagal', 'data siswa masih digunakan oleh data keterlambatan!');
        }

        $students->delete();

        return redirect()->route('student.index')->with('deleted', 'Berhasil menghapus data!');
    }
}
