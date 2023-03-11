<?php

function OpenCon()
{
    $dbhost = getenv("DB_HOST");
    $dbuser = getenv("DB_USER");
    $dbpass = getenv("DB_PASS");
    $conn = getenv("DB_CONN");
    ($db = new mysqli($dbhost, $dbuser, $dbpass, $conn)) or
        die("Connect failed: %s\n" . $db->error);

    return $db;
}

function CloseCon($db)
{
    $db->close();
}
