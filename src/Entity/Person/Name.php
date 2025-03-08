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
}