<?php
namespace App\Entity\Person;

class Name
{
    public function __construct(
        private string $firstName,
        private string $lastName
    ) {
    }

    public function __tostring(): string
    {
        return $this->firstName ." ". $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}