<?php 

declare(strict_types= 1);
use App\Entity\UUID;
use App\Entity\User\User;
use App\Entity\Person\Name;
use App\Helper\ExceptionHandler;
use App\Repository\UserRepository\SqliteUserRepository;

require_once 'vendor/autoload.php';

set_exception_handler(function (Exception $e) {
    (new ExceptionHandler())->handle($e);
    exit;
});

$connection = new PDO('sqlite:' . __DIR__ . '/db.sqlite');

$userRepository = new SqliteUserRepository($connection);


try {
    $userRepository->save(new User(UUID::randomUUID(), new Name('Test', 'User'), 'testLogin'));
} catch (\Throwable $e) {
    (new ExceptionHandler())->handle($e);
}