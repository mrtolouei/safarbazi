<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;

abstract class Controller
{
    /**
     * Default pagination size per each page
     */
    protected static int $PAGINATE = 20;

    /**
     * JSON response structure
     */
    public static function json(array $data = [], string $message = '', string $status = 'ok', int $httpCode = 200): JsonResponse
    {
        return Response::json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $httpCode);
    }

    /**
     * Pagination data of models
     */
    protected function paginate(LengthAwarePaginator $model): array
    {
        return [
            'current_page' => $model->currentPage(),
            'next_page_url' => $model->nextPageUrl(),
            'previous_page_url' => $model->previousPageUrl(),
            'last_page' => $model->lastPage(),
            'page_size' => $model->perPage(),
            'total' => $model->total(),
        ];
    }
}
