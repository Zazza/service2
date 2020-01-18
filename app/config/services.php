<?php

use Phalcon\Mvc\Dispatcher;

$di->setShared('config', $config);


$di->set('dispatcher', function () use ($di) {
    $eventsManager = $di->getShared('eventsManager');

    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Controllers');
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

$di->set('response', 'Phalcon\Http\Response');

$di->setShared('db', function () use ($config) {
    ini_set('phalcon.orm.cast_on_hydrate', 1);

    return new Phalcon\Db\Adapter\Pdo\Postgresql([
        'host'     => $config->db->host,
        'username' => $config->db->username,
        'password' => $config->db->password,
        'dbname'   => $config->db->dbname
    ]);
});
