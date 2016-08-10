<?php
$app->get('/companies', function()
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());


    $query = "SELECT * FROM company;";

    $result = pg_query($db, $query);

    while($row = pg_fetch_assoc($result))
    {
	$data[] = $row;
    }

    if(isset($data))
    {
	header('Content-Type: application/json');
	echo json_encode($data);
    }

});




$app->get('/companies/{id}/contacts', function($request)
{
$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $query = "SELECT
                ct.contact_id
                , c.company_id
                , c.company_name
                , ct.contact_lname AS last_name
                , ct.contact_fname AS first_name
                , ct.contact_email AS email
                , ct.active_ind
              FROM company c
              INNER JOIN contact ct
              ON  ct.company_id = c.company_id
              AND ct.active_ind = 1
              WHERE c.company_id = " . $id;
    $result = pg_query($db, $query);

    while($row = pg_fetch_assoc($result))
    {
        $data[] = $row;
    }

    if(isset($data))
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
});



$app->get('/companies/{id}/pics', function($request)
{
$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $query = "SELECT
                p.pic_id
                , c.company_id
                , c.company_name
                , p.pic_location AS location
                , p.active_ind
              FROM company c
              INNER JOIN pic p
              ON  p.company_id = c.company_id
              AND p.active_ind = 1
              WHERE c.company_id = " . $id;
    $result = pg_query($db, $query);

    while($row = pg_fetch_assoc($result))
    {
        $data[] = $row;
    }

    if(isset($data))
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
});



$app->get('/companies/{id}', function($request)
{
$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $query = "

	DROP TYPE IF EXISTS contact_agg;

	CREATE TYPE contact_agg AS (id int, fname text, lname text, email text, active_ind int, company_id int);

	DROP TABLE IF EXISTS contact_tmp;

	CREATE TEMP TABLE contact_tmp AS

	SELECT DISTINCT

	ct.company_id
	, array_agg( CAST(row(ct.contact_id, ct.contact_fname, ct.contact_lname, ct.contact_email, ct.active_ind, ct.company_id) AS contact_agg) ) AS contacts

	FROM contact ct
	WHERE ct.company_id = " . $id . "
	AND   ct.active_ind = 1
	GROUP BY ct.company_id
	;


	DROP TYPE IF EXISTS pic_agg;

	CREATE TYPE pic_agg AS (id int, location text, active_ind int, company_id int);

	DROP TABLE IF EXISTS pic_tmp;

	CREATE TEMP TABLE pic_tmp AS

	SELECT DISTINCT

	p.company_id
	, array_agg( CAST(row(p.pic_id, p.pic_location, p.active_ind, p.company_id) AS pic_agg) ) AS pics

	FROM pic p
	WHERE p.company_id = " . $id . "
	AND   p.active_ind = 1
	GROUP BY p.company_id
	;


        SELECT
        c.*
        , array_to_json(ct.contacts) AS contacts
        , array_to_json(p.pics) AS pics

        FROM company c

        LEFT JOIN contact_tmp ct
        ON ct.company_id = c.company_id

        LEFT JOIN pic_tmp p
        ON p.company_id = c.company_id

        WHERE c.company_id = " . $id;


    $result = pg_query($db, $query);

    while($row = pg_fetch_assoc($result))
    {
        $data[] = $row;
    }

    if(isset($data))
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
});

