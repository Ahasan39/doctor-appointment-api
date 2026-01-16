<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class PublicBlogController extends ApiController
{
    /**
     * Display a listing of published blogs.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Blog::query()
            ->where('status', 'published')
            ->with('author');

        // Search by title or content
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by tag
        if ($request->has('tag')) {
            $tag = $request->tag;
            $query->whereJsonContains('tags', $tag);
        }

        // Filter by author
        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        // Filter by date range
        if ($request->has('from_date')) {
            $query->whereDate('published_at', '>=', $request->from_date);
        }
        if ($request->has('to_date')) {
            $query->whereDate('published_at', '<=', $request->to_date);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'published_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['title', 'published_at', 'views_count', 'reading_time'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $blogs = $query->paginate($perPage);

        return $this->successResponse(
            BlogResource::collection($blogs)->response()->getData(true),
            'Blogs retrieved successfully'
        );
    }

    /**
     * Display the specified blog.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->with('author')
            ->first();

        if (!$blog) {
            return $this->errorResponse('Blog not found', 404);
        }

        // Increment view count
        $blog->increment('views_count');

        return $this->successResponse(
            new BlogResource($blog),
            'Blog retrieved successfully'
        );
    }

    /**
     * Get all unique categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        $categories = Blog::where('status', 'published')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return $this->successResponse(
            $categories,
            'Categories retrieved successfully'
        );
    }

    /**
     * Get all unique tags.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tags()
    {
        $blogs = Blog::where('status', 'published')
            ->whereNotNull('tags')
            ->get();

        $tags = collect();
        foreach ($blogs as $blog) {
            if (is_array($blog->tags)) {
                $tags = $tags->merge($blog->tags);
            }
        }

        $uniqueTags = $tags->unique()->sort()->values();

        return $this->successResponse(
            $uniqueTags,
            'Tags retrieved successfully'
        );
    }

    /**
     * Get featured/latest blogs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function featured()
    {
        $blogs = Blog::where('status', 'published')
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        return $this->successResponse(
            BlogResource::collection($blogs),
            'Featured blogs retrieved successfully'
        );
    }

    /**
     * Get related blogs based on category and tags.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function related($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$blog) {
            return $this->errorResponse('Blog not found', 404);
        }

        $relatedBlogs = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->where(function ($query) use ($blog) {
                $query->where('category', $blog->category);
                
                if (is_array($blog->tags) && count($blog->tags) > 0) {
                    foreach ($blog->tags as $tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    }
                }
            })
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return $this->successResponse(
            BlogResource::collection($relatedBlogs),
            'Related blogs retrieved successfully'
        );
    }
}
