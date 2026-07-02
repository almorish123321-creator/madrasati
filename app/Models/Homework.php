<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Homework extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description'];
    protected $fillable = [
        'title', 'description', 'file', 'subject_id', 'teacher_id', 'grade_id', 'section_id', 'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function submissions()
    {
        return $this->hasMany(HomeworkSubmission::class, 'homework_id');
    }
}