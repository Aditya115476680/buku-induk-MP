<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectOffering extends Model
{
    protected $fillable = [
        'subject_id',
        'school_class_id',
        'academic_year_id',
        'semester_id',
        'teacher_id'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function teacher()
    {
    return $this->hasOne(\App\Models\Teacher::class, 'user_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    
}