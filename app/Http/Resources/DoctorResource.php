<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'specialization' => $this->specialization,
            'bio' => $this->bio,
            'license_number' => $this->license_number,
            'years_of_experience' => $this->years_of_experience,
            'experience_level' => $this->getExperienceLevel(),
            'consultation_fee' => $this->consultation_fee ? number_format($this->consultation_fee, 2) : null,
            'consultation_fee_raw' => $this->consultation_fee ? (float) $this->consultation_fee : null,
            'profile_image' => $this->profile_image,
            'is_active' => (bool) $this->is_active,
            'appointments_count' => $this->when(
                $this->relationLoaded('doctorAppointments') || isset($this->doctor_appointments_count),
                $this->doctor_appointments_count ?? 0
            ),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get experience level based on years of experience.
     *
     * @return string
     */
    private function getExperienceLevel(): string
    {
        if (!$this->years_of_experience) {
            return 'Not specified';
        }

        $years = $this->years_of_experience;

        if ($years < 2) {
            return 'Junior';
        } elseif ($years < 5) {
            return 'Mid-level';
        } elseif ($years < 10) {
            return 'Senior';
        } elseif ($years < 20) {
            return 'Expert';
        } else {
            return 'Master';
        }
    }
}
