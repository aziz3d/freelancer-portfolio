<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogId = $this->route('blog') ? $this->route('blog')->id : null;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('blogs', 'slug')->ignore($blogId),
            ],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:min_width=100,min_height=100',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date|after_or_equal:now',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The blog title is required.',
            'title.max' => 'The blog title may not be greater than 255 characters.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
            'excerpt.max' => 'The excerpt may not be greater than 500 characters.',
            'content.required' => 'The blog content is required.',
            'thumbnail.image' => 'The thumbnail must be an image.',
            'thumbnail.mimes' => 'The thumbnail must be a file of type: jpeg, png, jpg, gif, webp.',
            'thumbnail.max' => 'The thumbnail may not be greater than 5MB.',
            'thumbnail.dimensions' => 'The thumbnail must be at least 100x100 pixels.',
            'meta_title.max' => 'The meta title may not be greater than 60 characters.',
            'meta_description.max' => 'The meta description may not be greater than 160 characters.',
            'tags.*.max' => 'Each tag may not be greater than 50 characters.',
            'status.required' => 'Please select a status for the blog post.',
            'status.in' => 'The status must be either draft or published.',
            'published_at.date' => 'The publication date must be a valid date.',
            'published_at.after_or_equal' => 'The publication date must be today or in the future.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('tags') && is_string($this->tags)) {
            $tags = array_filter(array_map('trim', explode(',', $this->tags)));
            $this->merge(['tags' => $tags]);
        }

        if ($this->status === 'published' && !$this->published_at) {
            $this->merge(['published_at' => now()]);
        }
        if ($this->status === 'draft') {
            $this->merge(['published_at' => null]);
        }
    }
}