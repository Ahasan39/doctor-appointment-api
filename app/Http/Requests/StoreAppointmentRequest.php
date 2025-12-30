<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'nullable|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string|max:1000',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'nullable|date_format:H:i:s',
            'status' => 'nullable|in:pending,confirmed,completed,cancelled,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'service_id.exists' => 'The selected service does not exist.',
            'name.required' => 'Patient name is required.',
            'phone.required' => 'Patient phone number is required.',
            'preferred_date.required' => 'Preferred appointment date is required.',
            'preferred_date.after_or_equal' => 'Appointment date must be today or a future date.',
            'status.in' => 'Invalid appointment status.',
        ];
    }
}
