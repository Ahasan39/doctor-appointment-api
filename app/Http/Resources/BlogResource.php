<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featured_image,
            'category' => $this->category,
            'tags' => $this->tags ?? [],
            'status' => $this->status,
            'views' => $this->views,
            'author' => $this->when(
                $this->relationLoaded('author'),
                [
                    'id' => $this->author?->id,
                    'name' => $this->author?->name,
                    'email' => $this->author?->email,
                ]
            ),
            'published_at' => $this->published_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'reading_time' => $this->estimateReadingTime(),
        ];
    }

    /**
     * Estimate reading time based on content length.
     *
     * @return string
     */
    private function estimateReadingTime(): string
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words per minute

        if ($minutes < 1) {
            return 'Less than 1 min';
        }

        return $minutes . ' min' . ($minutes !== 1 ? 's' : '') . ' read';
    }
}
