<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
    }
    public static function getJsonResponse($messageKey, $data = null, $result = true, $code = 200, $exception = null): JsonResponse
    {
        $response = [
            'message' => trans('messages.' . Str::slug($messageKey, '_'), [], app()->getLocale()),
            'data' => $data,
            'result' => $result,
            'code' => $code
        ];
        if (env('APP_ENV') != 'production') {
            if ($exception != null) $response['exception'] = $exception;
        }
        return response()->json($response, $code);
    }
}
