<?php

$router = $di->getRouter();

// $router->add('/([\w]*)/?([\w]*)/?([\w]*)(/.*)*',['module'=>1,'controller' => 2,'action' => 3,'params'=>4]);
$router->add(
    "/:module/:controller/:action/:params",
    [
        "module"     => 1,
        "controller" => 2,
        "action"     => 3,
        "params"     => 4,
    ]
    );

$router->setDefaultModule("index");

$router->handle();
