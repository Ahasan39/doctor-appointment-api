<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\DoctorResource;
use App\Models\User;
use Illuminate\Http\Request;

class PublicDoctorController extends ApiController
{
    /**
     * Display a listing of active doctors.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->where('role', 'doctor')
            ->where('is_active', true);

        // Search by name or bio
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        // Filter by specialization
        if ($request->has('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        // Filter by consultation fee range
        if ($request->has('min_fee')) {
            $query->where('consultation_fee', '>=', $request->min_fee);
        }
        if ($request->has('max_fee')) {
            $query->where('consultation_fee', '<=', $request->max_fee);
        }

        // Filter by experience
        if ($request->has('min_experience')) {
            $minYears = (int) $request->min_experience;
            $query->whereRaw('TIMESTAMPDIFF(YEAR, experience_years, NOW()) >= ?', [$minYears]);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['name', 'specialization', 'consultation_fee', 'experience_years'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $doctors = $query->paginate($perPage);

        return $this->successResponse(
            DoctorResource::collection($doctors)->response()->getData(true),
            'Doctors retrieved successfully'
        );
    }

    /**
     * Display the specified doctor.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $doctor = User::where('id', $id)
            ->where('role', 'doctor')
            ->where('is_active', true)
            ->first();

        if (!$doctor) {
            return $this->errorResponse('Doctor not found', 404);
        }

        return $this->successResponse(
            new DoctorResource($doctor),
            'Doctor retrieved successfully'
        );
    }

    /**
     * Get all unique specializations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function specializations()
    {
        $specializations = User::where('role', 'doctor')
            ->where('is_active', true)
            ->whereNotNull('specialization')
            ->distinct()
            ->pluck('specialization')
            ->sort()
            ->values();

        return $this->successResponse(
            $specializations,
            'Specializations retrieved successfully'
        );
    }

    /**
     * Get featured doctors.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function featured()
    {
        $doctors = User::where('role', 'doctor')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return $this->successResponse(
            DoctorResource::collection($doctors),
            'Featured doctors retrieved successfully'
        );
    }
}
