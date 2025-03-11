<?php 
namespace App\Entity;

class UUID
{
    public function __construct(
        private string $uuidString
    ){
       $this->validateUUID($uuidString);
    }

    public function __toString()
    {
        return $this->uuidString;
    }

    public static function randomUUID(): self
    {
        return new self(uuid_create(UUID_TYPE_RANDOM));
    }

    private function validateUUID(string $uuid): void
    {
        if (!uuid_is_valid($uuid)) {
            throw new InvalidArgumentException("Неправильно сформированный UUID", ["UUID" => $uuid]);
        }
    }
}