
<?php
session_start();
require_once('dbconnect.php');
require_once('timezone.php');

// Redirect to login page if user is not logged in
if (empty($_SESSION["user"])) {
    header("location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = trim($_POST['name']);
    $name = htmlspecialchars($name);
    $timestamp = trim($_POST['timestamp']);
    $latitude = trim($_POST['latitude']);
    $longitude = trim($_POST['longitude']);

    // Center geolocation coordinates and radius
    $centerLat = -13.833882;
    $centerLon = 33.807049;
    $radiusKm = 2.0;

    // Calculate distance function
    function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadiusKm = 6371;
        $dLat = ($lat2 - $lat1) * (M_PI / 180);
        $dLon = ($lon2 - $lon1) * (M_PI / 180);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos($lat1 * (M_PI / 180)) * cos($lat2 * (M_PI / 180)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadiusKm * $c;
    }

    // Determine attendance status
    $isWithinRadius = calculateDistance($centerLat, $centerLon, $latitude, $longitude) <= $radiusKm;
    $attendanceStatus = $isWithinRadius ? "Present" : "Absent";

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "demo";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement using a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO attendance (name, timestamp, latitude, longitude, status) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssdds", $name, $timestamp, $latitude, $longitude, $attendanceStatus);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $message = "Attendance submitted successfully as $attendanceStatus!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Attendance</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7x4L1e8C0ybkZE=" crossorigin="anonymous"></script>
</head>
<body>
<?php include("nav.php") ?>
<main id="main" class="main">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card mt-3" style="width: 30rem;">
                <div class="card-header">
                    ATTENDANCE SYSTEM
                </div>
                <div class="card-body">
                    <form id="attdForm" class="form-control" method="POST" action="">
                        <div class="row">
                            <div class="mb-2">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-2">
                                <label for="time" class="form-label">Date - Time</label>
                                <div id="dateTime" class="form-control" disabled readonly></div>
                                <input type="hidden" id="timestamp" name="timestamp">
                                <button type="button" class="btn btn-primary mt-2" id="getDateTimeBtn">Check-In Date Time</button>
                            </div>
                            <div class="form-label">Latitude and Longitude</div>
                            <div class="input-group my-2">
                                <input type="text" class="form-control" name="latitude" id="latitude">
                                <input type="text" class="form-control" name="longitude" id="longitude">
                            </div>
                            <div class="my-3 d-flex justify-content-end">
                                <input type="hidden" name="status" id="status">
                                <button type="submit" class="btn btn-primary">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const earthRadiusKm = 6371;
                const dLat = (lat2 - lat1) * (Math.PI / 180);
                const dLon = (lon2 - lon1) * (Math.PI / 180);
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * (Math.PI / 180)) *
                    Math.cos(lat2 * (Math.PI / 180)) *
                    Math.sin(dLon / 2) *
                    Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return earthRadiusKm * c;
            }

            function displayTimestamp() {
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                    }, function(error) {
                        console.error('Error getting location:', error);
                        alert('Error getting location: ' + error.message);
                    });
                } else {
                    console.error('Geolocation is not available.');
                }

                var currentDate = new Date();
                var formattedTimestamp = currentDate.toISOString().slice(0, 19).replace('T', ' ');
                document.getElementById('dateTime').textContent = formattedTimestamp;
                document.getElementById('timestamp').value = formattedTimestamp;
            }

            function refreshTimestamp() {
                displayTimestamp();
            }

            document.getElementById('getDateTimeBtn').addEventListener('click', refreshTimestamp);

            // Call displayTimestamp initially to display the timestamp and location when the page loads
            displayTimestamp();

            $('#attdForm').on('submit', function(event){
                var latitudeInput = parseFloat($('#latitude').val());
                var longitudeInput = parseFloat($('#longitude').val());

                const centerLat = -13.833882; // Center latitude
                const centerLon = 33.807049; // Center longitude
                const radiusKm = 2.0; // Radius in kilometers

                const isWithinRadius = calculateDistance(centerLat, centerLon, latitudeInput, longitudeInput) <= radiusKm;
                const attendanceStatus = isWithinRadius ? "Present" : "Absent";

                $('#status').val(attendanceStatus);
            });
        });
    </script>

</main>
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.min.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

</body>
</html>


