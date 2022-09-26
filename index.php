<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
// Monolog Example
$logger = new Logger('app');
$streamHandler = new StreamHandler(__DIR__ . '/logs/debug.log', 100);
$logger->pushHandler($streamHandler);

// Add Error Middleware with Logger
$errorMiddleware = $app->addErrorMiddleware(true, true, true, $logger);
$app->addRoutingMiddleware();

require __DIR__ . "/src/Routes/Routes.php";
session_start();
$app->run();
