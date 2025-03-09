<?php 
namespace App\Repository\UserRepository;

use App\Entity\User\User;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository\UserRepositoryInterface;

class InMemoryUserRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    public function getUser(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException("Пльзователь не найден", ["id"=> $id]);
        }

        return $this->users[$id];
    }

    public function getAll(): array
    {
        return $this->users;
    }
}