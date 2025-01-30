<?php

use App\Responses\ApiResponse;



if (!function_exists('apiResponse')) {
    function apiResponse(): ApiResponse
    {
        return app(ApiResponse::class);
    }
}
