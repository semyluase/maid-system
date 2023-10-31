<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailWorkExperience extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['question'];

    function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
