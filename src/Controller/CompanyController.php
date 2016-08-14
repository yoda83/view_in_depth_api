<?php

namespace VueInDepth\Controller;

use Illuminate\Database\Query\Builder;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use VueInDepth\Model\Company;

class CompanyController
{
    protected $table;

    public function __construct(Builder $table)
    {
        $this->table = $table;
    }

    public function index(Request $request, Response $response, $args)
    {
        $companies = $this->table->get();

        return $response->withJson($companies);
    }

    public function show(Request $request, Response $response, $args)
    {
        $company = $this->table->find($args['id']);

        return $response->withJson($company);
    }

    public function create(Request $request, Response $response, $args)
    {
        $postData = $request->getParsedBody();

        $company = new Company();
        $company->name = 'Test Company';
        $company->street = 'Test St';
        $company->city = 'Test City';
        $company->state = 'MO';
        $company->zip = '63376';
        $company->active_ind = 0;
        $company->alive_ind = 1;

        $company->save();

        return $response->withStatus(201, 'Created');
    }

    public function update(Request $request, Response $response, $args)
    {
        return $response->withStatus(405, 'Method Not Implemented');
    }

    public function delete(Request $request, Response $response, $args)
    {
        return $response->withStatus(405, 'Method Not Implemented');
    }
}