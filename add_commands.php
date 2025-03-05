<?php
// Database Connection
$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'nmap_keeper';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = trim($_POST['command']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);

    if (!empty($command) && !empty($description) && !empty($category)) {
        $stmt = $conn->prepare("INSERT INTO nmap_commands (command, description, category) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $command, $description, $category);
        
        if ($stmt->execute()) {
            $success_message = "Command added successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "All fields are required!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Nmap Command</title>
    <link rel="stylesheet" href="assets/bootstrap-5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Nmap Keeper <img width="30" height="30" src="nmap-logo-256x256.png"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_commands.php">Add Commands</a></li>
                    <li class="nav-item"><a class="nav-link" href="#favorites">Favorites</a></li>
                    <li class="nav-item">
                        <button class="btn btn-secondary" id="dark-mode-toggle">Dark Mode</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Add Nmap Command <img src="nmap-logo-256x256.png" width="40" height="30"> </h2>
        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success"> <?= $success_message; ?> </div>
        <?php elseif (isset($error_message)) : ?>
            <div class="alert alert-danger"> <?= $error_message; ?> </div>
        <?php endif; ?>
        <form method="POST" class="card p-4">
            <div class="mb-3">
                <label class="form-label">Command</label>
                <input type="text" name="command" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Command</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
