<?php

namespace App\Domain\Repositories;

use App\Entities\HomeAnnouncementEntity;

interface AnnouncementRepositoryInterface
{
    public function store(HomeAnnouncementEntity $entity):HomeAnnouncementEntity;

}
