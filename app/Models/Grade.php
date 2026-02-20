<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_offering_id',
        'score',
        'notes'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subjectOffering()
    {
        return $this->belongsTo(SubjectOffering::class);
    }
}
