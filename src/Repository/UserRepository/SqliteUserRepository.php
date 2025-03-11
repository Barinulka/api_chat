<?php 
namespace App\Repository\UserRepository;

use PDO;
use App\Entity\UUID;
use App\Entity\User\User;
use App\Entity\Person\Name;
use App\Exception\UserNotFoundException;

class SqliteUserRepository
{
    public function __construct(
        private PDO $connection
    ) {

    }

    public function save(User $user): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO users (uuid, login, first_name, last_name)
                VALUES (:uuid, :login, :first_name, :last_name)'
        );

        $statement->execute([
            ':uuid' => (string)$user->getId(),
            ':login' => $user->getLogin(),
            ':first_name' => $user->getUserName()->getFirstName(),
            ':last_name' => $user->getUserName()->getLastName(),
        ]);
    }

    public function get(UUID $uuid): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );

        $statement->execute([
            ':uuid' => (string)$uuid
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (false === $result) {
            throw new UserNotFoundException('Пользователь не найден', ['uuid' => (string)$uuid]);
        }

        return new User(
            new UUID($result['uuid']),
            new Name($result['first_name'], $result['last_name']),
            $result['login']
        );
    }
}