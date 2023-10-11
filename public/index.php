<?php

use BotSpireBackend\Route\Routes;
use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';
$settings = require __DIR__ . '/../config/settings.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    'settings' => $settings,
    PDO::class => function (ContainerInterface $container) {
        $dbSettings = $container->get('settings')['database'];
        $dsn = 'mysql:host=' . $dbSettings['DB_HOST'] . ';dbname=' . $dbSettings['DB_NAME'];
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, $dbSettings['DB_USER'], $dbSettings['DB_PASSWORD'], $options);
    }
]);
try {
    $container = $containerBuilder->build();
    $app = Bridge::create($container);
    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware(true, true, true);
    Routes::getRoutes($app);
    $app->run();
} catch (Exception $e) {
    print_r($e->getMessage());
}

