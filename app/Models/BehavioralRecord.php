<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BehavioralRecord extends Model
{
    protected $fillable = [
        'student_id', 'type', 'description', 'points', 'teacher_id', 'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function scopePositive($query)
    {
        return $query->where('type', 'positive');
    }

    public function scopeNegative($query)
    {
        return $query->where('type', 'negative');
    }
}