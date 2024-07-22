<?php

namespace Modules\Event\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'slug' => ['nullable', 'max:255', 'alpha_dash', 'unique:events'],
            'description' => ['required', 'string'],
            'start' => ['required', 'string'],
            'end' => ['required', 'string'],
            'timezone' => ['required', 'string'],
            'backgroundColor' => [ 'nullable', 'string', 'max:20' ],
            'backgroundColorDark' => [ 'nullable', 'string', 'max:20' ],
            'cover_image_url' => ['required', 'max:255', 'string'],
            'facebook_url' => ['required', 'string'],
            'tickets_url' => ['nullable', 'string'],
            'organizer_id' => ['required', 'integer', 'min:1'],
            'location_id' => ['required', 'integer', 'min:1'],
            'allDay' => ['nullable', 'boolean'],
            'status' => ['required', 'string', 'in:posted,cancelled'],
        ];
    }


    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => __('title'),
            'slug' => __('slug'),
            'description' => __('description'),
            'start' => __('start'),
            'end' => __('end'),
            'timezone' => __('timezone'),
            'backgroundColor' => __('backgroundColor'),
            'backgroundColorDark' => __('backgroundColorDark'),
            'cover_image_url' => __('cover_image_url'),
            'facebook_url' => __('facebook_url'),
            'tickets_url' => __('tickets_url'),
            'organizer_id' => __('organizer_id'),
            'location_id' => __('location_id'),
            'allDay' => __('allDay'),
            'status' => __('status'),
        ];
    }
}
