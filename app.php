<?php

declare(strict_types= 1);

use App\Entity\User\User;
use App\Entity\Person\Name;

require_once 'vendor/autoload.php';
require_once 'functions.php';

$name = new Name('Alexey', 'Barinulka');
$user = new User(1, $name, 'login');


dump($user);
