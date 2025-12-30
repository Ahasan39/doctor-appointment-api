<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'specialization',
        'bio',
        'license_number',
        'years_of_experience',
        'consultation_fee',
        'profile_image',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'consultation_fee' => 'decimal:2',
        ];
    }

    /**
     * Check if user is a doctor
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a patient
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    /**
     * Get appointments for this user (as doctor)
     */
    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Get blogs authored by this user
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
