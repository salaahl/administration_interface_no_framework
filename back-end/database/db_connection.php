<?php

function OpenCon()
{
    if ($_SERVER["SERVER_NAME"] == "localhost") {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $conn = "ECF-2.0";
        ($db = new mysqli($dbhost, $dbuser, $dbpass, $conn)) or
            die("Connect failed: %s\n" . $db->error);

        return $db;
    } else {
        $dbhost = "j5zntocs2dn6c3fj.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
        $dbuser = "vpk8227nz3b524if";
        $dbpass = "djeyefmr9yqydz28";
        $conn = "kscazh2duxaig5hi";
        ($db = new mysqli($dbhost, $dbuser, $dbpass, $conn)) or
            die("Connect failed: %s\n" . $db->error);

        return $db;
    }
}

function CloseCon($db)
{
    $db->close();
}
