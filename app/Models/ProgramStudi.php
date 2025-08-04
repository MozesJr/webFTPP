<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'degree_level',
        'description',
        'overview',
        'image_url',
        'accreditation',
        'accreditation_date',
        'accreditation_expire',
        'head_of_program',
        'established_year',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'accreditation_date' => 'date',
        'accreditation_expire' => 'date',
        'established_year' => 'integer'
    ];

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    // Relationships
    public function kurikulums(): HasMany
    {
        return $this->hasMany(Kurikulum::class, 'prodi_id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class, 'prodi_id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class, 'prodi_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'prodi_id');
    }

    public function penjaminanMutus(): HasMany
    {
        return $this->hasMany(PenjaminanMutu::class, 'prodi_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'prodi_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'prodi_id');
    }

    // Scopes
    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    // Update app/Models/Testimonial.php - pastikan ada scope featured()
    // Tambahkan ini ke model Testimonial jika belum ada:

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Update app/Models/News.php - pastikan ada scope recent()
    // Tambahkan ini ke model News jika belum ada:


    // Update app/Models/Event.php - pastikan ada scope upcoming()
    // Tambahkan ini ke model Event jika belum ada:

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
            ->where('event_date', '>=', now());
    }

    // Update app/Models/Gallery.php - pastikan ada scope recent()
    // Tambahkan ini ke model Gallery jika belum ada:

    public function scopeRecent($query, $limit = 12)
    {
        return $query->orderBy('event_date', 'desc')->limit($limit);
    }

    // Update app/Models/Stats.php - pastikan ada scope current()
    // Tambahkan ini ke model Stats jika belum ada:

    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    // Atau, untuk sementara, kita bisa comment bagian yang error di HomeController
    // dan test step by step
}
