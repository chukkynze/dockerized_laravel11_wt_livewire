<?php


namespace App\Entities;

class AppServiceResponse
{
    private bool   $status;
    private string $message;
    private array  $data;
    private array $errors;

    public function __construct(
        bool   $status,
        string $message,
        array  $data,
        array  $errors,
    )
    {
        $this->status  = $status;
        $this->message = $message;
        $this->data    = $data;
        $this->errors  = $errors;
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

}
