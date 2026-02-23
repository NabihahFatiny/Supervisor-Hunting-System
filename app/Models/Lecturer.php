<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lecturer extends Model
{
    use HasFactory, Notifiable;

    // Specify the table if it doesn't follow Laravel's naming conventions
    protected $table = 'lecturers';  // Optional if table is named 'students'

    // Specify the primary key column if it's not 'id'
    protected $primaryKey = 'lecturerID';  // Optional if primary key is 'student_id'

    // If the table does not have 'created_at' and 'updated_at' columns
    public $timestamps = true;  // Set to false if the table doesn't use timestamps

    // Define the columns that are mass assignable (Optional)
    protected $fillable = [
        'lecturerID',
        'lecturerName',
        'email',
        'idlecturer',
        'current_quota',
        'user_Id',
        'assignedgroup_id',
        'assigned_quota',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(UserShs::class, 'user_Id'); // Adjust the foreign key if necessary
    }

    public function quota()
    {
        return $this->hasOne(Quota::class, 'lecturer_id', 'lecturerID');
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }
    //get balance quota
    public function getBalanceQuotaAttribute()
    {
        return $this->assigned_quota - $this->current_quota;
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'lecturer_id', 'lecturerID');
    }
}
