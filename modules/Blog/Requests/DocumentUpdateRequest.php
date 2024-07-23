<?php

namespace Modules\Blog\Requests;

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
            'slug' => ['required', 'max:255', 'alpha_dash'],
            'content' => ['required', 'string'],
            'excerpt' => ['required', 'string'],
        ];
    }


    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => __('title'),
            'status' => __('status'),
            'slug' => __('slug'),
            'content' => __('content'),
            'excerpt' => __('excerpt'),
        ];
    }
}
