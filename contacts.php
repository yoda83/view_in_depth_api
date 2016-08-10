<?php

$app->delete('/contacts/{id}', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $beg1 = "
    UPDATE contact
    SET alive_ind = 0 WHERE contact_id = ";

    $query = $beg1 . $id;

    $result = pg_query($query);


    /* RETURN Result to Client */

    $query = "SELECT contact_fname || ' ' || contact_lname || ' was successfully deleted.' AS message FROM contact WHERE contact_id = " . $id . ";";

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



$app->patch('/contacts/{id}', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $beg1 = "
    UPDATE contact
    SET ";

    $comma = "";

    $json = $request->getParsedBody();
    foreach($json as $key => $param){
        $beg1 = $beg1 . $comma . $key . " = " . "'" . $param . "'";
        $comma = ", ";
    }

    $beg2 = " WHERE contact_id = ";

    $end = ";";

    $query = $beg1 . $beg2 . $id . $end;

    $result = pg_query($query);


    /* RETURN Result to Client */

    $query = "SELECT * FROM contact WHERE contact_id = " . $id . ";";

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



$app->post('/contacts', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

    $beg1 = "
    INSERT INTO contact
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
    $end = ") RETURNING contact_id;";       /* new */

    $query = $beg1 . $beg2 . $fields . $end;

    // $result = pg_query($query); /* O.G. */
    $stmt = pg_query($query); /* new */
    $result = pg_fetch_row($stmt); /* new */
    $id = $result[0]; /* new */

    /* RETURN Result to Client */

    $query = "SELECT * FROM contact WHERE contact_id = " . $id . ";";

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



$app->get('/contacts', function()
{   

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
// $db = pg_connect($host, $user, $dbname);
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

//    require_once('dbconnect.php');
    
    $query = "SELECT * FROM contact WHERE alive_ind = 1;";

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



$app->get('/contacts/{id}', function($request)
{ 
$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');
    
    // echo "UserID is : " . $userid;

    $query = "SELECT * FROM contact WHERE alive_ind = 1 AND contact_id = " . $id . " LIMIT 1";
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

