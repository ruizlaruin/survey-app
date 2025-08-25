<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'question_text', 'question_type'];

    protected $casts = [
        'question_type' => 'string',
    ];

    public function surveys(): BelongsToMany
    {
        return $this->belongsToMany(Survey::class, 'survey_question')
                    ->withTimestamps();
    }
}
