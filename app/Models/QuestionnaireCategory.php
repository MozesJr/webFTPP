<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionnaireCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'questionnaire_id',
        'name',
        'description',
        'order_index'
    ];

    protected $casts = [
        'order_index' => 'integer'
    ];

    // Relationships
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionnaireQuestion::class, 'category_id')->orderBy('order_index');
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }
}
