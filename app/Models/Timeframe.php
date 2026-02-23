<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timeframe extends Model
{
    protected $table = 'timeframe';
    protected $primaryKey = 'TimeframeID';

    protected $fillable = [
        'Start_date',
        'End_date'
    ];

    protected $casts = [
        'Start_date' => 'date',
        'End_date' => 'date'
    ];
    public function getStartDateAttribute()
{
    return $this->attributes['Start_date'];
}

public function getEndDateAttribute()
{
    return $this->attributes['End_date'];
}
}
