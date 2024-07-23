<?php

namespace Modules\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasPermissionTo('manage-posts');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255', 'string'],
            'status' => ['required', 'in:draft,under-review,published', 'string'],
            'slug' => ['nullable', 'max:255', 'alpha_dash'],
            'cover_image_url' => ['nullable', 'max:255', 'string'],
            'content' => ['required', 'string'],
            'excerpt' => ['required', 'string'],
            'is_highlighted' => ['nullable', 'boolean'],
            'categories' => ['array'],
        ];
    }


    /**
     * @return array[]
     */
    public function attributes(): array
    {
        return [
            'title' => __('title'),
            'status' => __('status'),
            'slug' => __('slug'),
            'cover_image_url' => __('cover_image_url'),
            'content' => __('content'),
            'excerpt' => __('excerpt'),
            'is_highlighted' => __('is_highlighted'),
            'categories' => __('categories'),
        ];
    }
}
