<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'nmap_keeper';
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $command = $conn->real_escape_string($_POST['command']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);

    $sql = "UPDATE nmap_commands SET command='$command', description='$description', category='$category' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Command updated successfully!";
    } else {
        echo "Error updating command: " . $conn->error;
    }
}

$conn->close();
?>
