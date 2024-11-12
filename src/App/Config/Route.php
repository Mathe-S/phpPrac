<?php

declare(strict_types=1);

namespace App\Config;

use App\Controllers\{HomeController, AboutController, AuthController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};
use Framework\App;

function registerRoutes(App $app)
{
    $app->get("/", [HomeController::class, "home"])->addRouteMiddleware(AuthRequiredMiddleware::class);
    $app->get("/about", [AboutController::class, "about"]);
    $app->get("/register", [AuthController::class, "registerView"])->addRouteMiddleware(GuestOnlyMiddleware::class);
    $app->post("/register", [AuthController::class, "register"])->addRouteMiddleware(GuestOnlyMiddleware::class);
    $app->get("/login", [AuthController::class, "loginView"])->addRouteMiddleware(GuestOnlyMiddleware::class);
    $app->post("/login", [AuthController::class, "login"])->addRouteMiddleware(GuestOnlyMiddleware::class);
    $app->get("/logout", [AuthController::class, "logout"])->addRouteMiddleware(AuthRequiredMiddleware::class);
}
