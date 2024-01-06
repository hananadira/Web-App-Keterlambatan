<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'name',
        'rombel_id',
        'rayon_id',
    ];

    public function rombel() {
        return $this->belongsTo(Rombel::class);
    }
    public function rayon() {
        return $this->belongsTo(Rayon::class);
    }

    public function late() {
        return $this->hasMany(Late::class);
    }


}
