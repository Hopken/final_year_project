<?php
session_start();
DATE_DEFAULT_TIMEZONE_SET('AFRICA/DAR_ES_SALAAM');
require_once('dbconnect.php');
if (isset($_SESSION['user'])!="")
{
	header("Location:view.php");
	//exit();
}
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
if(isset($_POST['login']))
{
$name=trim($_POST['name']);
$name=htmlspecialchars($_POST['name']);
$password=trim($_POST['password']);
$password=htmlspecialchars($_POST['password']);

$sth=$conn->prepare("SELECT * FROM users WHERE name=:name");
$sth->execute(array(':name'=>htmlspecialchars($_POST['name'])));
$row=$sth->fetch(PDO::FETCH_ASSOC);
$count=$sth->rowCount();
if($count==1)
		{
if (password_verify(htmlspecialchars($_POST['password']) , $row['password']))
{
    $_SESSION['user'] = $row['user_id'] ;
		header('location:view.php');
		
$user_status="online";
		$stmt =$conn->prepare('UPDATE users SET
user_status=:user_status WHERE user_id=:id');
$stmt->bindParam(':user_status',$user_status);
$stmt->bindParam(':id',$_SESSION['user']);
$stmt->execute();	
	$time_loged =date("Y-m-d H:i:s",strtotime("now"));
	$stmt=$conn->prepare('insert into activity(time_loged,user_id)VALUES(?,?)');
	$stmt->bindparam(1,$time_loged);
	$stmt->bindparam(2,$_SESSION['user']);
	$stmt->execute();
		}
		}
	else
	{
		$_SESSION['msg']='something went wrong';
		}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
	*{
		box-sizing: border-box;
		font-family: sans-serif;
		font-size: 20px;
	}
	body{
		background-color: whitesmoke;
	}	
	.login{
		width: 600px;
		height: 600px;
		background-color: #ffffff;
		box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3);
		margin: 100px auto;
	}
	.login p{
		text-align: center;
		color: #5b6574;
		font-size: 16px;
		padding: 20px 0 20px 0;
	}
	.login h1{
		text-align: center;
		color: #5b6574;
		font-size: 24px;
		padding: 20px 0 20px 0;
		border-bottom: 1px solid #dee0e4;
	}
	.login form{
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		padding-top: 20px; 
	}
	.login form label{
		display: flex;
		justify-content: center;
		align-items: center;
		width: 100px;
		height: 30px;
		background-color: dodgerblue;
		color: #ffffff;
	}
	.login form input[type="password"], .login form input[type="text"]{
		width: 310px;
		height: 50px;
		border: 1px solid #dee0e4;
		margin-bottom: 20px;
		padding: 0 15px;
	}
	.login form input[type="submit"]{
		display: flex;
		width: 200px;
		padding: 15px;
		margin-top: 20px;
		background-color: #3274d6;
		border: 0;
		cursor: pointer;
		font-weight: bold;
		color: #ffffff;
		transition: background-color 0.2s;
	}
	.login form input[type="submit"]:hover{
		background-color: #2868c7;
		transition: background-color 0.2s;
	}
	</style>
</head>
<body>
<div class="login">
	<h1>LOGIN</h1>
	<p>Please fill in your credentials to login.</p>
	<?php
	if(isset($_SESSION['msg'])){
		?>
		<?php
		echo $_SESSION['msg'];
	}
	?>
	<?php
	unset($_SESSION['msg']);
	?>  
	<form method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" placeholder="Username" id="name" required>
			<label for="password">Password</label>
			<input type="password" name="password" placeholder="Password" id="password" required>
			<input type="submit" name="login" value="Login">
			<p>Don't have an account? <a href="register.php"> Sign up.</a></p>
		</div>
	</form>
</div>
</body>
</html>

        