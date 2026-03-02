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
        'address',
        'province',
        'city',
        'district',
        'village',
        'postal_code',
        'blood_type',
        'height_cm',
        'weight_kg',
        'medical_history',
        'previous_school',
        'entry_year',
        'father_name',
        'father_job',
        'father_phone',
        'mother_name',
        'mother_job',
        'mother_phone',
        'guardian_name',
        'guardian_phone',
        'guardian_address',
        'art_hobby',
        'sport_hobby',
        'organization',
        'has_scholarship',
        'exit_date',
        'exit_reason',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_scholarship' => 'boolean',
        'birth_date' => 'date',
        'exit_date' => 'date',
        'entry_year' => 'integer',
        'height_cm' => 'integer',
        'weight_kg' => 'integer',
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
