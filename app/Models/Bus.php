<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'name', 'driver', 'phone', 'route', 'capacity',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_bus')
            ->withPivot('pickup_point', 'dropoff_point')
            ->withTimestamps();
    }
}