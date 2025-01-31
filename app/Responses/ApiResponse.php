<?php

namespace App\Responses;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ApiResponse extends Response implements Responsable
{
    private int              $status     = 200;
    private string|int|null  $errorCode  = null;
    private string|null      $message    = null;
    private mixed            $data       = [];
    private array|Collection $errors     = [];


    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setErrorCode(string|int $errorCode): self
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }


    public function setErrors(array|Collection $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function success(string|null $message = 'success', int $status = 200): self
    {
        return $this->respond(message: $message, status: $status);
    }

    public function error(string|null $message, string|int|null $errorCode = null, array|Collection $errors = [], int $status = 422): self
    {
        return $this->respond(message: $message ?: $this->message, errorCode: $errorCode, errors: $errors, status: $status);
    }

    public function data(mixed $data, string|null $message = null, int $status = 200): self
    {
        return $this->respond(message: $message ?: $this->message, data: $data,  status: $status);
    }

    public function respond(string|null $message = null, mixed $data = [], string|int|null $errorCode = null, array|Collection $errors = [], int $status = 200): static
    {
        $this->message    = $message;
        $this->data       = $data;
        $this->errorCode  = $errorCode;
        $this->errors     = $errors;
        $this->status     = $status;
        return $this;
    }


    public function toResponse($request): JsonResponse|string
    {
        return response()->json([
            'message'    => $this->message,
            'data'       => $this->data,
            'errors'     => $this->errors,
            'error_code' => $this->errorCode
        ], $this->status);
    }

    protected function isResponseData(mixed $data): bool
    {
        return is_a($data, AnonymousResourceCollection::class) || is_a($data, Paginator::class);
    }
}
