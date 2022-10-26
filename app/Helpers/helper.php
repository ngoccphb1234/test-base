<?php

use App\Exceptions\ExecuteException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

if (!function_exists("get_meta")) {
    function restful_success($data, $is_multi = false, $meta = null, $message = null)
    {
        $res = [
            "status" => 1,
            "message" => $message ?? __('messages.success')
        ];
        if ($is_multi) {
            $res['datas'] = $data;
        } else {
            $res['data'] = $data;
        }

        if ($meta) {
            $res['meta'] = $meta;
        }
        return response()->json($res);
    }
}

function restful_error($message = null, $code = 404)
{
    $res = [
        "status" => 0,
        "message" => $message ?? __('messages.error')
    ];

    return response()->json($res, $code);
}

function restful_exception(Exception $exception)
{

    if ($exception instanceof ValidationException) {
        return restful_error($exception->validator->errors()->first());
    } elseif ($exception instanceof ExecuteException) {
        return restful_error($exception->getMessage(), $exception->getCode());
    } else {
        if (!config('app.debug')) {
            Log::error($exception);
        }
        return restful_error(
             $exception->getMessage() ?? __('messages.failed')
        );
    }
}
if (!function_exists("get_meta")) {

    function get_meta($paginateData)
    {
      $paginateData->appends(request()->query());

        return [
            'total' => $paginateData->total(),
            'limit' => $paginateData->perPage() ? $paginateData->perPage() : 10,
            'current_page' => $paginateData->currentPage(),
            'last_page' => $paginateData->lastPage(),
            'next_url' => $paginateData->nextPageUrl(),
            'prev_url' => $paginateData->previousPageUrl()
        ];
    }
}
