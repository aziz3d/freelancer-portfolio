<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'features' => 'array',
            'features.*' => 'string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The service title is required.',
            'title.max' => 'The service title may not be greater than 255 characters.',
            'description.required' => 'The service description is required.',
            'icon.required' => 'Please select an icon for the service.',
            'features.*.string' => 'Each feature must be a valid text.',
            'features.*.max' => 'Each feature may not be greater than 255 characters.',
            'sort_order.integer' => 'Sort order must be a number.',
            'sort_order.min' => 'Sort order must be at least 0.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('features')) {
            $features = array_filter($this->features, function($feature) {
                return !empty(trim($feature));
            });
            $this->merge(['features' => array_values($features)]);
        }

        $this->merge([
            'is_active' => $this->has('is_active'),
            'sort_order' => $this->sort_order ?? 0,
        ]);
    }
}