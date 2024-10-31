<?php

namespace Framework;

include_once __DIR__ . "/Router.php";

class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $containerDefinitionsPath = null)
    {
        $this->router = new Router();
        $this->container = new Container();

        if ($containerDefinitionsPath) {
            $containerDefinitions = include $containerDefinitionsPath;
            $this->container->addDefinition($containerDefinitions);
        }
    }

    public function run()
    {
        $path = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];

        $this->router->dispatch($path, $method, $this->container);
    }

    public function get(string $path, array $controller)
    {
        $this->router->add("GET", $path, $controller);
    }
}
