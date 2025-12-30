<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'duration',
        'icon',
        'image',
        'is_active',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from name if not provided
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('name') && empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    /**
     * Get appointments for this service
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Scope a query to only include active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order services by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
