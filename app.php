<?php

declare(strict_types= 1);

use App\Entity\Post\Post;
use App\Entity\User\User;
use App\Entity\Person\Name;
use App\Entity\Comment\Comment;

require_once 'vendor/autoload.php';
require_once 'functions.php';

$faker = Faker\Factory::create('ru_RU');

$name = new Name(
    $faker->firstName(),
    $faker->lastName(),
);

$user = new User(
    $faker->randomDigitNotNull(),
    $name,
    $faker->userName()
);

$cliRoute = $argv[1] ?? null;

switch ($cliRoute) {
    case 'user':
        echo $user;
        break;
    case 'post':
        $post = new Post(
            $faker->randomDigitNotNull(),
            $user,
            $faker->sentence(),
            $faker->paragraph()
        );

        echo $post;
        break;
    case 'comment':
        $post = new Post(
            $faker->randomDigitNotNull(),
            $user,
            $faker->sentence(),
            $faker->paragraph()
        );
        
        $comment = new Comment(
            $faker->randomDigitNotNull(),
            $user,
            $post,
            $faker->sentence(),
        );

        echo $comment;
        break;
    default:
        echo 'Ошибка. Попробуйте комманду user, post или comment';
}