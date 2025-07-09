<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'capacity','teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'registrations', 'course_id', 'student_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function isFull()
    {
        return $this->registrations()->count() >= $this->capacity;
    }
}
