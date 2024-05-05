<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AccommodationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'capacity' => 'required|numeric',
            'available_dates' => 'required|array',
            'available_dates.*.date' => 'required|date',
            'available_dates.*.price_standard' => 'required|numeric',
            'available_dates.*.price_adult' => 'required|numeric',
            'available_dates.*.price_child' => 'required|numeric',
            'available_dates.*.price_infant' => 'required|numeric',
            'available_dates.*.available' => 'required|boolean',
        ];
    }
}
