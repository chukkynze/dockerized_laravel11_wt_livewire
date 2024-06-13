<?php

use App\Entities\AppServiceResponse;


if (!function_exists('serviceResponse')) {
    /**
     * Returns a standardized response class from a service to controllers
     * Makes for easier testing
     *
     * @param bool $status
     * @param string $message
     * @param array $data
     * @param int $suggestedHttpResponseCode
     * @param array $errors
     * @param string $requestHistoryKey
     *
     * @return AppServiceResponse
     */
    function serviceResponse(
        bool   $status,
        string $message,
        array  $data,
        int    $suggestedHttpResponseCode,
        array  $errors=[],
        string $requestHistoryKey=''
    ): AppServiceResponse
    {
        return new AppServiceResponse(
            $status,
            $message,
            $data,
            $errors,
            $suggestedHttpResponseCode,
            $requestHistoryKey
        );
    }
}
