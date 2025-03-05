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

// Fetch Commands
$sql = "SELECT * FROM nmap_commands";
$result = $conn->query($sql);

$commands = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $commands[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nmap Commands Keeper</title>
    <link rel="stylesheet" href="assets/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
  
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
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_commands.php">Add Commands</a></li>
                    <li class="nav-item"><a class="nav-link" href="#favorites">Favorites</a></li>
                    <li class="nav-item">
                        <button class="btn btn-secondary" id="dark-mode-toggle">Dark Mode</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <input type="text" id="search-bar" class="form-control" placeholder="Search Nmap Commands...">
    </div>

    <div class="container mt-4">
        <div class="row" id="commands-container">
            <?php foreach ($commands as $command): ?>
                <div class="col-md-4 mb-4 command-card" data-category="<?= htmlspecialchars($command['category']) ?>">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-terminal me-2"></i> <?= htmlspecialchars($command['category']) ?></h5>
                            <p><strong>Command:</strong> <code><?= htmlspecialchars($command['command']) ?></code></p>
                            <p><strong>Description:</strong> <?= htmlspecialchars($command['description']) ?></p>
                            <button class="btn btn-primary btn-sm copy-btn" data-command="<?= htmlspecialchars($command['command']) ?>">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                            <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $command['id'] ?>" data-command="<?= htmlspecialchars($command['command']) ?>" data-description="<?= htmlspecialchars($command['description']) ?>" data-category="<?= htmlspecialchars($command['category']) ?>">
    <i class="fa fa-edit"></i> Edit
</button>
                            <button class="btn btn-success btn-sm run-btn" data-command="<?= htmlspecialchars($command['command']) ?>">
                                <i class="fa fa-play"></i> Run
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



    <!-- Edit Command Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Nmap Command</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label>Category</label>
                        <input type="text" class="form-control" id="edit-category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label>Command</label>
                        <input type="text" class="form-control" id="edit-command" name="command" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea class="form-control" id="edit-description" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Command</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('edit-id').value = button.getAttribute('data-id');
            document.getElementById('edit-command').value = button.getAttribute('data-command');
            document.getElementById('edit-description').value = button.getAttribute('data-description');
            document.getElementById('edit-category').value = button.getAttribute('data-category');

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    });

    document.getElementById('edit-form').addEventListener('submit', (e) => {
        e.preventDefault();
        let formData = new FormData(e.target);

        fetch('edit_command.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>


    <footer class="bg-dark text-white py-3 mt-4">
        <div class="container text-center">
            <p>© 2025 Nmap Commands Keeper <img src="nmap-logo-256x256.png" width="40" height="30"> | Built with ❤ by TejTheDev</p>
        </div>
    </footer>

    <script src="assets/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', () => {
                    navigator.clipboard.writeText(button.getAttribute('data-command'));
                    alert('Command copied!');
                });
            });

            document.querySelectorAll('.run-btn').forEach(button => {
                button.addEventListener('click', () => {
                    let command = button.getAttribute('data-command');

                    console.log("Sending command:", command); // Debugging log

                    fetch('run_command.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'command=' + encodeURIComponent(command)
                    })
                    .then(response => response.text())
                    .then(result => {
                        console.log("Server response:", result); // Debugging log
                        alert('Command Output:\n' + result);
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

    <style>
        .run-btn {
            background-color: #28a745; /* Green color */
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .run-btn:hover {
            background-color: #218838; /* Darker green */
        }
    </style>
</body>
</html>
