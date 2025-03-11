<?php 

declare(strict_types= 1);

namespace App\Entity\User;

use App\Entity\UUID;
use App\Entity\Person\Name;

class User
{
    public function __construct(
        private UUID $id,
        private Name $userName,
        private string $login
    ) {
    }

    public function __tostring(): string
    {
        return sprintf('Пользователь #%d %s с логином %s', $this->id, $this->userName, $this->login) . PHP_EOL;
    }

    public function getId(): UUID
    {
        return $this->id;
    }

    public function setId(UUID $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUserName(): Name
    {
        return $this->userName;
    }

    public function setUserName(Name $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }
}