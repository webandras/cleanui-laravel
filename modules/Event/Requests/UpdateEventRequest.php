<?php

namespace Modules\Event\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasPermissionTo('manage-events');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'alpha_dash', 'max:255', Rule::unique('events')->ignore($this->event->id, 'id')],
            'description' => ['required', 'string'],
            'start' => ['required', 'string'],
            'end' => ['required', 'string'],
            'timezone' => ['required', 'string'],
            'backgroundColor' => ['nullable', 'string', 'max:20'],
            'backgroundColorDark' => ['nullable', 'string', 'max:20'],
            'cover_image_url' => ['required', 'max:255', 'string'],
            'facebook_url' => ['required', 'string'],
            'tickets_url' => ['nullable', 'string'],
            'organizer_id' => ['required', 'int', 'min:1'],
            'location_id' => ['required', 'int', 'min:1'],
            'allDay' => ['nullable', 'boolean'],
            'status' => ['required', 'string', 'in:posted,cancelled']
        ];
    }
}
