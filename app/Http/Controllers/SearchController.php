<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccommodationResource;
use App\Http\Resources\SearchResource;
use App\Models\Accommodation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $accommodations = Accommodation::whereHas('calendars', function ($q) use ($request) {
                $q->whereIn('date', [$request['date_from'], $request['date_to']]);
                $q->where('available', 1);
            })->get();

        $data = [
            'accommodations' => SearchResource::collection($accommodations),
        ];
        return self::json($data);
    }
}
