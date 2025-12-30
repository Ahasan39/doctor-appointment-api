<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'status',
        'views',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title if not provided
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    /**
     * Get the author of the blog
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope a query to only include published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include draft blogs
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to order by most viewed
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    /**
     * Scope a query to order by latest
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Increment the views count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Check if blog is published
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' 
               && $this->published_at !== null 
               && $this->published_at->isPast();
    }

    /**
     * Check if blog is draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }
}
