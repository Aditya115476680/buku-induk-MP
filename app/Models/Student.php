<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nisn',
        'name',
        'birth_place',
        'birth_date',
        'photo_path',
        'current_class_id',
        'is_active',
        'address'
    ];

    public function currentClass()
    {
        return $this->belongsTo(SchoolClass::class, 'current_class_id');
    }

    public function studentParent()
    {
        return $this->hasOne(StudentParent::class);
    }

    public function histories()
    {
        return $this->hasMany(StudentHistory::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}

