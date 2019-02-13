<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$moduleNamespaces = [
        'Basic'                      => APP_PATH.'/basic',
        'Library'                    => APP_PATH.'/library',
        'Models'                     => APP_PATH.'/models',
        /************ 单模块时开启 start *************/
        'Controllers'                => APP_PATH.'/controllers',
        /************ 单模块时开启 end *************/
    ];

$loader->registerNamespaces($moduleNamespaces);
$loader->register();