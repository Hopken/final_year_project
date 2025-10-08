<?php
session_start();
require_once('dbconnect.php');
require_once('timezone.php'); // Includes the database connection script

// Create the task table if it doesn't exist
$conn->exec("
    CREATE TABLE IF NOT EXISTS task (
        id INT AUTO_INCREMENT PRIMARY KEY,
        task VARCHAR(255) NOT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Add a new task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_task'])) {
    $newTask = htmlspecialchars($_POST['new_task']);
    $stmt = $conn->prepare("INSERT INTO task (task, status) VALUES (?, 'pending')");
    $stmt->execute([$newTask]);
    header("Location: task.php");
    exit;
}

// Update task status
if (isset($_GET['action']) && isset($_GET['id'])) {
    $taskId = intval($_GET['id']);
    if ($_GET['action'] == 'check') {
        $stmt = $conn->prepare("UPDATE task SET status = 'done' WHERE id = ?");
        $stmt->execute([$taskId]);
    } elseif ($_GET['action'] == 'delete') {
        $stmt = $conn->prepare("DELETE FROM task WHERE id = ?");
        $stmt->execute([$taskId]);
    }
    header("Location: task.php");
    exit;
}

// Fetch tasks from the database
$stmt = $conn->prepare("SELECT * FROM task ORDER BY id DESC");
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <title>Task-Board</title>
		<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
		<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
		<link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
		<link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
		<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
		<link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
		<link href="./css/style.css" rel="stylesheet">
		</head>
<body>
    <?php include("nav.php") ?>
    <div class="container mt-5">
        <h1 class="text-center">Task Manager</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Tasks To Be Done
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Task</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks as $task): ?>
                                    <?php if ($task['status'] == 'pending'): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($task['task']) ?></td>
                                            <td><?= htmlspecialchars($task['status']) ?></td>
                                            <td>
                                                <a href="task.php?action=check&id=<?= $task['id'] ?>" class="btn btn-success btn-sm">Check</a>
                                                <a href="task.php?action=delete&id=<?= $task['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Completed Tasks
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Task</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks as $task): ?>
                                    <?php if ($task['status'] == 'done'): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($task['task']) ?></td>
                                            <td><?= htmlspecialchars($task['status']) ?></td>
                                            <td>
                                                <a href="task.php?action=delete&id=<?= $task['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form method="post" action="task.php" class="mt-3">
                    <div class="input-group">
                        <input type="text" name="new_task" class="form-control" placeholder="New Task" required>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn = null;
?>
