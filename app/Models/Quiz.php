<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number_of_questions',
        'duration',
        'passing_score',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function isAvailable()
    {
        // A quiz is available if:
        // 1. It is published
        // 2. Has at least one question
        return $this->is_published && $this->questions()->count() > 0;
    }
}
