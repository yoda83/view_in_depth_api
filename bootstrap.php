<?php

require 'vendor/autoload.php';
require 'config/local.config.php';

$app = new \Slim\App;

require 'src/dependencies.php';
require 'src/routes.php';

$app->run();