<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require 'db.php';

$data     = json_decode(file_get_contents("php://input"), true);
$email    = $conn->real_escape_string($data['email']);
$password = $conn->real_escape_string($data['password']);
$role     = strpos($email, '.teacher@') !== false ? 'teacher' : 'student';

$check = $conn->query("SELECT id FROM users WHERE email='$email'");
if ($check->num_rows > 0) {
    echo json_encode(["success" => true, "message" => "User exists"]);
    exit;
}

$sql = "INSERT INTO users (email, password, role) VALUES ('$email', '$password', '$role')";
echo $conn->query($sql)
    ? json_encode(["success" => true])
    : json_encode(["success" => false, "message" => "Could not save user"]);
?>