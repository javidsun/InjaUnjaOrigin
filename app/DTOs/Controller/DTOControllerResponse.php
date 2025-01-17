<?php

namespace App\DTOs\Controller;

use Illuminate\Http\Response;

class DTOControllerResponse
{
    public bool $success;
    public mixed $payload;
    public ?int $httpStatus;
    public ?string $message;

    public function __construct(bool $success, $payload = null, int $httpStatus = 200 , ?string $message = null)
    {
        $this->success = $success;
        $this->payload = $payload;
        $this->httpStatus = $httpStatus;
        $this->message = $message;
    }

    public function __toString()
    {
        return json_encode([
            'success' => $this->success,
            'payload' => $this->payload,
            'message' => $this->message,
            'httpStatus' => $this->httpStatus,
        ]);
    }

    public function toResponse(): Response
    {
        return response(
            ['success' => $this->success, 'payload' => $this->payload , 'message' => $this->message],
            $this->httpStatus
        );
    }
}
