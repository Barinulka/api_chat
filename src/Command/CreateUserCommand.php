<?php 
namespace App\Command;

use App\Entity\UUID;
use App\Entity\User\User;
use App\Entity\Person\Name;
use App\Exception\Command\CommandException;
use App\Exception\UserAlreadyExistanceException;
use App\Repository\UserRepository\UserRepositoryInterface;

class CreateUserCommand
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {

    }

    /**
     * @throws CommandException
     * @throws UserAlreadyExistanceException
     */
    public function handle(Arguments $arguments): void
    {
        $this->userRepository->save(
            new User(
                UUID::randomUUID(),
                new Name(
                    $arguments->get('first_name'),
                    $arguments->get('last_name'),
                ),
                $arguments->get('login')
            )
        );
    }
}