<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class AuthController
{
    public function __construct(private TemplateEngine $view, private ValidatorService $validatorService, private UserService $userService) {}

    public function registerView()
    {
        echo $this->view->render("register.php");
    }


    public function register()
    {
        $this->validatorService->validateRegister($_POST);

        $this->userService->isEmailTaken($_POST["email"]);
        $this->userService->createUser($_POST);

        reditectTo("/");
    }

    public function login()
    {
        $this->validatorService->validateLogin($_POST);

        $this->userService->login($_POST);

        reditectTo("/");
    }

    public function loginView()
    {
        echo $this->view->render("login.php");
    }

    public function logout()
    {
        $this->userService->logout();

        reditectTo("/login");
    }
}
