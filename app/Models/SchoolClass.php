<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = ['grade_level','major_id','rombel','homeroom_teacher_id'];

    public function major()
    {
        return $this->belongsTo(\App\Models\Major::class);
    }

    public function homeroomTeacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'homeroom_teacher_id');
    }
}
