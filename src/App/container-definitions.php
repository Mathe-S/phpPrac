<?php

declare(strict_types=1);

use App\Config\Paths;
use App\Services\ReceiptService;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\Container;
use Framework\Database;
use Framework\TemplateEngine;

return [
    TemplateEngine::class => fn() => new TemplateEngine(Paths::VIEW),
    ValidatorService::class => fn() => new ValidatorService(),
    Database::class => fn() => new Database($_ENV["DB_DRIVER"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]),
    UserService::class => fn(Container $container) => new UserService($container->get(Database::class)),
    TransactionService::class => fn(Container $container) => new TransactionService($container->get(Database::class)),
    ReceiptService::class => fn(Container $container) => new ReceiptService($container->get(Database::class)),
];
