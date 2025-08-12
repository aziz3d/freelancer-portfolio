<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:2000',
            'honeypot' => 'nullable|max:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Your name must be at least 2 characters.',
            'name.max' => 'Your name cannot exceed 255 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'Your message must be at least 10 characters.',
            'message.max' => 'Your message cannot exceed 2000 characters.',
            'honeypot.max' => 'Spam detected.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->hasSpamIndicators()) {
            $this->merge(['honeypot' => 'spam']);
        }
    }

    private function hasSpamIndicators(): bool
    {
        $message = strtolower($this->input('message', ''));
        $name = strtolower($this->input('name', ''));
        
        $spamKeywords = [
            'viagra', 'cialis', 'casino', 'poker', 'loan', 'mortgage',
            'seo service', 'link building', 'buy now', 'click here',
            'make money', 'work from home', 'guaranteed'
        ];
        
        foreach ($spamKeywords as $keyword) {
            if (str_contains($message, $keyword) || str_contains($name, $keyword)) {
                return true;
            }
        }
        
        if (substr_count($message, 'http') > 2) {
            return true;
        }
        
        $words = explode(' ', $message);
        if (count($words) !== count(array_unique($words)) && count($words) > 10) {
            $repetitionRatio = (count($words) - count(array_unique($words))) / count($words);
            if ($repetitionRatio > 0.3) {
                return true;
            }
        }
        
        return false;
    }
}