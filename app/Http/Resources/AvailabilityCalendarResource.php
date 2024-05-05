<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'price_standard' => number_format($this->price_standard),
            'price_adult' => number_format($this->price_adult),
            'price_child' => number_format($this->price_child),
            'price_infant' => number_format($this->price_infant),
            'available' => $this->available,
        ];
    }
}
