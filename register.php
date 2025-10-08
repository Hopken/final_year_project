<?php
DATE_DEFAULT_TIMEZONE_SET('AFRICA/BLANTYRE');
require("dbconnect.php");
error_reporting(~E_NOTICE);
session_start();
if($_SERVER['REQUEST_METHOD']=='POST')
{
if(isset($_POST['sub']))
{
$name=trim($_POST['name']);
$name=htmlspecialchars($_POST['name']);
$email=trim($_POST['email']);
$email=htmlspecialchars($_POST['email']);
$url=trim($_POST['url']);
$url=htmlspecialchars($_POST['url']);
$password=trim($_POST['password']);
$password=htmlspecialchars($_POST['password']);
$user_status='ofline';
$time_joined =date("Y-m-d H:i:s",strtotime("now"));
$date_joined =date("Y-m-d", strtotime("now"));

$encrypt = password_hash($password,PASSWORD_DEFAULT);
$sth=$conn->prepare("INSERT into  users(name,email,url,password,user_status,time_joined,date_joined)VALUES(?,?,?,?,?,?,?)");
$sth->bindparam(1,$name,PDO::PARAM_STR);
$sth->bindparam(2,$email,PDO::PARAM_STR);
$sth->bindparam(3,$url,PDO::PARAM_STR);
$sth->bindparam(4,$encrypt,PDO::PARAM_STR);
$sth->bindparam(5,$user_status,PDO::PARAM_STR);
$sth->bindparam(6,$time_joined,PDO::PARAM_STR);
$sth->bindparam(7,$date_joined,PDO::PARAM_STR);
if($sth->execute())
{
$_SESSION['msg']="You are now the member of this Network.....";
header("refresh:1;index.php");
                                }
                     }
          }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="jquery.min.js"></script>
<script type="text/javascript" src="jquery.validate.min.js"></script>
<style>
body{
    background:#F6F6F6;   
}
#ww{
position:relative;
width:1400px;
max-width:100%;
height:350px;
bottom:30px;
}
</style>
</head>
<body>
<!----container --->
<div class="container">
<div class="row">
<div class="col-md-6 col-md-push-3">
<div class="panel panel-default">
<div class="panel-body">
<form method="POST" id="register-form">
   <div class="form-group">
<label class="control-label" for="name">FULL NAME</label>
<input class="form-control input-sm" type="text" name="name" />
</div>
<div class="form-group">
<label class="control-label" for="email">E- MAIL ADRESS</label>
<input class="form-control input-sm" type="email" name="email" id="email" />
</div>
<div class="form-group">
<label class="control-label" for="url">URL</label>
<input class="form-control input-sm" type="text" name="url" />
</div>
<div class="form-group">
<label class="control-label" for="password">PASSWORD</label>
<input class="form-control input-sm" type="password" name="password" />
</div>

<!----submit button---->
<div class="form-group">
<button type="submit"  class="btn btn-default btn-lg" name="sub">
<span class="glyphicon glyphicon-log-in"></span> Save</button>
<a href="./"  class="btn btn-default btn-lg" name="sub">
Cancel</a>
</div>
</div><!----container--->
</div><!----row--->
</div><!----column--->
</div><!----panel default--->
</div><!----panel body--->

<script type="text/javascript">
$('document').ready(function()
{
$("#register-form").validate(
{
rules:{
name:{
required:true,
minlength:8
},
email:{
required:true,
email:true
},
url:{
required:true,
url:true
},
password:{
required:true,
minlength:8
},
/*repassword: {
					required: true,
					equalTo: '#password'
				},
				*/
		   },
		   messages:{
		   name:{
		   //required:'<p class="text-primary">'+"ENTER YOUR FULL NAME"+'</p>',
		   required:'<span class="glyphicon glyphicon-user text-primary">'+"ENTER YOUR FULL NAME"+'</span>',
		   minlength:'<span class="glyphicon glyphicon-remove text-danger">'+"ENTER VALID LENGTH OF 8 CHARACTERS"+'</span>',
		   },
		  
		   email:'<span class="glyphicon glyphicon-envelope text-danger">'+"ENTER YOUR EMAIL ADRESS"+'</span>',
		   
		  url:'<span class="glyphicon glyphicon-globe text-danger">'+"ENTER A VALID URL",
		  
		  password:{
		   required:'<span class="glyphicon glyphicon-lock text-primary">'+"ENTER YOUR PASSWORD"+'</span>',
		   minlength:'<span class="glyphicon glyphicon-eye-open text-danger">'+"ENTER REQUIRED LENGTH OF 8 CHARACTERS LONG"+'</span>',
		   },
		   /*repassword:{
		   required:'<span class="glyphicon glyphicon-lock text-primary">'+"RE TYPE YOUR PASSWORD"+'</span>',
	equalTo:'<span class="glyphicon glyphicon-ban-circle text-danger">'+"PASSWORD DID NOT MATCH"+'</span>'
	},
	*/
	},
submitHandler:function(form)
{
form.submit()
}
});
});

</script>
</body>
</html>