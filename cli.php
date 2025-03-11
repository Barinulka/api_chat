<?php 

declare(strict_types= 1);
use App\Entity\UUID;
use App\Entity\User\User;
use App\Entity\Person\Name;
use App\Helper\ExceptionHandler;
use App\Repository\UserRepository\SqliteUserRepository;

require_once 'vendor/autoload.php';

set_exception_handler(function (\Throwable $e) {
    (new ExceptionHandler())->handle($e);
    exit;
});

$connection = new PDO('sqlite:' . __DIR__ . '/db.sqlite');

$userRepository = new SqliteUserRepository($connection);


try {
    // $userRepository->save(new User(UUID::randomUUID(), new Name('Alexey', 'Nikolaevich'), 'al.barinov'));
   echo $userRepository->get(new UUID('32bdf424-b71a-40c5-b1ac-df8ee5f5dedd'));
} catch (\Throwable $e) {
    (new ExceptionHandler())->handle($e);
}