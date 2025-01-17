<?php

namespace App\DTOs;


class DTORequest
{
    private readonly ?string $instance;
    public function __construct(?string $instance = null,?array $decryptedContent = null){
        $this->instance = $instance;
        if(empty($instance))
            throw new \Exception('REQUEST_NOT_VALID');

    }
    public function getInstance(): ?string
    {
        return $this->instance;
    }

}
