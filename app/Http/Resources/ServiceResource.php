<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => number_format($this->price, 2),
            'price_raw' => (float) $this->price,
            'duration' => $this->duration,
            'duration_formatted' => $this->formatDuration($this->duration),
            'icon' => $this->icon,
            'image' => $this->image,
            'is_active' => (bool) $this->is_active,
            'order' => $this->order,
            'appointments_count' => $this->when(
                $this->relationLoaded('appointments') || isset($this->appointments_count),
                $this->appointments_count ?? 0
            ),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Format duration in minutes to human-readable format.
     *
     * @param int $minutes
     * @return string
     */
    private function formatDuration(int $minutes): string
    {
        if ($minutes < 60) {
            return $minutes . ' min' . ($minutes !== 1 ? 's' : '');
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        $formatted = $hours . ' hour' . ($hours !== 1 ? 's' : '');

        if ($remainingMinutes > 0) {
            $formatted .= ' ' . $remainingMinutes . ' min' . ($remainingMinutes !== 1 ? 's' : '');
        }

        return $formatted;
    }
}
