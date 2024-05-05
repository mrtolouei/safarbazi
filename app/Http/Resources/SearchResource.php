<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $adultCount = $request->get('adult_count');
        $childCount = $request->get('child_count');
        $infantCount = $request->get('infant_count');
        $priceStandard = $this->calendars->sum('price_standard');
        $priceAdult = $this->calendars->sum('price_adult');
        $priceChild = $this->calendars->sum('price_child');
        $priceInfant = $this->calendars->sum('price_infant');
        $price = $priceStandard +
            ($priceAdult * $adultCount) +
            ($priceChild * $childCount) +
            ($priceInfant * $infantCount);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => number_format($price),
        ];
    }
}
