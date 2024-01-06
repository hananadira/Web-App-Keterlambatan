<?php

namespace App\Exports;

use App\Models\Late;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LatesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        // Menggunakan distinct() untuk memastikan bahwa data yang sama hanya muncul sekali
        return Late::select('name_id')
            ->distinct()
            ->get();
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
        $student = Late::where('name_id', $late->name_id)->first();

        return [
            $student->student->nis,
            $student->student->name,
            optional(json_decode($student->student->rombel))->rombel,
            optional(json_decode($student->student->rayon))->rayon,
            Late::where('name_id', $late->name_id)->count(),
        ];
    }
}
