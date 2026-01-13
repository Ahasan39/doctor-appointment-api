<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:blogs,title',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'status' => 'nullable|in:draft,published,archived',
            'published_at' => 'nullable|date',
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
            'title.required' => 'Blog title is required',
            'title.unique' => 'A blog with this title already exists',
            'title.max' => 'Blog title cannot exceed 255 characters',
            'slug.unique' => 'This slug is already in use',
            'excerpt.max' => 'Excerpt cannot exceed 500 characters',
            'content.required' => 'Blog content is required',
            'category.max' => 'Category name cannot exceed 100 characters',
            'tags.array' => 'Tags must be an array',
            'tags.*.string' => 'Each tag must be a string',
            'tags.*.max' => 'Each tag cannot exceed 50 characters',
            'status.in' => 'Status must be draft, published, or archived',
            'published_at.date' => 'Published date must be a valid date',
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
            'title' => 'blog title',
            'slug' => 'URL slug',
            'excerpt' => 'excerpt',
            'content' => 'content',
            'featured_image' => 'featured image',
            'category' => 'category',
            'tags' => 'tags',
            'status' => 'status',
            'published_at' => 'published date',
        ];
    }
}
