<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionnaireScaleOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'questionnaire_id',
        'value',
        'label'
    ];

    protected $casts = [
        'value' => 'integer'
    ];

    // Relationships
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('value');
    }
}
