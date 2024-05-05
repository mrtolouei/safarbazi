<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccommodationRequest;
use App\Http\Resources\AccommodationResource;
use App\Models\Accommodation;
use App\Models\AvailabilityCalendar;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccommodationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $accommodations = Accommodation::paginate(self::$PAGINATE);
        $data = [
            'accommodations' => AccommodationResource::collection($accommodations),
            'paginate' => $this->paginate($accommodations),
        ];
        return self::json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccommodationRequest $request): JsonResponse
    {
        $request->validated();
        try {
            DB::beginTransaction();

            $accommodation = new Accommodation();
            $accommodation->name = $request->get('name');
            $accommodation->capacity = $request->get('capacity');
            $accommodation->save();

            $availableDates = $request->get('available_dates');
            foreach ($availableDates as $availableDate) {
                $availableCalendar = new AvailabilityCalendar();
                $availableCalendar->accommodation_id = $accommodation->id;
                $availableCalendar->date = $availableDate['date'];
                $availableCalendar->price_standard = $availableDate['price_standard'];
                $availableCalendar->price_adult = $availableDate['price_adult'];
                $availableCalendar->price_child = $availableDate['price_child'];
                $availableCalendar->price_infant = $availableDate['price_infant'];
                $availableCalendar->available = $availableDate['available'];
                $availableCalendar->save();
            }

            $data = [
                'accommodation' => new AccommodationResource($accommodation),
            ];
            DB::commit();
            return self::json($data);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Accommodation creation is failed", [
                'exception' => $exception->getMessage(),
            ]);
            return self::json([], 'Creation is failed', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $accommodation = Accommodation::findOrFail($id);
        $data = [
            'accommodation' => new AccommodationResource($accommodation),
        ];
        return self::json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccommodationRequest $request, string $id): JsonResponse
    {
        $request->validated();
        try {
            DB::beginTransaction();

            $accommodation = Accommodation::findOrFail($id);
            $accommodation->name = $request->get('name');
            $accommodation->capacity = $request->get('capacity');
            $accommodation->save();

            $availableDates = $request->get('available_dates');
            foreach ($availableDates as $availableDate) {
                AvailabilityCalendar::updateOrCreate([
                    'accommodation_id' => $accommodation->id,
                    'date' => $availableDate['date'],
                ],[
                    'price_standard' => $availableDate['price_standard'],
                    'price_adult' => $availableDate['price_adult'],
                    'price_child' => $availableDate['price_child'],
                    'price_infant' => $availableDate['price_infant'],
                    'available' => $availableDate['available'],
                ]);
            }

            $data = [
                'accommodation' => new AccommodationResource($accommodation),
            ];
            DB::commit();
            return self::json($data);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("Accommodation update is failed", [
                'exception' => $exception->getMessage(),
            ]);
            return self::json([], 'Update is failed', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $accommodation = Accommodation::findOrFail($id);
            $accommodation->delete();
            return self::json([], 'Accommodation deleted');
        } catch (Exception $exception) {
            Log::error("Accommodation delete is failed", [
                'exception' => $exception->getMessage(),
            ]);
            return self::json([], 'Delete is failed', 500);
        }
    }
}
