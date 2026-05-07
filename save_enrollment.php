<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$email   = $conn->real_escape_string($data['email']);
$course  = $conn->real_escape_string($data['course']);
$subject = $conn->real_escape_string($data['subject']);
$sem     = intval($data['sem']);

// Avoid duplicate enrollment
$check = $conn->query("SELECT id FROM enrollments WHERE student_email='$email' AND subject='$subject' AND semester=$sem");
if ($check->num_rows > 0) {
    echo json_encode(["success" => true, "message" => "Already enrolled"]);
    exit;
}

$sql = "INSERT INTO enrollments (student_email, course, subject, semester) VALUES ('$email', '$course', '$subject', $sem)";
if ($conn->query($sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Enrollment failed"]);
}
?>