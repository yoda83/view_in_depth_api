<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response) { 
   echo 'Homepage....';
});

$app->get('/companies', function (Request $request, Response $response) {
    echo 'Companies - All';
});


$app->get('/companies/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $response->getBody()->write("Company ID : $id");

    return $response;
});


$app->get('/companies/{id}/contacts', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $response->getBody()->write("Contacts for Company ID : $id");

    return $response;
});


$app->get('/companies/{id}/pics', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $response->getBody()->write("Pics for Company ID : $id");

    return $response;
});

$app->run();


// echo "Damn.....";
