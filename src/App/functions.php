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


function redirectTo(string $path)
{
    header("Location: {$path}");
    http_response_code(302);
    exit;
}
