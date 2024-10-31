<?php

declare(strict_types=1);

function dd(mixed $val)
{
    echo "<pre>";
    var_dump($val);
    echo "</pre>";
    die();
}

function deDanger(mixed $data)
{
    return htmlspecialchars((string) $data);
}
