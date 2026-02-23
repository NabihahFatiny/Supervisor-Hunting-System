<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';
    public $timestamps = true;
    protected $fillable = [
        'lecturer_id',
        'student_id',
        'topic',
        'day',
        'time',
        'location',
        'status', // status field to track if the request is pending, accepted, or rejected
        'created_at',
        'updated_at',
    ];
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'lecturerID');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_Id');
    }
}
