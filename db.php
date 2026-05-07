<?php
$host = "localhost";
$dbname = "cmru_portal";
$username = "root";
$password = "";  // XAMPP default has no password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB connection failed"]));
}
?>