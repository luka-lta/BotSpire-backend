<?php
declare(strict_types=1);

namespace BotSpireBackend\Route;

use BotSpireBackend\Controller\CheckController;
use BotSpireBackend\Controller\LoginController;
use BotSpireBackend\Controller\RegisterController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Routes
{
    public static function getRoutes(App $app): void
    {
        $app->group('/api', function (RouteCollectorProxy $group) {
           $group->put('/register', [RegisterController::class, 'controllRegisterRoute']);
           $group->post('/login', [LoginController::class, 'controllLoginRoute']);
           $group->get('/check', [CheckController::class, 'controllCheckRoute']);
        });
    }
}