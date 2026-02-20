<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','father_name','father_phone','mother_name','mother_phone','guardian_name','guardian_phone','address'];

    public function student() { return $this->belongsTo(Student::class); }
}
