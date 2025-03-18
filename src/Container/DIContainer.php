<?php 
namespace App\Container;

use App\Exception\NotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class DIContainer implements ContainerInterface
{
    private array $resolves = [];


    public function get(string $type): object
    {

        if (array_key_exists($type, $this->resolves)) {
            $typeToCreate = $this->resolves[$type];

            if (is_object($typeToCreate)) {
                return $typeToCreate;
            }

            return $this->get($typeToCreate);
        }

        if (!class_exists($type)) {
            throw new NotFoundException("Не удалось найти тип: $type");
        }

        $reflectionClass = new ReflectionClass($type);

        $constructor = $reflectionClass->getConstructor();

        if (null === $constructor) {
            return new $type();
        }

        $parameters = [];

        foreach ($constructor->getParameters() as $parameter) {
            $parameterType = $parameter->getType()->getName();

            $parameters[] = $this->get($parameterType);
        }

        return new $type(...$parameters);
    }

    public function bind(string $type, $resolver): void
    {
        $this->resolves[$type] = $resolver;
    }

    public function has(string $type): bool
    {
        // Здесь мы просто пытаемся создать
        // объект требуемого типа
        try {
            $this->get($type);
        } catch (NotFoundException $e) {
        // Возвращаем false, если объект не создан...
            return false;
        }
        // и true, если создан
        return true;
    }
}