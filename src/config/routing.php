<?php

use Apsl\Inf\Lab01\Controller\Error404Page;
use Apsl\Inf\Lab01\Controller\ContactPage;
use Apsl\Inf\Lab01\Controller\HomePage;
use Apsl\Inf\Zaliczenie\Controller\FormController;
use Apsl\Inf\Zaliczenie\Controller\NewPasswordController;
use Apsl\Inf\Zaliczenie\Controller\ResetPasswordController;


return [
    '/' => HomePage::class,
    '/contact' => ContactPage::class,
    '_404' => Error404Page::class,
    '/new-password' => NewPasswordController::class,
    '/reset-password' => ResetPasswordController::class,
    '/form' => FormController::class
];
