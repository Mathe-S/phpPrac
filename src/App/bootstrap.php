<?php

declare(strict_types=1);

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . "/../../vendor/autoload.php";

use App\Config\Paths;
use Framework\App;
use function App\Config\{registerRoutes, registerMiddleware};


$app = new App(Paths::SOURCE . "App/container-definitions.php");

registerRoutes($app);
registerMiddleware($app);

return $app;
