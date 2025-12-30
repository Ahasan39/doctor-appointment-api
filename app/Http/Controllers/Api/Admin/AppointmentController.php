<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends ApiController
{
    /**
     * Display a listing of appointments with pagination and filtering.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 15);
            $perPage = min($perPage, 100); // Max 100 items per page

            $query = Appointment::with(['doctor', 'service']);

            // Filter by status
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            // Filter by doctor
            if ($request->has('doctor_id') && $request->doctor_id !== '') {
                $query->where('doctor_id', $request->doctor_id);
            }

            // Filter by service
            if ($request->has('service_id') && $request->service_id !== '') {
                $query->where('service_id', $request->service_id);
            }

            // Filter by date range
            if ($request->has('date_from')) {
                $query->whereDate('preferred_date', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('preferred_date', '<=', $request->date_to);
            }

            // Search by patient name or phone
            if ($request->has('search') && $request->search !== '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            // Sort
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            $appointments = $query->paginate($perPage);

            return $this->successResponse([
                'appointments' => AppointmentResource::collection($appointments),
                'pagination' => [
                    'total' => $appointments->total(),
                    'per_page' => $appointments->perPage(),
                    'current_page' => $appointments->currentPage(),
                    'last_page' => $appointments->lastPage(),
                    'from' => $appointments->firstItem(),
                    'to' => $appointments->lastItem(),
                ],
            ], 'Appointments retrieved successfully');

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve appointments: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created appointment.
     *
     * @param StoreAppointmentRequest $request
     * @return JsonResponse
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $appointment = Appointment::create($request->validated());

            DB::commit();

            return $this->successResponse(
                new AppointmentResource($appointment->load(['doctor', 'service'])),
                'Appointment created successfully',
                201
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create appointment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified appointment.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $appointment = Appointment::with(['doctor', 'service'])->find($id);

            if (!$appointment) {
                return $this->notFoundResponse('Appointment not found');
            }

            return $this->successResponse(
                new AppointmentResource($appointment),
                'Appointment retrieved successfully'
            );

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve appointment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified appointment.
     *
     * @param UpdateAppointmentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateAppointmentRequest $request, int $id): JsonResponse
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                return $this->notFoundResponse('Appointment not found');
            }

            DB::beginTransaction();

            $appointment->update($request->validated());

            // If status is being changed to confirmed, set confirmed_at
            if ($request->has('status') && $request->status === 'confirmed' && !$appointment->confirmed_at) {
                $appointment->confirmed_at = now();
                $appointment->save();
            }

            DB::commit();

            return $this->successResponse(
                new AppointmentResource($appointment->load(['doctor', 'service'])),
                'Appointment updated successfully'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update appointment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified appointment.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                return $this->notFoundResponse('Appointment not found');
            }

            DB::beginTransaction();

            $appointment->delete();

            DB::commit();

            return $this->successResponse(null, 'Appointment deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to delete appointment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Approve/Confirm an appointment.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function approve(Request $request, int $id): JsonResponse
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                return $this->notFoundResponse('Appointment not found');
            }

            if ($appointment->status === 'confirmed') {
                return $this->errorResponse('Appointment is already confirmed', 400);
            }

            DB::beginTransaction();

            $appointment->status = 'confirmed';
            $appointment->confirmed_at = now();
            
            if ($request->has('admin_notes')) {
                $appointment->admin_notes = $request->admin_notes;
            }

            $appointment->save();

            DB::commit();

            return $this->successResponse(
                new AppointmentResource($appointment->load(['doctor', 'service'])),
                'Appointment approved successfully'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to approve appointment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Cancel an appointment.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function cancel(Request $request, int $id): JsonResponse
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                return $this->notFoundResponse('Appointment not found');
            }

            if ($appointment->status === 'cancelled') {
                return $this->errorResponse('Appointment is already cancelled', 400);
            }

            if ($appointment->status === 'completed') {
                return $this->errorResponse('Cannot cancel a completed appointment', 400);
            }

            DB::beginTransaction();

            $appointment->status = 'cancelled';
            
            if ($request->has('admin_notes')) {
                $appointment->admin_notes = $request->admin_notes;
            }

            $appointment->save();

            DB::commit();

            return $this->successResponse(
                new AppointmentResource($appointment->load(['doctor', 'service'])),
                'Appointment cancelled successfully'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to cancel appointment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Reject an appointment.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function reject(Request $request, int $id): JsonResponse
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                return $this->notFoundResponse('Appointment not found');
            }

            if ($appointment->status === 'rejected') {
                return $this->errorResponse('Appointment is already rejected', 400);
            }

            DB::beginTransaction();

            $appointment->status = 'rejected';
            
            if ($request->has('admin_notes')) {
                $appointment->admin_notes = $request->admin_notes;
            }

            $appointment->save();

            DB::commit();

            return $this->successResponse(
                new AppointmentResource($appointment->load(['doctor', 'service'])),
                'Appointment rejected successfully'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to reject appointment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Complete an appointment.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function complete(Request $request, int $id): JsonResponse
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                return $this->notFoundResponse('Appointment not found');
            }

            if ($appointment->status === 'completed') {
                return $this->errorResponse('Appointment is already completed', 400);
            }

            if ($appointment->status !== 'confirmed') {
                return $this->errorResponse('Only confirmed appointments can be marked as completed', 400);
            }

            DB::beginTransaction();

            $appointment->status = 'completed';
            
            if ($request->has('admin_notes')) {
                $appointment->admin_notes = $request->admin_notes;
            }

            $appointment->save();

            DB::commit();

            return $this->successResponse(
                new AppointmentResource($appointment->load(['doctor', 'service'])),
                'Appointment marked as completed'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to complete appointment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get appointment statistics.
     *
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total' => Appointment::count(),
                'pending' => Appointment::where('status', 'pending')->count(),
                'confirmed' => Appointment::where('status', 'confirmed')->count(),
                'completed' => Appointment::where('status', 'completed')->count(),
                'cancelled' => Appointment::where('status', 'cancelled')->count(),
                'rejected' => Appointment::where('status', 'rejected')->count(),
                'today' => Appointment::whereDate('preferred_date', today())->count(),
                'this_week' => Appointment::whereBetween('preferred_date', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count(),
                'this_month' => Appointment::whereMonth('preferred_date', now()->month)
                    ->whereYear('preferred_date', now()->year)
                    ->count(),
            ];

            return $this->successResponse($stats, 'Statistics retrieved successfully');

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve statistics: ' . $e->getMessage(), 500);
        }
    }
}
