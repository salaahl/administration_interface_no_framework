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
        $dbhost = "f80b6byii2vwv8cx.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
        $dbuser = "oetcwb50h4tlvms9";
        $dbpass = "a0fcpccauuoj2vk9";
        $conn = "hrp3ccgxjq3oxaiz";
        ($db = new mysqli($dbhost, $dbuser, $dbpass, $conn)) or
            die("Connect failed: %s\n" . $db->error);

        return $db;
    }
}

function CloseCon($db)
{
    $db->close();
}
