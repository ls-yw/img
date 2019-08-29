<?php
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Library\Log;
use Phalcon\Loader;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/application');
define('APP_NAME', 'img');
date_default_timezone_set('Asia/Shanghai');

require __DIR__ . '/../vendor/autoload.php';

$di = new FactoryDefault();

/**
 * Read services
 */
include APP_PATH . '/config/services.php';

/**
 * Include Autoloader
 */
include APP_PATH . '/config/loader.php';

Log::setTriggerError();


// 创建应用
$application = new Application($di);

/************ 多模块时开启 start *************/
// 注册模块
// $application->registerModules($config->application->modules->toArray());
/************ 多模块时开启 end *************/
try{
    // 处理请求
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo '系统错误，请联系管理员';
    Log::write('system', $e->getMessage().'|'.$e->getFile().'|'.$e->getLine());
}