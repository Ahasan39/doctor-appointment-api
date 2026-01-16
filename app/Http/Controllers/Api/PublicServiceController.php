<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class PublicServiceController extends ApiController
{
    /**
     * Display a listing of active services.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Service::query()->where('is_active', true);

        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by duration range
        if ($request->has('min_duration')) {
            $query->where('duration', '>=', $request->min_duration);
        }
        if ($request->has('max_duration')) {
            $query->where('duration', '<=', $request->max_duration);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['name', 'price', 'duration', 'order'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $services = $query->paginate($perPage);

        return $this->successResponse(
            ServiceResource::collection($services)->response()->getData(true),
            'Services retrieved successfully'
        );
    }

    /**
     * Display the specified service.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$service) {
            return $this->errorResponse('Service not found', 404);
        }

        return $this->successResponse(
            new ServiceResource($service),
            'Service retrieved successfully'
        );
    }

    /**
     * Get featured services.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function featured()
    {
        $services = Service::where('is_active', true)
            ->orderBy('order', 'asc')
            ->limit(6)
            ->get();

        return $this->successResponse(
            ServiceResource::collection($services),
            'Featured services retrieved successfully'
        );
    }
}
