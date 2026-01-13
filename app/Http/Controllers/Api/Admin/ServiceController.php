<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends ApiController
{
    /**
     * Display a listing of services with pagination and filtering.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $perPage = min($perPage, 100); // Max 100 items per page

            $query = Service::query();

            // Filter by active status
            if ($request->has('is_active')) {
                $query->where('is_active', $request->boolean('is_active'));
            }

            // Search by name or description
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('short_description', 'like', "%{$search}%");
                });
            }

            // Filter by price range
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->input('min_price'));
            }
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->input('max_price'));
            }

            // Filter by duration range
            if ($request->filled('min_duration')) {
                $query->where('duration', '>=', $request->input('min_duration'));
            }
            if ($request->filled('max_duration')) {
                $query->where('duration', '<=', $request->input('max_duration'));
            }

            // Sorting
            $sortBy = $request->input('sort_by', 'order');
            $sortOrder = $request->input('sort_order', 'asc');
            
            if (in_array($sortBy, ['name', 'price', 'duration', 'order', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('order', 'asc');
            }

            // Load appointments count
            $query->withCount('appointments');

            $services = $query->paginate($perPage);

            return $this->successResponse(
                ServiceResource::collection($services)->response()->getData(true),
                'Services retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve services: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created service.
     *
     * @param StoreServiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreServiceRequest $request)
    {
        try {
            DB::beginTransaction();

            $service = Service::create($request->validated());

            DB::commit();

            return $this->successResponse(
                new ServiceResource($service),
                'Service created successfully',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create service: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified service.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $service = Service::withCount('appointments')->findOrFail($id);

            return $this->successResponse(
                new ServiceResource($service),
                'Service retrieved successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Service not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve service: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified service.
     *
     * @param UpdateServiceRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $service = Service::findOrFail($id);
            $service->update($request->validated());

            DB::commit();

            return $this->successResponse(
                new ServiceResource($service->fresh()),
                'Service updated successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Service not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update service: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified service.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $service = Service::findOrFail($id);

            // Check if service has appointments
            $appointmentsCount = $service->appointments()->count();
            if ($appointmentsCount > 0) {
                return $this->errorResponse(
                    "Cannot delete service. It has {$appointmentsCount} associated appointment(s). Please deactivate instead.",
                    400
                );
            }

            $service->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Service deleted successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Service not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to delete service: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Activate a service.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate($id)
    {
        try {
            DB::beginTransaction();

            $service = Service::findOrFail($id);

            if ($service->is_active) {
                return $this->errorResponse('Service is already active', 400);
            }

            $service->update(['is_active' => true]);

            DB::commit();

            return $this->successResponse(
                new ServiceResource($service->fresh()),
                'Service activated successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Service not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to activate service: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Deactivate a service.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate($id)
    {
        try {
            DB::beginTransaction();

            $service = Service::findOrFail($id);

            if (!$service->is_active) {
                return $this->errorResponse('Service is already inactive', 400);
            }

            $service->update(['is_active' => false]);

            DB::commit();

            return $this->successResponse(
                new ServiceResource($service->fresh()),
                'Service deactivated successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Service not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to deactivate service: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Reorder services.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.order' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->input('services') as $serviceData) {
                Service::where('id', $serviceData['id'])
                    ->update(['order' => $serviceData['order']]);
            }

            DB::commit();

            return $this->successResponse(
                null,
                'Services reordered successfully'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to reorder services: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get service statistics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        try {
            $stats = [
                'total' => Service::count(),
                'active' => Service::where('is_active', true)->count(),
                'inactive' => Service::where('is_active', false)->count(),
                'total_appointments' => Service::withCount('appointments')->get()->sum('appointments_count'),
                'average_price' => round(Service::avg('price'), 2),
                'average_duration' => round(Service::avg('duration'), 0),
                'most_popular' => Service::withCount('appointments')
                    ->orderBy('appointments_count', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($service) {
                        return [
                            'id' => $service->id,
                            'name' => $service->name,
                            'appointments_count' => $service->appointments_count,
                        ];
                    }),
            ];

            return $this->successResponse($stats, 'Statistics retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve statistics: ' . $e->getMessage(), 500);
        }
    }
}
