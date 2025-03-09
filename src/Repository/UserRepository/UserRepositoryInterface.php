<?php
namespace App\Repository\UserRepository;

use App\Entity\User\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function getUser(int $id): User;

    public function getAll(): array;
}