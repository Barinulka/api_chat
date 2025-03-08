<?php 

function dd(mixed $mixed, bool $stop = false): void
{
    echo "<pre>";
    print_r($mixed);
    echo "</pre>";

    if (true === $stop) {
        die("");
    }
}

function dump(mixed $data): void
{
    echo $data . PHP_EOL;
}