<?php 

use App\Container\DIContainer;
use App\Repository\PostRepository\SqlitePostRepository;
use App\Repository\UserRepository\SqliteUserRepository;
use App\Repository\PostRepository\PostRepositoryInterface;
use App\Repository\UserRepository\UserRepositoryInterface;
use App\Repository\CommentRepository\SqliteCommentRepository;
use App\Repository\CommentRepository\CommentRepositoryInterface;

require_once 'vendor/autoload.php';

$container = new DIContainer();

$container->bind(
    PDO::class,
    new PDO('sqlite:' . __DIR__ . '/db.sqlite')
);

$container->bind(
    UserRepositoryInterface::class,
    SqliteUserRepository::class
);

$container->bind(
    PostRepositoryInterface::class,
    SqlitePostRepository::class
);

$container->bind(
    CommentRepositoryInterface::class,
    SqliteCommentRepository::class
);

return $container; 