<?php

use App\Exception\BaseAppException;
use App\Exception\HttpException;
use App\Http\Actions\User\CreateUsers;
use App\Http\Actions\User\FindByUsername;
use App\Http\Request;
use App\Http\ErrorResponse;
use App\Repository\UserRepository\SqliteUserRepository;

header('Some-Header: header/text');

require_once 'vendor/autoload.php';
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
        "/users/show" => new FindByUsername(
            new SqliteUserRepository($connection)
        ),
    ], 
    'POST' => [
        '/users/create' => new CreateUsers(
            new SqliteUserRepository($connection)
        )
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

$action = $routes[$method][$path];

try {
    $response = $action->handle($request);
} catch (BaseAppException $e) {
    (new ErrorResponse($e->getMessage()))->send();
    return; 
}

$response->send();
