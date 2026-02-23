<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Specify the table if it doesn't follow Laravel's naming conventions
    protected $table = 'posts';  // Optional if table is named 'students'

    // Specify the primary key column if it's not 'id'
    protected $primaryKey = 'PostID';  // Optional if primary key is 'student_id'

    // If the table does not have 'created_at' and 'updated_at' columns
    public $timestamps = true;  // Set to false if the table doesn't use timestamps

    // Define the columns that are mass assignable (Optional)
    protected $fillable = [
        'PostID',
        'LecturerID',
        'PostTitle',
        'PostDescription',
        'PostCategory',
        'PostDate',
        'created_at',
        'updated_at',
    ];
      // Define the relationship to the Title model

        public function titles()
    {
        return $this->hasMany(Title::class, 'PostID');
    }

    // In Post.php (Post model)
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'LecturerID');
    }

}
