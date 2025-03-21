<?php

use App\Http\Actions\Comment\CreateComment;
use App\Http\Actions\Like\CreatePostLike;
use App\Http\Actions\Post\DeletePost;
use App\Http\Request;
use App\Http\ErrorResponse;
use App\Exception\HttpException;
use App\Exception\BaseAppException;
use App\Http\Actions\Post\CreatePost;
use App\Http\Actions\Post\FindByUuid;
use App\Http\Actions\User\CreateUser;
use App\Http\Actions\User\FindAllUsers;
use App\Http\Actions\User\FindByUsername;
use App\Repository\CommentRepository\SqliteCommentRepository;
use App\Repository\PostRepository\SqlitePostRepository;
use App\Repository\UserRepository\SqliteUserRepository;

header('Some-Header: header/text');

$container = require __DIR__ . '/bootstrap.php';

require_once 'functions.php';

$connection = new PDO('sqlite:' . __DIR__ . '/db.sqlite');
$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input')
);

try {
    $path = $request->getPath();
} catch (HttpException $e) {
    (new ErrorResponse)->send();
    return;
}

try {
    $method = $request->getMethod();
} catch (HttpException $e) {
    (new ErrorResponse)->send();
    return;
}

$routes = [
    'GET' => [
        "/users/show" => FindByUsername::class,
        "/users" => FindAllUsers::class,
        "/posts/show" => FindByUuid::class,
    ], 
    'POST' => [
        '/users/create' => CreateUser::class,
        "/posts/create" => CreatePost::class,
        "/posts/comment" => CreateComment::class,
        "/posts/like" => CreatePostLike::class
    ], 
    'DELETE' => [
        '/posts/delete' => DeletePost::class,
    ]
];

if (!array_key_exists($method, $routes)) {
    (new ErrorResponse('Метод не поддерживается'))->send();
    return;
}

if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse('Путь не найден'))->send();
    return;
}

$actionClassName = $routes[$method][$path];

$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
} catch (BaseAppException $e) {
    (new ErrorResponse($e->getMessage()))->send();
    return; 
}

$response->send();
