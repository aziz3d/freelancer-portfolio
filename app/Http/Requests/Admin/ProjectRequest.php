<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
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
        $projectId = $this->route('project') ? $this->route('project')->id : null;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('projects', 'slug')->ignore($projectId)
            ],
            'description' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:min_width=100,min_height=100',
            'project_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:min_width=100,min_height=100',
            'tags' => 'nullable',
            'technologies' => 'nullable',
            'project_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,published',
        ];
    }

    public function attributes(): array
    {
        return [
            'project_images.*' => 'project image',
            'project_url' => 'project URL',
            'github_url' => 'GitHub URL',
            'is_featured' => 'featured status',
            'sort_order' => 'sort order',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The project title is required.',
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
            'slug.unique' => 'This slug is already taken.',
            'thumbnail.image' => 'The thumbnail must be an image file.',
            'thumbnail.max' => 'The thumbnail may not be greater than 5MB.',
            'thumbnail.dimensions' => 'The thumbnail must be at least 100x100 pixels.',
            'project_images.*.image' => 'Each project image must be an image file.',
            'project_images.*.max' => 'Each project image may not be greater than 5MB.',
            'project_images.*.dimensions' => 'Each project image must be at least 100x100 pixels.',
            'project_url.url' => 'The project URL must be a valid URL.',
            'github_url.url' => 'The GitHub URL must be a valid URL.',
            'status.in' => 'The status must be either draft or published.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
        ]);

        if (!$this->has('sort_order') || $this->sort_order === '') {
            $this->merge([
                'sort_order' => 0,
            ]);
        }
    }
}