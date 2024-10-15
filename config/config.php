<?php

try {
    define("HOST","localhost");

    define("DBNAME","lux_inn");

    define("USER","root");

    define("PASS","");

    $conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME."", USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {

    echo $e->getMessage();

}
?>