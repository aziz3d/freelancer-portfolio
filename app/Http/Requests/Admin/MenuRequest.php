<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
        $menuId = $this->route('menu') ? $this->route('menu')->id : null;

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('menus', 'slug')->ignore($menuId),
            ],
            'route_name' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'opens_in_new_tab' => 'boolean',
            'description' => 'nullable|string|max:500',
            'create_page' => 'boolean',
            'page_excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|array',
            'meta_keywords.*' => 'string|max:100',
        ];

        if ($this->boolean('create_page') || $this->input('destination_type') === 'page') {
            $rules['page_content'] = 'required|string';
        } else {
            $rules['page_content'] = 'nullable|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The menu title is required.',
            'slug.required' => 'The menu slug is required.',
            'slug.regex' => 'The slug must contain only lowercase letters, numbers, and hyphens.',
            'slug.unique' => 'This slug is already taken.',
            'sort_order.required' => 'The sort order is required.',
            'sort_order.integer' => 'The sort order must be a number.',
            'sort_order.min' => 'The sort order must be at least 0.',
            'page_content.required_if' => 'Page content is required when creating a page.',
        ];
    }
}
