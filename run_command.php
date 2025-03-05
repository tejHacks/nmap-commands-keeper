<?php
// Security: Disable error display in production
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: text/plain'); // Ensure plain text response

// Check if the request is POST and contains 'command'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['command'])) {
    $command = escapeshellarg($_POST['command']); // Secure input

    // Execute the Bash script instead of running nmap directly
    $output = shell_exec("bash run_nmap.sh $command 2>&1");

    echo nl2br(htmlspecialchars($output)); // Return the output safely
} else {
    echo "Invalid request!";
}
?>
