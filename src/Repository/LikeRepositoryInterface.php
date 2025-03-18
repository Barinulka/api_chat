<?php

namespace App\Repository;

use App\Entity\Post\PostLike;
use App\Entity\UUID;

interface LikeRepositoryInterface
{
    public function save(PostLike $postLike): void;
    public function getByPostUUID(UUID $postUUID): array;

}