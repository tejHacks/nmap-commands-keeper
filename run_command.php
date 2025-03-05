<?php
// Include database connection
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the command from the database
    $stmt = $conn->prepare("SELECT command FROM nmap_commands WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($command);
    $stmt->fetch();
    $stmt->close();

    if ($command) {
        // Execute the command and capture output
        $output = shell_exec($command . " 2>&1");

        // Store output in command_logs table
        $stmt = $conn->prepare("INSERT INTO command_logs (command_id, output) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $output);
        $stmt->execute();
        $stmt->close();

        // Display output
        echo "<pre>$output</pre>";
    } else {
        echo "Command not found!";
    }
} else {
    echo "No command ID provided!";
}
?>
