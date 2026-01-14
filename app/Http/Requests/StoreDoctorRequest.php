<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'specialization' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'license_number' => 'nullable|string|max:100|unique:users,license_number',
            'years_of_experience' => 'nullable|integer|min:0|max:70',
            'consultation_fee' => 'nullable|numeric|min:0|max:999999.99',
            'profile_image' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Doctor name is required',
            'name.max' => 'Doctor name cannot exceed 255 characters',
            'email.required' => 'Email address is required',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email address is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'phone.max' => 'Phone number cannot exceed 20 characters',
            'address.max' => 'Address cannot exceed 500 characters',
            'specialization.required' => 'Specialization is required',
            'specialization.max' => 'Specialization cannot exceed 100 characters',
            'license_number.unique' => 'This license number is already registered',
            'license_number.max' => 'License number cannot exceed 100 characters',
            'years_of_experience.integer' => 'Years of experience must be a whole number',
            'years_of_experience.min' => 'Years of experience cannot be negative',
            'years_of_experience.max' => 'Years of experience cannot exceed 70',
            'consultation_fee.numeric' => 'Consultation fee must be a valid number',
            'consultation_fee.min' => 'Consultation fee cannot be negative',
            'consultation_fee.max' => 'Consultation fee cannot exceed 999,999.99',
            'is_active.boolean' => 'Active status must be true or false',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => 'doctor name',
            'email' => 'email address',
            'password' => 'password',
            'phone' => 'phone number',
            'address' => 'address',
            'specialization' => 'specialization',
            'bio' => 'biography',
            'license_number' => 'license number',
            'years_of_experience' => 'years of experience',
            'consultation_fee' => 'consultation fee',
            'profile_image' => 'profile image',
            'is_active' => 'active status',
        ];
    }
}
