<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PublicAppointmentController extends ApiController
{
    /**
     * Book a new appointment (public - no authentication required).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'required|string|max:20',
            'doctor_id' => 'required|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        // Verify doctor is active
        $doctor = User::where('id', $request->doctor_id)
            ->where('is_doctor', true)
            ->where('is_active', true)
            ->first();

        if (!$doctor) {
            return $this->errorResponse('Doctor not found or inactive', 404);
        }

        // Verify service is active (if provided)
        if ($request->service_id) {
            $service = Service::where('id', $request->service_id)
                ->where('is_active', true)
                ->first();

            if (!$service) {
                return $this->errorResponse('Service not found or inactive', 404);
            }
        }

        // Check if the time slot is available
        $appointmentDateTime = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
        
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingAppointment) {
            return $this->errorResponse('This time slot is already booked. Please choose another time.', 409);
        }

        // Create appointment
        $appointment = Appointment::create([
            'patient_name' => $request->patient_name,
            'patient_email' => $request->patient_email,
            'patient_phone' => $request->patient_phone,
            'doctor_id' => $request->doctor_id,
            'service_id' => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return $this->successResponse(
            new AppointmentResource($appointment->load(['doctor', 'service'])),
            'Appointment booked successfully. You will receive a confirmation email shortly.',
            201
        );
    }

    /**
     * Get available time slots for a specific doctor and date.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        // Verify doctor is active
        $doctor = User::where('id', $request->doctor_id)
            ->where('is_doctor', true)
            ->where('is_active', true)
            ->first();

        if (!$doctor) {
            return $this->errorResponse('Doctor not found or inactive', 404);
        }

        // Get booked appointments for the date
        $bookedSlots = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->date)
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('appointment_time')
            ->toArray();

        // Generate time slots (9 AM to 5 PM, 30-minute intervals)
        $slots = [];
        $startTime = Carbon::parse('09:00');
        $endTime = Carbon::parse('17:00');

        while ($startTime < $endTime) {
            $timeSlot = $startTime->format('H:i');
            $slots[] = [
                'time' => $timeSlot,
                'available' => !in_array($timeSlot, $bookedSlots),
            ];
            $startTime->addMinutes(30);
        }

        return $this->successResponse([
            'date' => $request->date,
            'doctor' => [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'specialization' => $doctor->specialization,
            ],
            'slots' => $slots,
        ], 'Available slots retrieved successfully');
    }

    /**
     * Check appointment status by email and phone.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_email' => 'required|email',
            'patient_phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        $appointments = Appointment::where('patient_email', $request->patient_email)
            ->where('patient_phone', $request->patient_phone)
            ->with(['doctor', 'service'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        if ($appointments->isEmpty()) {
            return $this->errorResponse('No appointments found with the provided information', 404);
        }

        return $this->successResponse(
            AppointmentResource::collection($appointments),
            'Appointments retrieved successfully'
        );
    }
}
