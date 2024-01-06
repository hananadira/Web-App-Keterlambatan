<?php

namespace App\Exports;

use App\Models\Late;
use App\Models\Rayon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Auth;

class PsLatesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        $lateId = Auth::id(); // Mendapatkan ID pengguna yang sedang login
        $rayon = Rayon::where('user_id', $lateId)->first(); // Mendapatkan data rayon berdasarkan ID pengguna yang login

        if (!$rayon) {
            return collect(); // Kembalikan koleksi kosong jika tidak ada rayon yang terkait dengan pengguna yang login
        }

        $rayonId = $rayon->id;

       
        $lates = Late::whereHas('student', function ($studentQuery) use ($rayonId) {
            $studentQuery->where('rayon_id', $rayonId);
        })
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('lates as l')
                ->whereColumn('l.name_id', 'lates.name_id')
                ->whereRaw('l.id < lates.id'); // Menghindari data yang lebih lama
        })
        ->get();     

        return $lates;
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama',
            'Rombel',
            'Rayon',
            'Total Keterlambatan'
        ];
    }

    public function map($late): array
    {
        $student = $late->student;

        return [
            $student->nis ?? null,
            $student->name ?? null,
            optional(json_decode($student->rombel))->rombel ?? null,
            optional(json_decode($student->rayon))->rayon ?? null,
            Late::where('name_id', $late->name_id)->count(),
        ];
    } 
}

?>