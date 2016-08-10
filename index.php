<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

require_once('companies.php');
require_once('contacts.php');
require_once('pics.php');
require_once('picsTEST.php');

$app->run();
