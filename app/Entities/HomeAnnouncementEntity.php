<?php

namespace App\Entities;

use App\Domain\Entity;
use DateTimeImmutable;

class HomeAnnouncementEntity extends Entity
{
    public function __construct(
        protected readonly ?string $id,
        protected readonly string  $user_id,
        protected string           $title,
        protected string           $content,
        protected string           $status,
        protected bool             $is_pinned,
        protected bool             $is_pinned_full,
        protected ?string           $subtitle,
        protected ?string           $link,
        protected ?string  $description,
        protected ?string           $image,
    )
    {
    }

    public function getId(): ?string{return $this->id;}

    public function getUserId(): string{return $this->user_id;}

    public function getTitle(): string{return $this->title;}
    public function getContent(): string{return $this->content;}
    public function getStatus(): string{return $this->status;}
    public function getIsPinned(): bool{return $this->is_pinned;}
    public function getIsPinnedFull(): bool{return $this->is_pinned_full;}
    public function getSubtitle(): string{return $this->subtitle;}
    public function getLink(): string{return $this->link;}

    public function getDescription(): string{return $this->description;}

    public function getImage(): string{return $this->image;}


}
