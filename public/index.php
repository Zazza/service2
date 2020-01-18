<?php
use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../app/config/config.php";
    $configS = new \Phalcon\Config\Adapter\Ini(__DIR__."/../app/config/config.ini");
    $config->merge($configS);

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    $dispatcher = $di->getShared('dispatcher');
    $api = new \App\JsonRPC\Api($dispatcher);
    $server = new \Datto\JsonRpc\Server($api);

    $request = new \Phalcon\Http\Request();
    $data = $request->getRawBody();

    $resultContent = $server->reply($data);

    $response = $di->getShared('response');
    $response->setContent($resultContent);
    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
