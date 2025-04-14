<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'attempt_id',
        'marks_obtained',
        'total_marks',
    ];

    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }

    public function getPercentageAttribute()
    {
        return ($this->marks_obtained / $this->total_marks) * 100;
    }
}
