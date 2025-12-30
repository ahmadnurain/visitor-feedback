<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'destination_id' => ['required', 'exists:destinations,id'],
            'feedback_category_id' => ['required', 'exists:feedback_categories,id'],
            'visitor_name' => ['nullable', 'string', 'max:50'],
            'rating' => ['nullable', 'integer', 'between:1,5'],
            'title' => ['required', 'string', 'max:150'],
            'content' => ['required', 'string', 'max:5000'],
            'contact_email' => ['nullable', 'email', 'max:50'],
            'contact_phone' => ['nullable', 'string', 'max:14', 'regex:/^[0-9]+$/'],
            'attachments.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }
}
