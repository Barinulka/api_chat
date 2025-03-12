<?php 

declare(strict_types= 1);

use App\Entity\UUID;
use App\Command\Arguments;
use App\Helper\ExceptionHandler;
use App\Command\CreateUserCommand;
use App\Repository\CommentRepository\SqliteCommentRepository;
use App\Repository\PostRepository\SqlitePostRepository;
use App\Repository\UserRepository\SqliteUserRepository;

require_once 'vendor/autoload.php';

set_exception_handler(function (\Throwable $e) {
    (new ExceptionHandler())->handle($e);
    exit;
});

$faker = Faker\Factory::create('ru_RU');

$connection = new PDO('sqlite:' . __DIR__ . '/db.sqlite');

$userRepository = new SqliteUserRepository($connection);
$postRepository = new SqlitePostRepository($connection, $userRepository);
$commentRepository = new SqliteCommentRepository($connection, $userRepository, $postRepository);

$command = new CreateUserCommand($userRepository);

try {
    // $command->handle(Arguments::parseRawInput($argv));

    $user = $userRepository->get(new UUID('32bdf424-b71a-40c5-b1ac-df8ee5f5dedd'));
    $post = $postRepository->get(new UUID('9df1ecd3-d99f-4516-906f-3b5016c2f1ef'));

    echo $commentRepository->get(new UUID('91456ede-11d0-4acb-96cd-e92871ab1c7e'));


} catch (\Throwable $e) {
    (new ExceptionHandler())->handle($e);
}