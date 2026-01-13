<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:services,name',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0|max:999999.99',
            'duration' => 'required|integer|min:1|max:1440', // Max 24 hours in minutes
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
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
            'name.required' => 'Service name is required',
            'name.unique' => 'A service with this name already exists',
            'name.max' => 'Service name cannot exceed 255 characters',
            'slug.unique' => 'This slug is already in use',
            'description.required' => 'Service description is required',
            'short_description.max' => 'Short description cannot exceed 500 characters',
            'price.required' => 'Service price is required',
            'price.numeric' => 'Price must be a valid number',
            'price.min' => 'Price cannot be negative',
            'price.max' => 'Price cannot exceed 999,999.99',
            'duration.required' => 'Service duration is required',
            'duration.integer' => 'Duration must be a whole number',
            'duration.min' => 'Duration must be at least 1 minute',
            'duration.max' => 'Duration cannot exceed 1440 minutes (24 hours)',
            'is_active.boolean' => 'Active status must be true or false',
            'order.integer' => 'Order must be a whole number',
            'order.min' => 'Order cannot be negative',
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
            'name' => 'service name',
            'slug' => 'URL slug',
            'description' => 'description',
            'short_description' => 'short description',
            'price' => 'price',
            'duration' => 'duration',
            'icon' => 'icon',
            'image' => 'image',
            'is_active' => 'active status',
            'order' => 'display order',
        ];
    }
}
