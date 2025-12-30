<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'doctor' => [
                'id' => $this->doctor?->id,
                'name' => $this->doctor?->name,
                'specialization' => $this->doctor?->specialization,
                'email' => $this->doctor?->email,
                'phone' => $this->doctor?->phone,
            ],
            'service' => [
                'id' => $this->service?->id,
                'name' => $this->service?->name,
                'price' => $this->service?->price,
                'duration' => $this->service?->duration,
            ],
            'patient_name' => $this->name,
            'patient_phone' => $this->phone,
            'message' => $this->message,
            'preferred_date' => $this->preferred_date?->format('Y-m-d'),
            'preferred_time' => $this->preferred_time?->format('H:i:s'),
            'status' => $this->status,
            'admin_notes' => $this->admin_notes,
            'confirmed_at' => $this->confirmed_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
