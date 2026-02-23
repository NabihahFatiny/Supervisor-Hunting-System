<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    // Specify the table if it's not named "titles"
    protected $table = 'fyp_title';

    // Define the primary key if it's not "id"
    protected $primaryKey = 'TitleID';

    // Set timestamps to false if the table doesn't use `created_at` and `updated_at`
    public $timestamps = true;

    // Define the mass assignable attributes
    protected $fillable = [
        'TitleID',
        'PostID',
        'TitleName',
        'TitleDescription',
        'Quota',
        'current_quota',
        'TitleStatus',
    ];

    // Define the relationship to the Post model
    public function post()
    {
        return $this->belongsTo(Post::class, 'PostID');
    }


}
