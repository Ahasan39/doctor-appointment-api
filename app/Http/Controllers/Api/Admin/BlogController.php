<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends ApiController
{
    /**
     * Display a listing of blogs with pagination and filtering.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $perPage = min($perPage, 100); // Max 100 items per page

            $query = Blog::with('author:id,name,email');

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
            }

            // Filter by category
            if ($request->filled('category')) {
                $query->where('category', $request->input('category'));
            }

            // Filter by author
            if ($request->filled('author_id')) {
                $query->where('author_id', $request->input('author_id'));
            }

            // Search by title or content
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            }

            // Filter by tags
            if ($request->filled('tag')) {
                $tag = $request->input('tag');
                $query->whereJsonContains('tags', $tag);
            }

            // Filter by date range
            if ($request->filled('date_from')) {
                $query->whereDate('published_at', '>=', $request->input('date_from'));
            }
            if ($request->filled('date_to')) {
                $query->whereDate('published_at', '<=', $request->input('date_to'));
            }

            // Sorting
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            
            if (in_array($sortBy, ['title', 'status', 'views', 'published_at', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $blogs = $query->paginate($perPage);

            return $this->successResponse(
                BlogResource::collection($blogs)->response()->getData(true),
                'Blogs retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve blogs: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created blog.
     *
     * @param StoreBlogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBlogRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['author_id'] = auth()->id();

            $blog = Blog::create($data);

            DB::commit();

            return $this->successResponse(
                new BlogResource($blog->load('author:id,name,email')),
                'Blog created successfully',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create blog: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified blog.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $blog = Blog::with('author:id,name,email')->findOrFail($id);

            return $this->successResponse(
                new BlogResource($blog),
                'Blog retrieved successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Blog not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve blog: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified blog.
     *
     * @param UpdateBlogRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBlogRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $blog = Blog::findOrFail($id);
            $blog->update($request->validated());

            DB::commit();

            return $this->successResponse(
                new BlogResource($blog->fresh()->load('author:id,name,email')),
                'Blog updated successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Blog not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update blog: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified blog.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $blog = Blog::findOrFail($id);
            $blog->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Blog deleted successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Blog not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to delete blog: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Publish a blog.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish($id)
    {
        try {
            DB::beginTransaction();

            $blog = Blog::findOrFail($id);

            if ($blog->status === 'published') {
                return $this->errorResponse('Blog is already published', 400);
            }

            $blog->update([
                'status' => 'published',
                'published_at' => now(),
            ]);

            DB::commit();

            return $this->successResponse(
                new BlogResource($blog->fresh()->load('author:id,name,email')),
                'Blog published successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Blog not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to publish blog: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Unpublish a blog (set to draft).
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unpublish($id)
    {
        try {
            DB::beginTransaction();

            $blog = Blog::findOrFail($id);

            if ($blog->status === 'draft') {
                return $this->errorResponse('Blog is already a draft', 400);
            }

            $blog->update([
                'status' => 'draft',
                'published_at' => null,
            ]);

            DB::commit();

            return $this->successResponse(
                new BlogResource($blog->fresh()->load('author:id,name,email')),
                'Blog unpublished successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Blog not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to unpublish blog: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Archive a blog.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive($id)
    {
        try {
            DB::beginTransaction();

            $blog = Blog::findOrFail($id);

            if ($blog->status === 'archived') {
                return $this->errorResponse('Blog is already archived', 400);
            }

            $blog->update(['status' => 'archived']);

            DB::commit();

            return $this->successResponse(
                new BlogResource($blog->fresh()->load('author:id,name,email')),
                'Blog archived successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Blog not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to archive blog: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get blog statistics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        try {
            $stats = [
                'total' => Blog::count(),
                'published' => Blog::where('status', 'published')->count(),
                'draft' => Blog::where('status', 'draft')->count(),
                'archived' => Blog::where('status', 'archived')->count(),
                'total_views' => Blog::sum('views'),
                'average_views' => round(Blog::avg('views'), 0),
                'most_viewed' => Blog::with('author:id,name')
                    ->orderBy('views', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($blog) {
                        return [
                            'id' => $blog->id,
                            'title' => $blog->title,
                            'slug' => $blog->slug,
                            'views' => $blog->views,
                            'author' => $blog->author->name ?? 'Unknown',
                        ];
                    }),
                'recent_published' => Blog::with('author:id,name')
                    ->where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($blog) {
                        return [
                            'id' => $blog->id,
                            'title' => $blog->title,
                            'slug' => $blog->slug,
                            'published_at' => $blog->published_at?->format('Y-m-d H:i:s'),
                            'author' => $blog->author->name ?? 'Unknown',
                        ];
                    }),
                'categories' => Blog::select('category', DB::raw('count(*) as count'))
                    ->whereNotNull('category')
                    ->groupBy('category')
                    ->orderBy('count', 'desc')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'category' => $item->category,
                            'count' => $item->count,
                        ];
                    }),
            ];

            return $this->successResponse($stats, 'Statistics retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve statistics: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get all unique categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        try {
            $categories = Blog::select('category')
                ->whereNotNull('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category');

            return $this->successResponse(
                ['categories' => $categories],
                'Categories retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve categories: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get all unique tags.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tags()
    {
        try {
            $blogs = Blog::whereNotNull('tags')->get();
            $allTags = [];

            foreach ($blogs as $blog) {
                if (is_array($blog->tags)) {
                    $allTags = array_merge($allTags, $blog->tags);
                }
            }

            $uniqueTags = array_unique($allTags);
            sort($uniqueTags);

            return $this->successResponse(
                ['tags' => array_values($uniqueTags)],
                'Tags retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve tags: ' . $e->getMessage(), 500);
        }
    }
}
