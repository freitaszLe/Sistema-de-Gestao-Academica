<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'subject_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /**
     * Get the teacher associated with the schedule.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the subject associated with the schedule.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'schedule_id', 'student_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
