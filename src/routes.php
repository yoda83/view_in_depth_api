<?php

$app->get('/companies', 'VueInDepth\Controller\CompanyController:index');
$app->get('/companies/{id}', 'VueInDepth\Controller\CompanyController:show');
$app->post('/companies', 'VueInDepth\Controller\CompanyController:create');
$app->patch('/companies/{id}', 'VueInDepth\Controller\CompanyController:update');
$app->delete('/companies/{id}', 'VueInDepth\Controller\CompanyController:delete');

$app->get('/companies/{id}/contacts', 'VueInDepth\Controller\ContactsController:index');

$app->get('/companies/{id}/pics', 'VueInDepth\Controller\PicsController:index');

$app->get('/faker-test', function($request, $response, $args) {
    $faker = Faker\Factory::create();

    $data = [
        'name' => $faker->company,
        'street' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode,
    ];

    return $response->withJson($data);
});