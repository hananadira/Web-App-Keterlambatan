<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Late extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name_id',
        'date_time_late',
        'information',
        'bukti',
    ];

    protected $casts = [
        'lates' => 'array',
    ];

    public function student() {
        return $this->belongsTo(Student::class, 'name_id', 'id');
    }
}
