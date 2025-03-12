<?php
namespace App\Command;

use App\Exception\Command\ArgumentException;
final class Arguments
{
    private array $arguments = [];

    public function __construct(iterable $arguments)
    {
        foreach ($arguments as $key => $argument) {
            $stringValue = trim((string) $argument);

            if (empty($stringValue)) {
                continue;
            }

            $this->arguments[(string)$key] = $stringValue;
        }
    }

    public function get(string $argument): string
    {
        if (!array_key_exists($argument, $this->arguments)) {
            throw new ArgumentException('Такого аргумента не существует', ['argument' => $argument]);
        }

        return $this->arguments[$argument];
    }

    public static function parseRawInput(array $rawInput): self
    {
        $arguments = [];

        foreach ($rawInput as $argument) {
            $parts = explode("=", $argument);

            if (count($parts) !== 2) {
                continue;
            }

            $arguments[$parts[0]] = $parts[1];
        }

        return new self($arguments);
    }
}