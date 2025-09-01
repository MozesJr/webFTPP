<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Schema;

class Team extends Model
{
    use HasFactory;

    /**
     * UNION dari dua versi model:
     * - Mempertahankan field & relasi lama (position_id, is_active, order_index, photo_url, dsb)
     * - Menambahkan field & method baru (status, hire_date, description, getAverageEvaluationScore, dst.)
     */

    protected $fillable = [
        // Versi lama
        'name',
        'position_id',
        'prodi_id',
        'email',
        'phone',
        'bio',
        'photo_url',
        'education',
        'expertise',
        'is_active',
        'order_index',

        // Tambahan versi baru
        'position',      // ⚠️ kolom string "position" bisa bentrok dengan relasi "position()"
        'status',
        'hire_date',
        'description',
    ];

    protected $casts = [
        // Lama
        'is_active'   => 'boolean',
        'order_index' => 'integer',
        // Baru
        'hire_date'   => 'date',
    ];

    /* =========================
     * Relationships
     * ========================= */

    // Relasi lama: ke tabel posisi (TeamPosition) via position_id
    public function position(): BelongsTo
    {
        return $this->belongsTo(TeamPosition::class, 'position_id');
    }

    /**
     * Alias relasi untuk menghindari bentrok dengan kolom 'position' (string).
     * Gunakan $team->positionRelation jika kamu juga menyimpan kolom 'position'.
     */
    public function positionRelation(): BelongsTo
    {
        return $this->belongsTo(TeamPosition::class, 'position_id');
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    // Tetap pertahankan relasi-relasi lamamu
    public function jadwalKuliahs(): HasMany
    {
        return $this->hasMany(JadwalKuliah::class, 'dosen_id');
    }

    public function rps(): HasMany
    {
        return $this->hasMany(Rps::class, 'dosen_id');
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'author_id');
    }

    public function mataKuliahs(): BelongsToMany
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_mata_kuliahs', 'dosen_id', 'mata_kuliah_id')
            ->withPivot('role', 'academic_year', 'is_active')
            ->withTimestamps();
    }

    // Evaluations (dua peran dosen)
    public function evaluations1(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'lecturer_1_id');
    }

    public function evaluations2(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'lecturer_2_id');
    }

    // Nama yang lebih eksplisit (dari versi baru)
    public function evaluationsAsLecturer1(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'lecturer_1_id');
    }

    public function evaluationsAsLecturer2(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'lecturer_2_id');
    }

    /**
     * Semua evaluation untuk dosen ini (sebagai lecturer_1 atau lecturer_2)
     */
    public function allEvaluations()
    {
        return Evaluation::where(function ($query) {
            $query->where('lecturer_1_id', $this->id)
                ->orWhere('lecturer_2_id', $this->id);
        });
    }

    /* =========================
     * Scopes
     * ========================= */

    /**
     * Scope active yang mendukung dua skema:
     * - is_active = true (boolean)
     * - status = 'active' (string)
     */
    public function scopeActive($query)
    {
        $table = $query->getModel()->getTable();

        return $query->where(function ($q) use ($table) {
            $q->where('is_active', true);

            if (Schema::hasColumn($table, 'status')) {
                $q->orWhere('status', 'active');
            }
        });
    }


    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    public function scopeByPosition($query, $positionId)
    {
        return $query->where('position_id', $positionId);
    }

    public function scopeByProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }

    /* =========================
     * Accessors / Mutators
     * ========================= */

    /**
     * Photo URL accessor.
     * Jika di DB menyimpan path relatif (mis. 'teams/abc.jpg'), akan diprefix 'storage/'.
     * Jika null → gunakan default avatar.
     */
    public function getPhotoUrlAttribute($value)
    {
        return $value
            ? asset(str_starts_with($value, 'http') ? $value : 'storage/' . ltrim($value, '/'))
            : asset('images/default-avatar.png');
    }

    /* =========================
     * Methods / Helpers
     * ========================= */

    /**
     * Rata-rata nilai berdasarkan EvaluationAnswer (versi lamamu).
     * Mengambil hanya jawaban bertipe 'radio'.
     */
    public function getAverageRating(): float
    {
        $answers = EvaluationAnswer::where('lecturer_id', $this->id)
            ->whereHas('question', function ($q) {
                $q->where('input_type', 'radio');
            })
            ->get();

        if ($answers->isEmpty()) return 0.0;

        return round($answers->avg('answer_value'), 2);
    }

    /**
     * Rata-rata skor evaluasi (versi yang diminta integrasi).
     * Bergantung pada method Evaluation::getAverageScoreForLecturer($lecturerId).
     */
    public function getAverageEvaluationScore(): float
    {
        $evaluations = $this->allEvaluations()->get();
        if ($evaluations->isEmpty()) return 0.0;

        $totalScore = 0.0;
        $totalEvaluations = 0;

        foreach ($evaluations as $evaluation) {
            $score = (float) $evaluation->getAverageScoreForLecturer($this->id);
            if ($score > 0) {
                $totalScore += $score;
                $totalEvaluations++;
            }
        }

        return $totalEvaluations > 0 ? round($totalScore / $totalEvaluations, 2) : 0.0;
    }

    public function getTotalEvaluationsCount(): int
    {
        return (int) $this->allEvaluations()->count();
    }

    public function getLatestEvaluationDate()
    {
        // asumsikan kolom 'submitted_at' ada pada tabel evaluations
        return $this->allEvaluations()->latest('submitted_at')->first()?->submitted_at;
    }
}
