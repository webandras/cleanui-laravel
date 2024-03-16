<?php

namespace App\Http\Requests\Clean;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasPermissionTo('manage-documents');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255', 'string'],
            'status' => ['required', 'in:draft,under-review,published', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'content' => ['required', 'string'],
            'excerpt' => ['required', 'string'],
        ];
    }
}
