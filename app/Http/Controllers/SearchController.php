<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchResource;
use App\Models\Accommodation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @throws Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        if (! isset($request['date_from'], $request['date_to'])) {
            throw new Exception('Date from and date to is required');
        }
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
