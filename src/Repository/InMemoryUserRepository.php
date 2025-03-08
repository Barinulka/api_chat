<?php 
namespace App\Repository;

use App\Entity\User\User;
use App\Exception\UserNotFoundException;

class InMemoryUserRepository
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    public function getById(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException(data: ["id"=> $id]);
        }

        return $this->users[$id];
    }
}