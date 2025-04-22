<?php

namespace App\Entities;

use DateTimeImmutable;

class HomeAnnouncementEntity
{
    public function __construct(
        private readonly ?string           $id,
        private readonly string            $user_id,
        private string                     $title,
        private readonly string            $description,
        private float                      $price,
        private readonly string            $location,
        private string                     $image,
        private readonly DateTimeImmutable $createdAt,
        private readonly DateTimeImmutable $updatedAt,
    )
    {}
    public function getId(): ?string{return $this->id;}
    public function getUserId(): string{return $this->user_id;}
    public function getTitle(): string{return $this->title;}
    public function getDescription(): string{return $this->description;}
    public function getPrice(): float{return $this->price;}
    public function getLocation(): string{return $this->location;}
    public function getImage(): string{return $this->image;}
    public function getCreatedAt(): DateTimeImmutable{return $this->createdAt;}
    public function getUpdatedAt(): DateTimeImmutable{return $this->updatedAt;}
    public function setTitle(string $title): void {
        if (strlen($title) < 3) {
            throw new \InvalidArgumentException("Il titolo deve avere almeno 3 caratteri.");
        }
        $this->title = $title;
    }

    public function setPrice(float $price): void {
        if ($price < 0) {
            throw new \InvalidArgumentException("Il prezzo non può essere negativo.");
        }
        $this->price = $price;
    }

    public function setImage(?string $image): void {
        if ($image && !filter_var($image, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Il percorso dell'immagine non è valido.");
        }
        $this->image = $image;
    }
}
