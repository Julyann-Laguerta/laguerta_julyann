<?php
$conn = new mysqli("localhost", "root", "", "mockdata");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id         = (int) $_POST['id'];
$fname = $conn->real_escape_string($_POST['first_name']);
$lname  = $conn->real_escape_string($_POST['last_name']);
$email      = $conn->real_escape_string($_POST['email']);

$sql = "UPDATE users SET 
            first_name = '$fname', 
            last_name = '$lname', 
            email = '$email' 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php?success=1");
    exit;
} else {
    echo "Error updating record: " . $conn->error;
}
