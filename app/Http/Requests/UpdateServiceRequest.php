<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
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
        $serviceId = $this->route('appointment') ?? $this->route('id');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')->ignore($serviceId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($serviceId),
            ],
            'description' => 'sometimes|required|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'sometimes|required|numeric|min:0|max:999999.99',
            'duration' => 'sometimes|required|integer|min:1|max:1440',
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
