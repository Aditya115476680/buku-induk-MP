<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHistory extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','previous_school','entry_year','notes'];

    public function student() { return $this->belongsTo(Student::class); }
}
