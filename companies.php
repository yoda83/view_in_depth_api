<?php

$app->delete('/companies/{id}', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $beg1 = "
    UPDATE company
    SET alive_ind = 0 WHERE company_id = ";

    $query = $beg1 . $id;

    $result = pg_query($query);

    /* RETURN Result to Client */

    $query = "SELECT company_name || ' was successfully deleted.' AS message FROM company WHERE company_id = " . $id . ";";

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



$app->patch('/companies/{id}', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $beg1 = "
    UPDATE company
    SET ";

    $comma = "";

    $json = $request->getParsedBody();
    foreach($json as $key => $param){
        $beg1 = $beg1 . $comma . $key . " = " . "'" . $param . "'";
        $comma = ", ";
    }

    $beg2 = " WHERE company_id = ";

    $end = ";";

    $query = $beg1 . $beg2 . $id . $end;

    $result = pg_query($query);

    
    /* RETURN Result to Client */
    
    $query = "SELECT * FROM company WHERE company_id = " . $id . ";";

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



$app->post('/companies', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

    $beg1 = "
    INSERT INTO company
    (";

    $fields = "";
    $comma = "";

    $json = $request->getParsedBody();
    foreach($json as $key => $param){
	$beg1 = $beg1 . $comma . $key;
	$fields = $fields . $comma . "'" . $param . "'";
	$comma = ", ";
    }

    $beg2 = ") VALUES (";

    // $end = ");"; /* O.G. */
    $end = ") RETURNING company_id;";       /* new */

    $query = $beg1 . $beg2 . $fields . $end;

    // $result = pg_query($query); /* O.G. */
    $stmt = pg_query($query);
    $result = pg_fetch_row($stmt); /* new */
    $id = $result[0]; /* new */

    /* RETURN Result to Client */

    $query = "SELECT * FROM company WHERE company_id = " . $id . ";";

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



$app->get('/companies', function()
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());


    $query = "SELECT * FROM company WHERE alive_ind = 1;";

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
              AND c.alive_ind = 1
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
              AND c.alive_ind = 1
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

	select row_to_json(t)
 from (
  select company_id, company_name, company_street, company_city, company_state, company_zip, active_ind,
    (
      select array_to_json(array_agg(row_to_json(d)))
      from (
        select ct.contact_id, ct.contact_lname, ct.contact_fname, ct.contact_email, ct.active_ind
        from contact ct
        where ct.company_id = c.company_id
        order by ct.contact_lname
      ) d
    ) as contacts

    , (
      select array_to_json(array_agg(row_to_json(d)))
      from (
        select p.pic_id, p.pic_location, p.active_ind
        from pic p
        where p.company_id = c.company_id
        and p.active_ind = 1
        order by p.pic_id
      ) d
    ) as pics
  from company c

        WHERE c.alive_ind = 1 AND c.company_id = " . $id . "
 ) t
;";


    $result = pg_query($db, $query);

    while($row = pg_fetch_assoc($result))
    {
        $data[] = $row;
    }

    if(isset($data))
    {
        header('Content-Type: application/json');
        // $yourEscapedJsonString = json_encode($data);
        // $yourEscapedJsonString = $data;
        $noSlashes = str_replace("\\","",$data);
        $hope = array_values($noSlashes[0]);
        foreach($hope as $key => $value)
        {
              print $value;
        }
    }
});

