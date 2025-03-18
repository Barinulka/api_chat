<?php 
declare(strict_types= 1);

use App\Command\Arguments;
use App\Command\CreateUserCommand;


$container = require __DIR__ . '/bootstrap.php';

try {
    $command = $container->get(CreateUserCommand::class);
    $command->handle(Arguments::parseRawInput($argv));

} catch (\Throwable $e) {
    echo $e->getMessage();
}