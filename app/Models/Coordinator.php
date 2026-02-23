<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasFactory;

    // Specify the table if it doesn't follow Laravel's naming conventions
    protected $table = 'fyp_coordinators';  // Optional if table is named 'students'

    // Specify the primary key column if it's not 'id'
    protected $primaryKey = 'CoordinatorID';  // Optional if primary key is 'student_id'

    // If the table does not have 'created_at' and 'updated_at' columns
    public $timestamps = true;  // Set to false if the table doesn't use timestamps

    // Define the columns that are mass assignable (Optional)
    protected $fillable = [
        'CoordinatorID',
        'Name',
        'Email',
        'user_Id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(UserShs::class, 'user_Id'); // Adjust the foreign key if necessary
    }
}
