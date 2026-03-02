<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    // RELASI: teacher milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // RELASI: teacher bisa jadi wali 1 kelas (school_classes.homeroom_teacher_id -> teachers.id)
    public function homeroomClass()
    {
        return $this->hasOne(\App\Models\SchoolClass::class, 'homeroom_teacher_id');
    }
}
