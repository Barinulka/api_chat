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