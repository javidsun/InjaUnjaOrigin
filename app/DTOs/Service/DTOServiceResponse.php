<?php

namespace App\DTOs\Service;

use App\DTOs\Controller\DTOControllerResponse;
use Illuminate\Support\Facades\Log;

class DTOServiceResponse
{

    private bool $success;
    public ?array $items;

    private object|string|int|null|array $singleItem;

    private ?float $executionTime;

    private ?int $statusCode;

    private ?array $additionalInfos;

    public function __construct(bool $success, ?array $items = null, object|int|array|string|null $singleItem = null, ?float $executionTime = null, ?int $statusCode = 200, ?array $additionalInfos = null){
        $this->success = $success;
        $this->items = $items;
        $this->singleItem = $singleItem;
        $this->executionTime = $executionTime;
        $this->statusCode = $statusCode;
        $this->additionalInfos = $additionalInfos;
        if(!empty($this->items) && !empty($this->singleItem)){
            Log::error('OCCHIO_CHE_TI_STAI_CONFONDENDO');
        }
    }
    public function formatControllerResponse(): DTOControllerResponse
    {
        return new DTOControllerResponse($this->success, $this->formatPayload(), $this->statusCode);
    }

    private function formatPayload(): object|array|string|null
    {
        if(isset($this->additionalInfos)){
            return [
                ... $this->additionalInfos,
                'items' => $this->items ?? $this->singleItem
            ];
        }else{
            return $this->items ?? $this->singleItem;
        }
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function getSingleItem(): object|int|array|string|null
    {
        return $this->singleItem;
    }

    public function getExecutionTime(): ?float
    {
        return $this->executionTime;
    }

    public function getAdditionalInfos(): array
    {
        return $this->additionalInfos ?? [];
    }
}
