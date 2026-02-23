<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedules';
    protected $primaryKey = 'schedule_id';
    public $timestamps = true;
    protected $fillable = ['lecturer_id', 'subject', 'day', 'start_time', 'end_time', 'location', 'created_at', 'updated_at'];
}
