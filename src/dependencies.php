<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use VueInDepth\Controller\CompanyController;

$container = $app->getContainer();

$container['db'] = function ($c) {
    $capsule = new Capsule;
    $capsule->addConnection([
        'driver' => 'pgsql',
        'host' => DB_HOST,
        'port' => DB_PORT,
        'database' => DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASSWORD,
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci'
    ], 'default');

    $capsule->bootEloquent();
    $capsule->setAsGlobal();

    return $capsule;
};

$resolver = new Illuminate\Database\ConnectionResolver();
$resolver->addConnection('default', $container->get('db')->getConnection('default'));
$resolver->setDefaultConnection('default');
\Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);


$container[VueInDepth\Controller\CompanyController::class] = function ($c) {
    $table = $c->get('db')->table('companies');
    return new CompanyController($table);
};
