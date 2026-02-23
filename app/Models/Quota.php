<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    protected $table = 'quota';
    protected $primaryKey = 'QuotaID';
    protected $fillable = [
        'Lecturer_id',
        'Assigned_quota'
    ];
    public $timestamps = false;

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'Lecturer_id', 'lecturerID');
    }
}
