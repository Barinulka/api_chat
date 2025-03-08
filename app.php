<?php

declare(strict_types= 1);

use App\Entity\User\User;
use App\Entity\Person\Name;
use App\Helper\ExceptionHandler;
use App\Repository\InMemoryUserRepository;

require_once 'vendor/autoload.php';
require_once 'functions.php';

$exceptionHandler = new ExceptionHandler();

$name = new Name('Alexey', 'Barinulka');
$user = new User(1, $name, 'login');

$repository = new InMemoryUserRepository();

try {
    $repository->save($user);

    echo $repository->getById(1);
} catch (Exception $e) {
    $exceptionHandler->handle($e);
}