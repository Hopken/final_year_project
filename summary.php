<?php 
session_start();
require_once('dbconnect.php'); // Includes the database connection script

if(empty($_SESSION["user"])){
    header("location: index.php"); // Redirects to index.php if the user session is not set
    exit;
}

// Fetch attendance data from the database
$sql = "SELECT name, timestamp, latitude, longitude, status FROM attendance";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check for query execution errors
if ($result === false) {
    die("Error: " . $conn->errorInfo()[2]); // If the query fails, display an error message and stop execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Summary</title>
    <!-- CSS files for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">
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
    <?php include("nav.php"); // Includes the navigation bar ?>
    <main id="main" class="main">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="card mt-3" style="width: 80rem;">
                    <div class="card-header">
                        ATTENDANCE SUMMARY
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Timestamp</th>
                                    <th scope="col">Latitude</th>
                                    <th scope="col">Longitude</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($result) > 0) {
                                    foreach ($result as $row) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['latitude']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['longitude']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<?php
// Close the database connection
$conn = null;
?>
