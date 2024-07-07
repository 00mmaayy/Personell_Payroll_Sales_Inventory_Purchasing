<?php
date_default_timezone_set("Asia/Manila");
include('connection/conn.php');
session_start();
$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $r['company_name']; ?></title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/w3.css">
</head>
<body>
<a style='color:#76b852' class='w3-tiny' href='clearallusers.php'><i>clear</i></a>
<div class="login-page">
  <div class="form">
  <div align="center"><img src="img/<?php echo $r['company']; ?>.jpg" height="80" width="200"/><br><br/></div>
    <form class="login-form" method="post">
      <input name="username" type="text" placeholder="username"/>
      <input name="password" type="password" placeholder="password"/>
      <button>login</button>  
    </form>
	
	<script src="js/jquery.min.js"></script>
    <script src="js/index.js"></script>
<?php
if (isset($_REQUEST['username']))
   {   $username=addslashes($_REQUEST['username']);
       
	   if(isset($_REQUEST['password']))
	   { $password= md5($_REQUEST['password']); } 
		  
	   $sql1="select * from users where username='$username' and password='$password'" ;
	   $result1= mysql_query($sql1) or die(mysql_error());
	   $row1=mysql_fetch_assoc($result1);
		
 	   $pos=$row1['position'];
	   $_SESSION['username']= $username;
				 
	   if($username!=$row1['username'] || $password!=$row1['password'])
		  { if($pos!=0){ echo "<br><div class='styles' align='center' style='color:#FF0000'>Login Failed! username or password is incorrect!</div>";}	}	  
							  
	   if($pos!=0)
		  { 
	        if($row1['user_status']==1)
			  { echo "<br><div class='styles' align='center' style='color:#FF0000'>Login Failed! user is in use or you forgot to loggout properly! <br>please contact IT administrator</div>"; }
	        
			else{
			$activity= "login";
            $sql1="INSERT INTO access_log (username,activity,date) VALUES ('$username','$activity',now())" ;
            $result1= mysql_query($sql1) or die(mysql_error());
			
			$sql2="UPDATE users SET user_status=1 where username='$username'";
            $result2= mysql_query($sql2) or die(mysql_error());
			
			header("location: admin.php?home=1"); }
		  }
	 else { echo "<br><div class='styles' align='center' style='color:#FF0000'>Login Failed! username or password is incorrect!</div>"; }	
}
?>

<?php
if (isset($_REQUEST['logout']))
   {
   $username= $_SESSION['username'];
   $activity= "logout";
   $sql1="INSERT INTO access_log (username,activity,date) VALUES ('$username','$activity',now())" ;
   $result1= mysql_query($sql1) or die(mysql_error());
   
   $sql2="UPDATE users SET user_status=0 where username='$username'" ;
   $result2= mysql_query($sql2) or die(mysql_error());
   
   unset($_SESSION['username']);
   header("Location: index.php");
   }   
?>     

<?php	
	if(isset($_REQUEST['cleared']))
	{
		echo "<br/><span class='w3-text-blue'>user: ".$_REQUEST['cleared']." Cleared!<br/>You can now login you account.</span>";
	}
?>	
	
  </div>  
</div>
</body>
</html>