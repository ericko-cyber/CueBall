<?php

// $host = "localhost";
// $dbname = "db_futsal";
// $username = "root";
// $password = "";

$host = "localhost";
$dbname = "cueballm_billiard";
$username = "cueballm_billiard";
$password = "cueballmifak4";


// $host = "mifa.myhost.id";
// $dbname = "mifamyho_cueball";
// $username = "mifamyho_cueball";
// $password = "WSImif2023";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;