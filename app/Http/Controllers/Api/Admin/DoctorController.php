<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends ApiController
{
    /**
     * Display a listing of doctors with pagination and filtering.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $perPage = min($perPage, 100); // Max 100 items per page

            $query = User::where('role', 'doctor');

            // Filter by active status
            if ($request->has('is_active')) {
                $query->where('is_active', $request->boolean('is_active'));
            }

            // Filter by specialization
            if ($request->filled('specialization')) {
                $query->where('specialization', $request->input('specialization'));
            }

            // Search by name, email, or phone
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('specialization', 'like', "%{$search}%");
                });
            }

            // Filter by experience range
            if ($request->filled('min_experience')) {
                $query->where('years_of_experience', '>=', $request->input('min_experience'));
            }
            if ($request->filled('max_experience')) {
                $query->where('years_of_experience', '<=', $request->input('max_experience'));
            }

            // Filter by consultation fee range
            if ($request->filled('min_fee')) {
                $query->where('consultation_fee', '>=', $request->input('min_fee'));
            }
            if ($request->filled('max_fee')) {
                $query->where('consultation_fee', '<=', $request->input('max_fee'));
            }

            // Sorting
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            
            if (in_array($sortBy, ['name', 'specialization', 'years_of_experience', 'consultation_fee', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('created_at', 'desc');
            }

            // Load appointments count
            $query->withCount('doctorAppointments');

            $doctors = $query->paginate($perPage);

            return $this->successResponse(
                DoctorResource::collection($doctors)->response()->getData(true),
                'Doctors retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve doctors: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created doctor.
     *
     * @param StoreDoctorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDoctorRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['role'] = 'doctor';
            $data['password'] = Hash::make($data['password']);

            $doctor = User::create($data);

            DB::commit();

            return $this->successResponse(
                new DoctorResource($doctor),
                'Doctor created successfully',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create doctor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified doctor.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $doctor = User::where('role', 'doctor')
                ->withCount('doctorAppointments')
                ->findOrFail($id);

            return $this->successResponse(
                new DoctorResource($doctor),
                'Doctor retrieved successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Doctor not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve doctor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified doctor.
     *
     * @param UpdateDoctorRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDoctorRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $doctor = User::where('role', 'doctor')->findOrFail($id);
            
            $data = $request->validated();
            
            // Hash password if provided
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $doctor->update($data);

            DB::commit();

            return $this->successResponse(
                new DoctorResource($doctor->fresh()),
                'Doctor updated successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Doctor not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update doctor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified doctor.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $doctor = User::where('role', 'doctor')->findOrFail($id);

            // Check if doctor has appointments
            $appointmentsCount = $doctor->doctorAppointments()->count();
            if ($appointmentsCount > 0) {
                return $this->errorResponse(
                    "Cannot delete doctor. They have {$appointmentsCount} associated appointment(s). Please deactivate instead.",
                    400
                );
            }

            $doctor->delete();

            DB::commit();

            return $this->successResponse(
                null,
                'Doctor deleted successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Doctor not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to delete doctor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Activate a doctor.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate($id)
    {
        try {
            DB::beginTransaction();

            $doctor = User::where('role', 'doctor')->findOrFail($id);

            if ($doctor->is_active) {
                return $this->errorResponse('Doctor is already active', 400);
            }

            $doctor->update(['is_active' => true]);

            DB::commit();

            return $this->successResponse(
                new DoctorResource($doctor->fresh()),
                'Doctor activated successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Doctor not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to activate doctor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Deactivate a doctor.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate($id)
    {
        try {
            DB::beginTransaction();

            $doctor = User::where('role', 'doctor')->findOrFail($id);

            if (!$doctor->is_active) {
                return $this->errorResponse('Doctor is already inactive', 400);
            }

            $doctor->update(['is_active' => false]);

            DB::commit();

            return $this->successResponse(
                new DoctorResource($doctor->fresh()),
                'Doctor deactivated successfully'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return $this->errorResponse('Doctor not found', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to deactivate doctor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get doctor statistics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        try {
            $stats = [
                'total' => User::where('role', 'doctor')->count(),
                'active' => User::where('role', 'doctor')->where('is_active', true)->count(),
                'inactive' => User::where('role', 'doctor')->where('is_active', false)->count(),
                'total_appointments' => User::where('role', 'doctor')
                    ->withCount('doctorAppointments')
                    ->get()
                    ->sum('doctor_appointments_count'),
                'average_experience' => round(User::where('role', 'doctor')->avg('years_of_experience'), 1),
                'average_fee' => round(User::where('role', 'doctor')->avg('consultation_fee'), 2),
                'specializations' => User::where('role', 'doctor')
                    ->select('specialization', DB::raw('count(*) as count'))
                    ->whereNotNull('specialization')
                    ->groupBy('specialization')
                    ->orderBy('count', 'desc')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'specialization' => $item->specialization,
                            'count' => $item->count,
                        ];
                    }),
                'most_booked' => User::where('role', 'doctor')
                    ->withCount('doctorAppointments')
                    ->orderBy('doctor_appointments_count', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($doctor) {
                        return [
                            'id' => $doctor->id,
                            'name' => $doctor->name,
                            'specialization' => $doctor->specialization,
                            'appointments_count' => $doctor->doctor_appointments_count,
                        ];
                    }),
            ];

            return $this->successResponse($stats, 'Statistics retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve statistics: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get all unique specializations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function specializations()
    {
        try {
            $specializations = User::where('role', 'doctor')
                ->select('specialization')
                ->whereNotNull('specialization')
                ->distinct()
                ->orderBy('specialization')
                ->pluck('specialization');

            return $this->successResponse(
                ['specializations' => $specializations],
                'Specializations retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve specializations: ' . $e->getMessage(), 500);
        }
    }
}
