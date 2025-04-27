<?php

namespace App\Domain;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\Uid\Ulid;

abstract class Entity
{

    /**
     * @throws ReflectionException
     */
    public function fromArray(array $data): static
    {
        $reflection = new ReflectionClass(static::class);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            throw new \RuntimeException('Nessun costruttore trovato per ' . static::class);
        }

        $parameters = $constructor->getParameters();
        $args = [];

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType()?->getName();

            if (array_key_exists($name, $data)) {
                $value = $data[$name];

                if ($type === Ulid::class && !($value instanceof Ulid)) {
                    $value = Ulid::fromString($value);
                }

                $args[] = $value;
            } else {
                $args[] = null;
            }
        }

        return $reflection->newInstanceArgs($args);
    }

}
