<?php
require('timezone.php');
require('dbconnect.php');
//error_reporting(~E_NOTICE);
function start_session()
{
	$_SESSION['user']='';
	session_start();
if(empty($_SESSION['user']))
{
	header("Location:index.php");
	exit();
	}
}
echo start_session();
function db_query()
{
	global $conn;
$stmt=$conn->prepare( "SELECT * FROM users where user_id=:uid") ;
if($stmt->execute(['uid'=>$_SESSION['user']]))
{
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$count=$stmt->rowcount();
	       }
	}
	echo db_query();
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
        <title>Dashboard</title>
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
			<?php include("nav.php")?>
			<main id="main" class="main">
                <div class="app-body-main-content">
                    <section class="tiles-section">
                        <h2>Dashboard</h2>
                        <div class="tiles-section-header">
                        </div>
                        <div class="tiles">
                            <article class="tile">
                                <div class="tile-header">
                                    <i class="ph-lighting-light"></i>
                                    <h3>
                                        <span>Check-In</span>
                                        <span>Record Attendance.</span>
                                    </h3>
                                </div>
                                <a href="attendance.php">
                                    <span>Go to Service</span>
                                    <span class="icon-button">
                                        <i class="ph-caret-right-bold"></i>
                                    </span>
                                </a>
                            </article>
                            <article class="tile">
                                <div class="tile-header">
                                    <i class="ph-fire-simple-light"></i>
                                    <h3>
                                        <span>Summary</span>
                                        <span>Check attendance history.</span>
                                    </h3>
                                </div>
                                <a href="summary.php">
                                    <span>Go to Service</span>
                                    <span class="icon-button">
                                        <i class="ph-caret-right-bold"></i>
                                    </span>
                                </a>
                            </article>
                            <article class="tile">
                                <div class="tile-header">
                                    <i class="ph-file-light"></i>
                                    <h3>
                                        <span>Taskboard</span>
                                        <span>Add and Check task.</span>
                                    </h3>
                                </div>
                                <a href="task.php">
                                    <span>Go to Service</span>
                                    <span class="icon-button">
                                        <i class="ph-caret-right-bold"></i>
                                    </span>
                                </a>
                            </article>
                        </div>
                        <div class="tiles-section-footer">
                            <p>Quick action buttons.</p>
                        </div>
                    </section>
					<div class="container-fluid">
						<table class="table table-striped table-light mx-1 mt-5">
                            <thead>
                                <tr>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Last Login</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody">
                                <?php
                                $id = $_SESSION['user'];
                                $query = $conn->query("SELECT * FROM users inner join activity on users.user_id=activity.user_id where users.user_id='$id'");
                                while ($roww = $query->fetch()){
                                    $user_id = $roww['user_id'];
                                    $user_status = $roww['user_status'];
                                ?>
                                <tr>
                                    <td><?php echo $roww['name'];?></td>
                                    <td><?php echo date("d/m/y H:i:sA", strtotime($roww['time_loged'])); ?></td>
                                    <td>
                                    <?php
                                    if ($user_status == 'online'){
                                        echo '<span class="text-success">Online</span>';
                                    }else{
                                        echo '<span class="text-danger">Offline</span>';
                                        }
                                    ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
				</div>
				<script src="js/jquery-1.11.2.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
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
 