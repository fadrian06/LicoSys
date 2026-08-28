<?php

declare(strict_types=1);

use App\Http\Controllers\IndexController;
use App\Http\Middleware\CleanCarts;
use App\Http\Middleware\CreateDbIfNotExists;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\ShowAdminRegisterIfThereIsNoOneAdmin;
use App\Http\Middleware\ShowBusinessRegisterIfThereIsNoOneActiveBusiness;
use App\Http\Middleware\ShowRestoreDbToastIfThereIsOneBackup;
use App\Http\Middleware\ShowSecretQuestionsRegisterIfAdminHasNot;
use App\Route;

return [
  new Route(
    methods: ['GET'],
    pattern: '/',
    handler: IndexController::class,
    middlewares: [
      CreateDbIfNotExists::class,
      RedirectIfAuthenticated::class,
      CleanCarts::class,
      ShowRestoreDbToastIfThereIsOneBackup::class,
      ShowBusinessRegisterIfThereIsNoOneActiveBusiness::class,
      ShowAdminRegisterIfThereIsNoOneAdmin::class,
      ShowSecretQuestionsRegisterIfAdminHasNot::class,
    ],
  ),
];
