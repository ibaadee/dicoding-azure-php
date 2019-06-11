<?php
    //Handle connection configuration to DB
    $host = "ibaddb.database.windows.net";
    $user = "ibad";
    $pass = "password123#";
    $db = "ibaddb";
    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }
?>