<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FypTitle extends Model
{
    use HasFactory;

    // Table name (if not following Laravel's plural naming convention)
    protected $table = 'fyp_title';
    protected $primaryKey = 'TitleID';
    // Fillable fields to allow mass assignment
    protected $fillable = [
        'TitleID',
        'PostID',            // Foreign key referencing the post
        'TitleName',         // FYP title name
        'TitleDescription',  // Description of the FYP title
        'Quota',              // Quota for students
        'current_quota',
        'TitleStatus',
        'created_at',
        'updated_at',
    ];

    // Define relationship with the Post model
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
