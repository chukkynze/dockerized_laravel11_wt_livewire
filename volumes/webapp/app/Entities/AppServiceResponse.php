<?php


namespace App\Entities;

class AppServiceResponse
{
    private bool   $status;
    private string $message;
    private array  $data;
    private array  $errors;
    private int    $suggestedHttpResponseCode;
    private string $requestHistoryKey;

    public function __construct(
        bool   $status,
        string $message,
        array  $data,
        array  $errors,
        int    $suggestedHttpResponseCode,
        string $requestHistoryKey=''
    )
    {
        $this->status                    = $status;
        $this->message                   = $message;
        $this->data                      = $data;
        $this->errors                    = $errors;
        $this->requestHistoryKey         = $requestHistoryKey;
        $this->suggestedHttpResponseCode = $suggestedHttpResponseCode;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return int
     */
    public function getSuggestedHttpResponseCode(): int
    {
        return $this->suggestedHttpResponseCode;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->suggestedHttpResponseCode;
    }

    /**
     * @return string
     */
    public function getRequestHistoryKey(): string
    {
        return $this->requestHistoryKey;
    }

}
