<?php
// Security: Disable error display in production
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: text/plain'); // Ensure plain text response

// Allow only specific commands (Whitelisting)
$allowedCommands = ['nmap', 'ping', 'traceroute', 'whois', 'dig', 'nslookup'];

// Debugging: Log incoming request method and data
file_put_contents("debug.log", "Request Method: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
file_put_contents("debug.log", "POST Data: " . print_r($_POST, true) . "\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['command'])) {
    $command = escapeshellcmd($_POST['command']); // Escape shell arguments

    // Extract the base command (first word)
    $baseCommand = explode(' ', trim($command))[0];

    // Ensure it's an allowed command
    if (!in_array($baseCommand, $allowedCommands)) {
        echo "Error: Command not allowed!";
        exit;
    }

    // **Fix 1: Preload system's libstdc++.so.6 to prevent XAMPP conflicts**
    $preload = 'LD_PRELOAD=/usr/lib/x86_64-linux-gnu/libstdc++.so.6';
    $fullCommand = "$preload $command 2>&1"; 

    // Execute the command safely
    $output = shell_exec($fullCommand);

    // Debugging: Log the executed command and output
    file_put_contents("debug.log", "Executed Command: " . $fullCommand . "\nOutput:\n" . $output . "\n", FILE_APPEND);

    // Return the output
    echo nl2br(htmlspecialchars($output)); // Prevent XSS
} else {
    echo "Invalid request!";
}
?>
