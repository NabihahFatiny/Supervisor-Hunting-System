<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory, Notifiable;

    // Specify the table if it doesn't follow Laravel's naming conventions
    protected $table = 'student';  // Optional if table is named 'students'

    // Specify the primary key column if it's not 'id'
    protected $primaryKey = 'student_Id';  // Optional if primary key is 'student_id'

    // If the table does not have 'created_at' and 'updated_at' columns
    public $timestamps = true;  // Set to false if the table doesn't use timestamps

    // Define the columns that are mass assignable (Optional)
    protected $fillable = [
        'studName',
        'studEmail',
        'studentID',
        'user_Id',
        'lecturer_Id',
        'title_Id',
        'assignedgroup_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(UserShs::class, 'user_Id');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'student_id', 'student_Id');
    }
    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail()
    {
        return $this->studEmail;
    }
}
