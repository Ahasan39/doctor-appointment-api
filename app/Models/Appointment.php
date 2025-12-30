<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'doctor_id',
        'service_id',
        'name',
        'phone',
        'message',
        'preferred_date',
        'preferred_time',
        'status',
        'admin_notes',
        'confirmed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    /**
     * Get the doctor associated with the appointment
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the service associated with the appointment
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Scope a query to only include pending appointments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed appointments
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include completed appointments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled appointments
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Check if appointment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if appointment is confirmed
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if appointment is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if appointment is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
