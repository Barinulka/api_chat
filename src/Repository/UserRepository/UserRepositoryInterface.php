<?php
namespace App\Repository\UserRepository;

use App\Entity\User\User;
use App\Entity\UUID;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function get(UUID $uuid): User;
}