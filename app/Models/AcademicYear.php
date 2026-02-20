<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
        'year_start',
        'year_end',
        'is_active'
    ];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function subjectOfferings()
    {
        return $this->hasMany(SubjectOffering::class);
    }
}