<?php

namespace App\Domain\Entity;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use RuntimeException;
use Symfony\Component\Uid\Ulid;

abstract class Entity
{

    /**
     * Crea un'istanza dell'entità figlia a partire da un array di dati,
     * mappando i dati ai parametri del costruttore.
     *
     * @param array $data  array di dati da cui idratare l'entità.
     * @return static L'istanza dell'entità figlia idratata.
     * @throws ReflectionException Se la reflection fallisce.
     * @throws InvalidArgumentException Se mancano parametri richiesti o ci sono tipi incompatibili.
     * @throws RuntimeException Se l'entità non ha un costruttore (o se decidi che è un errore).
     */
    public static function fromArray(array $data): static
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
