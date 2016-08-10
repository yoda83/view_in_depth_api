<?php

$app->delete('/pics/{id}', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $beg1 = "
    UPDATE pic
    SET alive_ind = 0 WHERE pic_id = ";

    $query = $beg1 . $id;

    $result = pg_query($query);


    /* RETURN Result to Client */

    $query = "SELECT pic_location || ' was successfully deleted.' AS message FROM pic WHERE pic_id = " . $id;

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



$app->patch('/pics/{id}', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');

    $beg1 = "
    UPDATE pic
    SET ";

    $comma = "";

    $json = $request->getParsedBody();
    foreach($json as $key => $param){
        $beg1 = $beg1 . $comma . $key . " = " . "'" . $param . "'";
        $comma = ", ";
    }

    $beg2 = " WHERE pic_id = ";

    $end = ";";

    $query = $beg1 . $beg2 . $id . $end;

    $result = pg_query($query);


    /* RETURN Result to Client */

    $query = "SELECT * FROM pic WHERE pic_id = " . $id . ";";

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



$app->post('/pics', function($request, $response, $args)
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

/* BEG : UPLOAD FILE */

/* END : UPLOAD FILE */


    $beg1 = "
    INSERT INTO pic
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
        $end = ") RETURNING pic_id;";       /* new */

        $query = $beg1 . $beg2 . $fields . $end;

        // $result = pg_query($query); /* O.G. */
        $stmt = pg_query($query); /* new */
        $result = pg_fetch_row($stmt); /* new */
        $id = $result[0]; /* new */


                  /* BEG : Update PIC with file URL */

                  /* END : Update PIC with file URL */

        /* RETURN Result to Client */

        $query = "SELECT * FROM pic WHERE pic_id = " . $id . ";";


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



$app->get('/pics', function()
{

$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
// $db = pg_connect($host, $user, $dbname);
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
              or die('Could not connect: ' . pg_last_error());

//    require_once('dbconnect.php');

    $query = "SELECT * FROM pic WHERE alive_ind = 1;";

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



$app->get('/pics/{id}', function($request)
{ 
$host = "localhost";
$user = "postgres";
$pass = "";
$dbname = "fullstacker";
$db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());

    $id = $request->getAttribute('id');
    
    // echo "UserID is : " . $userid;

    $query = "SELECT * FROM pic WHERE alive_ind = 1 AND pic_id = " . $id . " LIMIT 1";
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

