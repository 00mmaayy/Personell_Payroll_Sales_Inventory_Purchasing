<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); } ?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
//User access level update script start -----
if(isset($_REQUEST['user_access_update']))
{
$user_access=$_REQUEST['user_access'];
if(isset($_REQUEST['a1'])){ mysql_query("update user_access set a1=1 where username='$user_access' "); } else { mysql_query("update user_access set a1=0 where username='$user_access' "); }
if(isset($_REQUEST['a2'])){ mysql_query("update user_access set a2=1 where username='$user_access' "); } else { mysql_query("update user_access set a2=0 where username='$user_access' "); }
if(isset($_REQUEST['a3'])){ mysql_query("update user_access set a3=1 where username='$user_access' "); } else { mysql_query("update user_access set a3=0 where username='$user_access' "); }
if(isset($_REQUEST['a4'])){ mysql_query("update user_access set a4=1 where username='$user_access' "); } else { mysql_query("update user_access set a4=0 where username='$user_access' "); }
if(isset($_REQUEST['a5'])){ mysql_query("update user_access set a5=1 where username='$user_access' "); } else { mysql_query("update user_access set a5=0 where username='$user_access' "); }
if(isset($_REQUEST['a6'])){ mysql_query("update user_access set a6=1 where username='$user_access' "); } else { mysql_query("update user_access set a6=0 where username='$user_access' "); }
if(isset($_REQUEST['a7'])){ mysql_query("update user_access set a7=1 where username='$user_access' "); } else { mysql_query("update user_access set a7=0 where username='$user_access' "); }
if(isset($_REQUEST['a8'])){ mysql_query("update user_access set a8=1 where username='$user_access' "); } else { mysql_query("update user_access set a8=0 where username='$user_access' "); }
if(isset($_REQUEST['a9'])){ mysql_query("update user_access set a9=1 where username='$user_access' "); } else { mysql_query("update user_access set a9=0 where username='$user_access' "); }
if(isset($_REQUEST['a10'])){ mysql_query("update user_access set a10=1 where username='$user_access' "); } else { mysql_query("update user_access set a10=0 where username='$user_access' "); }
if(isset($_REQUEST['a11'])){ mysql_query("update user_access set a11=1 where username='$user_access' "); } else { mysql_query("update user_access set a11=0 where username='$user_access' "); }
if(isset($_REQUEST['a12'])){ mysql_query("update user_access set a12=1 where username='$user_access' "); } else { mysql_query("update user_access set a12=0 where username='$user_access' "); }
if(isset($_REQUEST['a13'])){ mysql_query("update user_access set a13=1 where username='$user_access' "); } else { mysql_query("update user_access set a13=0 where username='$user_access' "); }
if(isset($_REQUEST['a14'])){ mysql_query("update user_access set a14=1 where username='$user_access' "); } else { mysql_query("update user_access set a14=0 where username='$user_access' "); }
if(isset($_REQUEST['a15'])){ mysql_query("update user_access set a15=1 where username='$user_access' "); } else { mysql_query("update user_access set a15=0 where username='$user_access' "); }
if(isset($_REQUEST['a16'])){ mysql_query("update user_access set a16=1 where username='$user_access' "); } else { mysql_query("update user_access set a16=0 where username='$user_access' "); }
if(isset($_REQUEST['a17'])){ mysql_query("update user_access set a17=1 where username='$user_access' "); } else { mysql_query("update user_access set a17=0 where username='$user_access' "); }
if(isset($_REQUEST['a18'])){ mysql_query("update user_access set a18=1 where username='$user_access' "); } else { mysql_query("update user_access set a18=0 where username='$user_access' "); }
if(isset($_REQUEST['a19'])){ mysql_query("update user_access set a19=1 where username='$user_access' "); } else { mysql_query("update user_access set a19=0 where username='$user_access' "); }
if(isset($_REQUEST['a20'])){ mysql_query("update user_access set a20=1 where username='$user_access' "); } else { mysql_query("update user_access set a20=0 where username='$user_access' "); }
if(isset($_REQUEST['a21'])){ mysql_query("update user_access set a21=1 where username='$user_access' "); } else { mysql_query("update user_access set a21=0 where username='$user_access' "); }
if(isset($_REQUEST['a22'])){ mysql_query("update user_access set a22=1 where username='$user_access' "); } else { mysql_query("update user_access set a22=0 where username='$user_access' "); }
if(isset($_REQUEST['a23'])){ mysql_query("update user_access set a23=1 where username='$user_access' "); } else { mysql_query("update user_access set a23=0 where username='$user_access' "); }
if(isset($_REQUEST['a24'])){ mysql_query("update user_access set a24=1 where username='$user_access' "); } else { mysql_query("update user_access set a24=0 where username='$user_access' "); }
if(isset($_REQUEST['a25'])){ mysql_query("update user_access set a25=1 where username='$user_access' "); } else { mysql_query("update user_access set a25=0 where username='$user_access' "); }
if(isset($_REQUEST['a26'])){ mysql_query("update user_access set a26=1 where username='$user_access' "); } else { mysql_query("update user_access set a26=0 where username='$user_access' "); }

if(isset($_REQUEST['b1'])){ mysql_query("update user_access set b1=1 where username='$user_access' "); } else { mysql_query("update user_access set b1=0 where username='$user_access' "); }
if(isset($_REQUEST['b2'])){ mysql_query("update user_access set b2=1 where username='$user_access' "); } else { mysql_query("update user_access set b2=0 where username='$user_access' "); }
if(isset($_REQUEST['b3'])){ mysql_query("update user_access set b3=1 where username='$user_access' "); } else { mysql_query("update user_access set b3=0 where username='$user_access' "); }
if(isset($_REQUEST['b4'])){ mysql_query("update user_access set b4=1 where username='$user_access' "); } else { mysql_query("update user_access set b4=0 where username='$user_access' "); }
if(isset($_REQUEST['b5'])){ mysql_query("update user_access set b5=1 where username='$user_access' "); } else { mysql_query("update user_access set b5=0 where username='$user_access' "); }
if(isset($_REQUEST['b6'])){ mysql_query("update user_access set b6=1 where username='$user_access' "); } else { mysql_query("update user_access set b6=0 where username='$user_access' "); }
if(isset($_REQUEST['b7'])){ mysql_query("update user_access set b7=1 where username='$user_access' "); } else { mysql_query("update user_access set b7=0 where username='$user_access' "); }
if(isset($_REQUEST['b8'])){ mysql_query("update user_access set b8=1 where username='$user_access' "); } else { mysql_query("update user_access set b8=0 where username='$user_access' "); }
if(isset($_REQUEST['b9'])){ mysql_query("update user_access set b9=1 where username='$user_access' "); } else { mysql_query("update user_access set b9=0 where username='$user_access' "); }
if(isset($_REQUEST['b10'])){ mysql_query("update user_access set b10=1 where username='$user_access' "); } else { mysql_query("update user_access set b10=0 where username='$user_access' "); }
if(isset($_REQUEST['b11'])){ mysql_query("update user_access set b11=1 where username='$user_access' "); } else { mysql_query("update user_access set b11=0 where username='$user_access' "); }
if(isset($_REQUEST['b12'])){ mysql_query("update user_access set b12=1 where username='$user_access' "); } else { mysql_query("update user_access set b12=0 where username='$user_access' "); }
if(isset($_REQUEST['b13'])){ mysql_query("update user_access set b13=1 where username='$user_access' "); } else { mysql_query("update user_access set b13=0 where username='$user_access' "); }
if(isset($_REQUEST['b14'])){ mysql_query("update user_access set b14=1 where username='$user_access' "); } else { mysql_query("update user_access set b14=0 where username='$user_access' "); }
if(isset($_REQUEST['b15'])){ mysql_query("update user_access set b15=1 where username='$user_access' "); } else { mysql_query("update user_access set b15=0 where username='$user_access' "); }
if(isset($_REQUEST['b16'])){ mysql_query("update user_access set b16=1 where username='$user_access' "); } else { mysql_query("update user_access set b16=0 where username='$user_access' "); }
if(isset($_REQUEST['b17'])){ mysql_query("update user_access set b17=1 where username='$user_access' "); } else { mysql_query("update user_access set b17=0 where username='$user_access' "); }
if(isset($_REQUEST['b18'])){ mysql_query("update user_access set b18=1 where username='$user_access' "); } else { mysql_query("update user_access set b18=0 where username='$user_access' "); }
//if(isset($_REQUEST['b19'])){ mysql_query("update user_access set b19=1 where username='$user_access' "); } else { mysql_query("update user_access set b19=0 where username='$user_access' "); }
if(isset($_REQUEST['b20'])){ mysql_query("update user_access set b20=1 where username='$user_access' "); } else { mysql_query("update user_access set b20=0 where username='$user_access' "); }
if(isset($_REQUEST['b21'])){ mysql_query("update user_access set b21=1 where username='$user_access' "); } else { mysql_query("update user_access set b21=0 where username='$user_access' "); }
if(isset($_REQUEST['b22'])){ mysql_query("update user_access set b22=1 where username='$user_access' "); } else { mysql_query("update user_access set b22=0 where username='$user_access' "); }
if(isset($_REQUEST['b23'])){ mysql_query("update user_access set b23=1 where username='$user_access' "); } else { mysql_query("update user_access set b23=0 where username='$user_access' "); }
if(isset($_REQUEST['b24'])){ mysql_query("update user_access set b24=1 where username='$user_access' "); } else { mysql_query("update user_access set b24=0 where username='$user_access' "); }

if(isset($_REQUEST['c1'])){ mysql_query("update user_access set c1=1 where username='$user_access' "); } else { mysql_query("update user_access set c1=0 where username='$user_access' "); }
if(isset($_REQUEST['c2'])){ mysql_query("update user_access set c2=1 where username='$user_access' "); } else { mysql_query("update user_access set c2=0 where username='$user_access' "); }

if(isset($_REQUEST['d1'])){ mysql_query("update user_access set d1=1 where username='$user_access' "); } else { mysql_query("update user_access set d1=0 where username='$user_access' "); }
if(isset($_REQUEST['d2'])){ mysql_query("update user_access set d2=1 where username='$user_access' "); } else { mysql_query("update user_access set d2=0 where username='$user_access' "); }
if(isset($_REQUEST['d3'])){ mysql_query("update user_access set d3=1 where username='$user_access' "); } else { mysql_query("update user_access set d3=0 where username='$user_access' "); }
if(isset($_REQUEST['d4'])){ mysql_query("update user_access set d4=1 where username='$user_access' "); } else { mysql_query("update user_access set d4=0 where username='$user_access' "); }
if(isset($_REQUEST['d5'])){ mysql_query("update user_access set d5=1 where username='$user_access' "); } else { mysql_query("update user_access set d5=0 where username='$user_access' "); }
if(isset($_REQUEST['d6'])){ mysql_query("update user_access set d6=1 where username='$user_access' "); } else { mysql_query("update user_access set d6=0 where username='$user_access' "); }
if(isset($_REQUEST['d7'])){ mysql_query("update user_access set d7=1 where username='$user_access' "); } else { mysql_query("update user_access set d7=0 where username='$user_access' "); }
if(isset($_REQUEST['d8'])){ mysql_query("update user_access set d8=1 where username='$user_access' "); } else { mysql_query("update user_access set d8=0 where username='$user_access' "); }
if(isset($_REQUEST['d9'])){ mysql_query("update user_access set d9=1 where username='$user_access' "); } else { mysql_query("update user_access set d9=0 where username='$user_access' "); }
if(isset($_REQUEST['d10'])){ mysql_query("update user_access set d10=1 where username='$user_access' "); } else { mysql_query("update user_access set d10=0 where username='$user_access' "); }
if(isset($_REQUEST['d11'])){ mysql_query("update user_access set d11=1 where username='$user_access' "); } else { mysql_query("update user_access set d11=0 where username='$user_access' "); }
if(isset($_REQUEST['d12'])){ mysql_query("update user_access set d12=1 where username='$user_access' "); } else { mysql_query("update user_access set d12=0 where username='$user_access' "); }
if(isset($_REQUEST['d13'])){ mysql_query("update user_access set d13=1 where username='$user_access' "); } else { mysql_query("update user_access set d13=0 where username='$user_access' "); }
if(isset($_REQUEST['d14'])){ mysql_query("update user_access set d14=1 where username='$user_access' "); } else { mysql_query("update user_access set d14=0 where username='$user_access' "); }
if(isset($_REQUEST['d15'])){ mysql_query("update user_access set d15=1 where username='$user_access' "); } else { mysql_query("update user_access set d15=0 where username='$user_access' "); }
if(isset($_REQUEST['d16'])){ mysql_query("update user_access set d16=1 where username='$user_access' "); } else { mysql_query("update user_access set d16=0 where username='$user_access' "); }
if(isset($_REQUEST['d17'])){ mysql_query("update user_access set d17=1 where username='$user_access' "); } else { mysql_query("update user_access set d17=0 where username='$user_access' "); }
if(isset($_REQUEST['d18'])){ mysql_query("update user_access set d18=1 where username='$user_access' "); } else { mysql_query("update user_access set d18=0 where username='$user_access' "); }
if(isset($_REQUEST['d19'])){ mysql_query("update user_access set d19=1 where username='$user_access' "); } else { mysql_query("update user_access set d19=0 where username='$user_access' "); }
if(isset($_REQUEST['d20'])){ mysql_query("update user_access set d20=1 where username='$user_access' "); } else { mysql_query("update user_access set d20=0 where username='$user_access' "); }
if(isset($_REQUEST['d21'])){ mysql_query("update user_access set d21=1 where username='$user_access' "); } else { mysql_query("update user_access set d21=0 where username='$user_access' "); }
if(isset($_REQUEST['d22'])){ mysql_query("update user_access set d22=1 where username='$user_access' "); } else { mysql_query("update user_access set d22=0 where username='$user_access' "); }
if(isset($_REQUEST['d23'])){ mysql_query("update user_access set d23=1 where username='$user_access' "); } else { mysql_query("update user_access set d23=0 where username='$user_access' "); }
if(isset($_REQUEST['d24'])){ mysql_query("update user_access set d24=1 where username='$user_access' "); } else { mysql_query("update user_access set d24=0 where username='$user_access' "); }
if(isset($_REQUEST['d25'])){ mysql_query("update user_access set d25=1 where username='$user_access' "); } else { mysql_query("update user_access set d25=0 where username='$user_access' "); }
if(isset($_REQUEST['d26'])){ mysql_query("update user_access set d26=1 where username='$user_access' "); } else { mysql_query("update user_access set d26=0 where username='$user_access' "); }
if(isset($_REQUEST['d27'])){ mysql_query("update user_access set d27=1 where username='$user_access' "); } else { mysql_query("update user_access set d27=0 where username='$user_access' "); }
if(isset($_REQUEST['d28'])){ mysql_query("update user_access set d28=1 where username='$user_access' "); } else { mysql_query("update user_access set d28=0 where username='$user_access' "); }
if(isset($_REQUEST['d29'])){ mysql_query("update user_access set d29=1 where username='$user_access' "); } else { mysql_query("update user_access set d29=0 where username='$user_access' "); }
if(isset($_REQUEST['d30'])){ mysql_query("update user_access set d30=1 where username='$user_access' "); } else { mysql_query("update user_access set d30=0 where username='$user_access' "); }

if(isset($_REQUEST['f1'])){ mysql_query("update user_access set f1=1 where username='$user_access' "); } else { mysql_query("update user_access set f1=0 where username='$user_access' "); }
if(isset($_REQUEST['f2'])){ mysql_query("update user_access set f2=1 where username='$user_access' "); } else { mysql_query("update user_access set f2=0 where username='$user_access' "); }

if(isset($_REQUEST['i1'])){ mysql_query("update user_access set i1=1 where username='$user_access' "); } else { mysql_query("update user_access set i1=0 where username='$user_access' "); }
if(isset($_REQUEST['i2'])){ mysql_query("update user_access set i2=1 where username='$user_access' "); } else { mysql_query("update user_access set i2=0 where username='$user_access' "); }

if(isset($_REQUEST['m1'])){ mysql_query("update user_access set m1=1 where username='$user_access' "); } else { mysql_query("update user_access set m1=0 where username='$user_access' "); }
if(isset($_REQUEST['m2'])){ mysql_query("update user_access set m2=1 where username='$user_access' "); } else { mysql_query("update user_access set m2=0 where username='$user_access' "); }
if(isset($_REQUEST['m3'])){ mysql_query("update user_access set m3=1 where username='$user_access' "); } else { mysql_query("update user_access set m3=0 where username='$user_access' "); }
if(isset($_REQUEST['m4'])){ mysql_query("update user_access set m4=1 where username='$user_access' "); } else { mysql_query("update user_access set m4=0 where username='$user_access' "); }
if(isset($_REQUEST['m5'])){ mysql_query("update user_access set m5=1 where username='$user_access' "); } else { mysql_query("update user_access set m5=0 where username='$user_access' "); }
if(isset($_REQUEST['m6'])){ mysql_query("update user_access set m6=1 where username='$user_access' "); } else { mysql_query("update user_access set m6=0 where username='$user_access' "); }
if(isset($_REQUEST['m7'])){ mysql_query("update user_access set m7=1 where username='$user_access' "); } else { mysql_query("update user_access set m7=0 where username='$user_access' "); }
if(isset($_REQUEST['m8'])){ mysql_query("update user_access set m8=1 where username='$user_access' "); } else { mysql_query("update user_access set m8=0 where username='$user_access' "); }
if(isset($_REQUEST['m9'])){ mysql_query("update user_access set m9=1 where username='$user_access' "); } else { mysql_query("update user_access set m9=0 where username='$user_access' "); }
if(isset($_REQUEST['m10'])){ mysql_query("update user_access set m10=1 where username='$user_access' "); } else { mysql_query("update user_access set m10=0 where username='$user_access' "); }
if(isset($_REQUEST['m11'])){ mysql_query("update user_access set m11=1 where username='$user_access' "); } else { mysql_query("update user_access set m11=0 where username='$user_access' "); }
if(isset($_REQUEST['m12'])){ mysql_query("update user_access set m12=1 where username='$user_access' "); } else { mysql_query("update user_access set m12=0 where username='$user_access' "); }
if(isset($_REQUEST['m13'])){ mysql_query("update user_access set m13=1 where username='$user_access' "); } else { mysql_query("update user_access set m13=0 where username='$user_access' "); }
if(isset($_REQUEST['m14'])){ mysql_query("update user_access set m14=1 where username='$user_access' "); } else { mysql_query("update user_access set m14=0 where username='$user_access' "); }
if(isset($_REQUEST['m15'])){ mysql_query("update user_access set m15=1 where username='$user_access' "); } else { mysql_query("update user_access set m15=0 where username='$user_access' "); }
if(isset($_REQUEST['m16'])){ mysql_query("update user_access set m16=1 where username='$user_access' "); } else { mysql_query("update user_access set m16=0 where username='$user_access' "); }
if(isset($_REQUEST['m17'])){ mysql_query("update user_access set m17=1 where username='$user_access' "); } else { mysql_query("update user_access set m17=0 where username='$user_access' "); }

if(isset($_REQUEST['p1'])){ mysql_query("update user_access set p1=1 where username='$user_access' "); } else { mysql_query("update user_access set p1=0 where username='$user_access' "); }
if(isset($_REQUEST['p2'])){ mysql_query("update user_access set p2=1 where username='$user_access' "); } else { mysql_query("update user_access set p2=0 where username='$user_access' "); }
if(isset($_REQUEST['p3'])){ mysql_query("update user_access set p3=1 where username='$user_access' "); } else { mysql_query("update user_access set p3=0 where username='$user_access' "); }
if(isset($_REQUEST['p4'])){ mysql_query("update user_access set p4=1 where username='$user_access' "); } else { mysql_query("update user_access set p4=0 where username='$user_access' "); }
if(isset($_REQUEST['p5'])){ mysql_query("update user_access set p5=1 where username='$user_access' "); } else { mysql_query("update user_access set p5=0 where username='$user_access' "); }
if(isset($_REQUEST['p6'])){ mysql_query("update user_access set p6=1 where username='$user_access' "); } else { mysql_query("update user_access set p6=0 where username='$user_access' "); }
if(isset($_REQUEST['p7'])){ mysql_query("update user_access set p7=1 where username='$user_access' "); } else { mysql_query("update user_access set p7=0 where username='$user_access' "); }

if(isset($_REQUEST['vip1'])){ mysql_query("update user_access set vip1=1 where username='$user_access' "); } else { mysql_query("update user_access set vip1=0 where username='$user_access' "); }

if(isset($_REQUEST['z1'])){ mysql_query("update user_access set z1=1 where username='$user_access' "); } else { mysql_query("update user_access set z1=0 where username='$user_access' "); }
if(isset($_REQUEST['z2'])){ mysql_query("update user_access set z2=1 where username='$user_access' "); } else { mysql_query("update user_access set z2=0 where username='$user_access' "); }
if(isset($_REQUEST['z3'])){ mysql_query("update user_access set z3=1 where username='$user_access' "); } else { mysql_query("update user_access set z3=0 where username='$user_access' "); }
if(isset($_REQUEST['z4'])){ mysql_query("update user_access set z4=1 where username='$user_access' "); } else { mysql_query("update user_access set z4=0 where username='$user_access' "); }
if(isset($_REQUEST['z5'])){ mysql_query("update user_access set z5=1 where username='$user_access' "); } else { mysql_query("update user_access set z5=0 where username='$user_access' "); }
if(isset($_REQUEST['z6'])){ mysql_query("update user_access set z6=1 where username='$user_access' "); } else { mysql_query("update user_access set z6=0 where username='$user_access' "); }
if(isset($_REQUEST['z7'])){ mysql_query("update user_access set z7=1 where username='$user_access' "); } else { mysql_query("update user_access set z7=0 where username='$user_access' "); }
if(isset($_REQUEST['z8'])){ mysql_query("update user_access set z8=1 where username='$user_access' "); } else { mysql_query("update user_access set z8=0 where username='$user_access' "); }
if(isset($_REQUEST['z9'])){ mysql_query("update user_access set z9=1 where username='$user_access' "); } else { mysql_query("update user_access set z9=0 where username='$user_access' "); }
if(isset($_REQUEST['z10'])){ mysql_query("update user_access set z10=1 where username='$user_access' "); } else { mysql_query("update user_access set z10=0 where username='$user_access' "); }
if(isset($_REQUEST['z11'])){ mysql_query("update user_access set z11=1 where username='$user_access' "); } else { mysql_query("update user_access set z11=0 where username='$user_access' "); }

$username=$_SESSION['username'];
$trans="account access_level update for $user_access";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());
			   
$loca='Location: script_access_level.php?updated=1&user_access='.$_REQUEST['user_access'];
header($loca);
}
//User access level update script end -----
?>

<?php echo "<div align='center'><br><strong><a href='admin.php?settings=1&createuser=1'>RETURN</a></strong></div>";?>
<hr>
<div align='center' class='w3-text-red'><strong>ACCESS LEVEL EDITOR</strong></div><br>

<?php
$s="select username from users where user_disable = 0 order by username asc";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);


if(isset($_REQUEST['user_access'])) 
{
$user_access=$_REQUEST['user_access'];
$s1="select * from user_access where username='$user_access' ";
$q1=mysql_query($s1) or die(mysql_error());
$access=mysql_fetch_assoc($q1);
}

echo "<form align='center' method='get'>
      <select name='user_access'><option></option>";
do{
echo "<option>".$r['username']."</option>";	
}while($r=mysql_fetch_assoc($q));
echo "</select>
      <input type='submit' value='Show / Edit Access'>
      </form>";
?>

<hr>

<div align='center'>
	<strong>USER ACCESS LIST FOR ACCOUNT&nbsp;&nbsp;<?php echo "<span class='w3-xlarge w3-text-red'>".$_REQUEST['user_access']."</span>";  if(isset($_REQUEST['updated'])) { echo "&nbsp;&nbsp;<span class='w3-xlarge w3-text-green'>Updated!</span>"; } ?></strong>
	<br/><a href="script_user_access_summary.php" target="_blank">Access List Summary</a>
</div>

<br>
<div class='container'>
<form method='get'>
<input name='user_access' type='hidden' value='<?php echo $user_access; ?>'>
<input name='user_access_update' type='hidden' value='1'>


	
	<!--Access checkbox for Payroll Start ------->
	<table class='table w3-light-gray'>
	<tr><td colspan='3'><input name='a1' type='checkbox' <?php if($access['a1']==1){ echo "checked";} ?> >&nbsp;<strong>PAYROLL</strong>&nbsp;<span class='w3-tiny'>a1</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='a2' type='checkbox' <?php if($access['a2']==1){ echo "checked";} ?> >&nbsp;Payroll Processing&nbsp;<span class='w3-tiny'>a2</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a3' type='checkbox' <?php if($access['a3']==1){ echo "checked";} ?> >&nbsp;Step 1&nbsp;<span class='w3-tiny'>a3</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a4' type='checkbox' <?php if($access['a4']==1){ echo "checked";} ?> >&nbsp;Step 2&nbsp;<span class='w3-tiny'>a4</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a5' type='checkbox' <?php if($access['a5']==1){ echo "checked";} ?> >&nbsp;Step 3&nbsp;<span class='w3-tiny'>a5</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='a7' type='checkbox' <?php if($access['a7']==1){ echo "checked";} ?> >&nbsp;Work Hour Entry&nbsp;<span class='w3-tiny'>a7</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='a8' type='checkbox' <?php if($access['a8']==1){ echo "checked";} ?> >&nbsp;Deductions/Adjustments Enty&nbsp;<span class='w3-tiny'>a8</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='a9' type='checkbox' <?php if($access['a9']==1){ echo "checked";} ?> >&nbsp;Payroll Review&nbsp;<span class='w3-tiny'>a9</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='a10' type='checkbox' <?php if($access['a10']==1){ echo "checked";} ?> >&nbsp;Submit Payroll to Finance&nbsp;<span class='w3-tiny'>a10</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='a11' type='checkbox' <?php if($access['a11']==1){ echo "checked";} ?> >&nbsp;Needs Revision: Back to Step 3&nbsp;<span class='w3-tiny'>a11</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a12' type='checkbox' <?php if($access['a12']==1){ echo "checked";} ?> >&nbsp;Step 4 Finalize Now&nbsp;<span class='w3-tiny'>a12</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a18' type='checkbox' <?php if($access['a18']==1){ echo "checked";} ?> >&nbsp;Restart Payroll Period&nbsp;<span class='w3-tiny'>a18</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a6' type='checkbox' <?php if($access['a6']==1){ echo "checked";} ?> >&nbsp;DTR Manager&nbsp;<span class='w3-tiny'>a6</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a13' type='checkbox' <?php if($access['a13']==1){ echo "checked";} ?> >&nbsp;Batch Compensation Entry&nbsp;<span class='w3-tiny'>a13</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a14' type='checkbox' <?php if($access['a14']==1){ echo "checked";} ?> >&nbsp;W-Tax Computation&nbsp;<span class='w3-tiny'>a14</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='a15' type='checkbox' <?php if($access['a15']==1){ echo "checked";} ?> >&nbsp;Payroll Reports&nbsp;<span class='w3-tiny'>a15</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='a16' type='checkbox' <?php if($access['a16']==1){ echo "checked";} ?> >&nbsp;Payslip Maintenance&nbsp;<span class='w3-tiny'>a16</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='a17' type='checkbox' <?php if($access['a17']==1){ echo "checked";} ?> >&nbsp;Processing Date Settings&nbsp;<span class='w3-tiny'>a17</span></td></tr>
<tr><td>&nbsp;&nbsp;</td><td><input name='a19' type='checkbox' <?php if($access['a19']==1){ echo "checked";} ?> >&nbsp;Payroll Companion App&nbsp;<span class='w3-tiny'>a19</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a20' type='checkbox' <?php if($access['a20']==1){ echo "checked";} ?> >&nbsp;Add Payroll Time&nbsp;<span class='w3-tiny'>a20</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='a21' type='checkbox' <?php if($access['a21']==1){ echo "checked";} ?> >&nbsp;Backup and Delete Time&nbsp;<span class='w3-tiny'>a21</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='a22' type='checkbox' <?php if($access['a22']==1){ echo "checked";} ?> >&nbsp;Delete Time&nbsp;<span class='w3-tiny'>a22</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a23' type='checkbox' <?php if($access['a23']==1){ echo "checked";} ?> >&nbsp;Update Employee Benefits&nbsp;<span class='w3-tiny'>a23</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a24' type='checkbox' <?php if($access['a24']==1){ echo "checked";} ?> >&nbsp;Change Employee Rate&nbsp;<span class='w3-tiny'>a24</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a25' type='checkbox' <?php if($access['a25']==1){ echo "checked";} ?> >&nbsp;Remove Employee in Payroll&nbsp;<span class='w3-tiny'>a25</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='a26' type='checkbox' <?php if($access['a26']==1){ echo "checked";} ?> >&nbsp;Add Employee in Payroll&nbsp;<span class='w3-tiny'>a26</span></td></tr>
	<tr><td colspan='2'>&nbsp;</td></tr>   
	</table>
	<!--Access checkbox for Payroll End ------->
	
		

    <!--Access checkbox for Personnel Start ------->
	<table class='table w3-light-gray'>
	<tr><td colspan='2'><input name='b1' type='checkbox' <?php if($access['b1']==1){ echo "checked";} ?> >&nbsp;<strong>PERSONNEL</strong>&nbsp;<span class='w3-tiny'>b1</span></td></tr> 
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b2' type='checkbox' <?php if($access['b2']==1){ echo "checked";} ?> >&nbsp;Add Employee&nbsp;<span class='w3-tiny'>b2</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b3' type='checkbox' <?php if($access['b3']==1){ echo "checked";} ?> >&nbsp;HR Summary Reports&nbsp;<span class='w3-tiny'>b3</span></td></tr>
	   
	   <!--<tr><td>&nbsp;&nbsp;</td><td><input name='b19' type='checkbox' <?php //if($access['b19']==1){ echo "checked";} ?> >&nbsp;Late Ranking Reports&nbsp;<span class='w3-tiny'>b19</span></td></tr>-->
	   <!--<tr><td>&nbsp;&nbsp;</td><td><input name='b23' type='checkbox' <?php //if($access['b23']==1){ echo "checked";} ?> >&nbsp;Absents Raking Reports&nbsp;<span class='w3-tiny'>b23</span></td></tr>-->
	   
	   <tr class='w3-tiny'><td>&nbsp;&nbsp;</td><td colspan='2'>-------</td></tr>	   
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b4' type='checkbox' <?php if($access['b4']==1){ echo "checked";} ?> >&nbsp;View Employee Details&nbsp;<span class='w3-tiny'>b4</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b5' type='checkbox' <?php if($access['b5']==1){ echo "checked";} ?> >&nbsp;View Family Details&nbsp;<span class='w3-tiny'>b5</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b6' type='checkbox' <?php if($access['b6']==1){ echo "checked";} ?> >&nbsp;View Academic History&nbsp;<span class='w3-tiny'>b6</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b7' type='checkbox' <?php if($access['b7']==1){ echo "checked";} ?> >&nbsp;View Employment History&nbsp;<span class='w3-tiny'>b7</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b17' type='checkbox' <?php if($access['b17']==1){ echo "checked";} ?> >&nbsp;Employee Movements&nbsp;<span class='w3-tiny'>b17</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b18' type='checkbox' <?php if($access['b18']==1){ echo "checked";} ?> >&nbsp;Organization&nbsp;<span class='w3-tiny'>b18</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b8' type='checkbox' <?php if($access['b8']==1){ echo "checked";} ?> >&nbsp;View Trainings&nbsp;<span class='w3-tiny'>b8</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b9' type='checkbox' <?php if($access['b9']==1){ echo "checked";} ?> >&nbsp;View Payroll Details&nbsp;<span class='w3-tiny'>b9</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b10' type='checkbox' <?php if($access['b10']==1){ echo "checked";} ?> >&nbsp;Upload ID Picture&nbsp;<span class='w3-tiny'>b10</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b22' type='checkbox' <?php if($access['b22']==1){ echo "checked";} ?> >&nbsp;Leaves&nbsp;<span class='w3-tiny'>b22</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b24' type='checkbox' <?php if($access['b24']==1){ echo "checked";} ?> >&nbsp;Offense&nbsp;<span class='w3-tiny'>b24</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b23' type='checkbox' <?php if($access['b23']==1){ echo "checked";} ?> >&nbsp;Loans&nbsp;<span class='w3-tiny'>b23</span></td></tr>
	   <tr class='w3-tiny'><td>&nbsp;&nbsp;</td><td colspan='2'>-------</td></tr>	   
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b11' type='checkbox' <?php if($access['b11']==1){ echo "checked";} ?> >&nbsp;Edit Employee Details&nbsp;<span class='w3-tiny'>b11</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b12' type='checkbox' <?php if($access['b12']==1){ echo "checked";} ?> >&nbsp;Edit Family Details&nbsp;<span class='w3-tiny'>b12</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b13' type='checkbox' <?php if($access['b13']==1){ echo "checked";} ?> >&nbsp;Edit Academic History&nbsp;<span class='w3-tiny'>b13</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b14' type='checkbox' <?php if($access['b14']==1){ echo "checked";} ?> >&nbsp;Edit Employment History&nbsp;<span class='w3-tiny'>b14</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b20' type='checkbox' <?php if($access['b20']==1){ echo "checked";} ?> >&nbsp;Edit Personnel Movement&nbsp;<span class='w3-tiny'>b20</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b21' type='checkbox' <?php if($access['b21']==1){ echo "checked";} ?> >&nbsp;Edit Organizations&nbsp;<span class='w3-tiny'>b21</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b15' type='checkbox' <?php if($access['b15']==1){ echo "checked";} ?> >&nbsp;Edit Trainings&nbsp;<span class='w3-tiny'>b15</span></td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='b16' type='checkbox' <?php if($access['b16']==1){ echo "checked";} ?> >&nbsp;Edit Payroll Details&nbsp;<span class='w3-tiny'>b16</span></td></tr>
	   <tr><td colspan='2'>&nbsp;</td></tr>
	</table>
	<!--Access checkbox for Personnel End ------->
	
		

    <!--Access checkbox for Supply and Procurement Start ------->
	<table class='table w3-light-gray'>
    <tr><td colspan='2'><input name='c1' type='checkbox' <?php if($access['c1']==1){ echo "checked";} ?> >&nbsp;<strong>SUPPLY AND PROCUREMENT</strong>&nbsp;<span class='w3-tiny'>c1</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='c2' type='checkbox' <?php if($access['c2']==1){ echo "checked";} ?> >&nbsp;SUPPLY AND PROCUREMENT&nbsp;<span class='w3-tiny'>c2</td></tr>
       <tr><td colspan='2'>&nbsp;</td></tr>
	</table>
	<!--Access checkbox for Supply and Procurement End ------->
	
	
	<!--Access checkbox for Inventory Start ------->
	<table class='table w3-light-gray'>
    <tr><td colspan='2'><input name='i1' type='checkbox' <?php if($access['i1']==1){ echo "checked";} ?> >&nbsp;<strong>INVENTORY</strong>&nbsp;<span class='w3-tiny'>i1</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='i2' type='checkbox' <?php if($access['i2']==1){ echo "checked";} ?> >&nbsp;Input Inventory Item&nbsp;<span class='w3-tiny'>i2</td></tr>
       <tr><td colspan='2'>&nbsp;</td></tr>
	</table>
	<!--Access checkbox for Inventory End ------->
	

	<!--Access checkbox for Memo Central Start ------->
	<table class='table w3-light-gray'>
    <tr><td colspan='2'><input name='m1' type='checkbox' <?php if($access['m1']==1){ echo "checked";} ?> >&nbsp;<strong>MEMO CENTRAL</strong>&nbsp;<span class='w3-tiny'>m1</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='m2' type='checkbox' <?php if($access['m2']==1){ echo "checked";} ?> >&nbsp;Content Administrator&nbsp;<span class='w3-tiny'>m2</td></tr>
       <tr><td>&nbsp;&nbsp;</td><td><input name='m3' type='checkbox' <?php if($access['m3']==1){ echo "checked";} ?> >&nbsp;Memo Central System Administrator&nbsp;<span class='w3-tiny'>m3</td></tr>
	   
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m17' type='checkbox' <?php if($access['m17']==1){ echo "checked";} ?> >&nbsp;Viewing for GOC&nbsp;<span class='w3-tiny'>m17</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m4' type='checkbox' <?php if($access['m4']==1){ echo "checked";} ?> >&nbsp;Viewing Only for LilyHill Trading&nbsp;<span class='w3-tiny'>m4</td></tr>
       <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m5' type='checkbox' <?php if($access['m5']==1){ echo "checked";} ?> >&nbsp;Viewing Only for ALC Printing House&nbsp;<span class='w3-tiny'>m5</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m6' type='checkbox' <?php if($access['m6']==1){ echo "checked";} ?> >&nbsp;Viewing Only for Katrinkas Kitchen&nbsp;<span class='w3-tiny'>m6</td></tr>
       <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m7' type='checkbox' <?php if($access['m7']==1){ echo "checked";} ?> >&nbsp;Viewing Only for Luis YC Builders and Supply&nbsp;<span class='w3-tiny'>m7</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m8' type='checkbox' <?php if($access['m8']==1){ echo "checked";} ?> >&nbsp;Viewing Only for Circon Businessmans Inn&nbsp;<span class='w3-tiny'>m8</td></tr>
       <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m9' type='checkbox' <?php if($access['m9']==1){ echo "checked";} ?> >&nbsp;Viewing Only for Kalipayan Travel and Tours&nbsp;<span class='w3-tiny'>m9</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m10' type='checkbox' <?php if($access['m10']==1){ echo "checked";} ?> >&nbsp;Viewing Only for AKC Country Home&nbsp;<span class='w3-tiny'>m10</td></tr>
       <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m11' type='checkbox' <?php if($access['m11']==1){ echo "checked";} ?> >&nbsp;Viewing Only for Maccool It Arcondition Trading&nbsp;<span class='w3-tiny'>m11</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m12' type='checkbox' <?php if($access['m12']==1){ echo "checked";} ?> >&nbsp;Viewing Only for AKC Van Rental&nbsp;<span class='w3-tiny'>m12</td></tr>
       <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m13' type='checkbox' <?php if($access['m13']==1){ echo "checked";} ?> >&nbsp;Viewing Only for Adplus Trading Corporation&nbsp;<span class='w3-tiny'>m13</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m14' type='checkbox' <?php if($access['m14']==1){ echo "checked";} ?> >&nbsp;Viewing Only for Finance department&nbsp;<span class='w3-tiny'>m14</td></tr>
       <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m15' type='checkbox' <?php if($access['m15']==1){ echo "checked";} ?> >&nbsp;Viewing Only for Treasury department&nbsp;<span class='w3-tiny'>m15</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;<input name='m16' type='checkbox' <?php if($access['m16']==1){ echo "checked";} ?> >&nbsp;Viewing Only for HR department&nbsp;<span class='w3-tiny'>m16</td></tr>
       
		<tr><td colspan='2'>&nbsp;</td></tr>
	</table>
	<!--Access checkbox for Memo Central End ------->


	
	<!--Access checkbox for Accounting Start ------->
	<table class='table w3-light-gray'>
    <tr><td colspan='2'><input name='f1' type='checkbox' <?php if($access['f1']==1){ echo "checked";} ?> >&nbsp;<strong>ACCOUNTING</strong>&nbsp;<span class='w3-tiny'>f1</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='f2' type='checkbox' <?php if($access['f2']==1){ echo "checked";} ?> >&nbsp;ACCOUNTING&nbsp;<span class='w3-tiny'>f2</td></tr>
       <tr><td colspan='2'>&nbsp;</td></tr>
	</table>
	<!--Access checkbox for Accounting End ------->
    
		

    <!--Access checkbox for Sales Start ------->
	<table class='table w3-light-gray'>
		<tr><td colspan='2'><input name='d1' type='checkbox' <?php if($access['d1']==1){ echo "checked";} ?> >&nbsp;<strong>SALES</strong>&nbsp;<span class='w3-tiny'>d1</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d2' type='checkbox' <?php if($access['d2']==1){ echo "checked";} ?> >&nbsp;New Jobs&nbsp;<span class='w3-tiny'>d2</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d3' type='checkbox' <?php if($access['d3']==1){ echo "checked";} ?> >&nbsp;Create Quotation&nbsp;<span class='w3-tiny'>d3</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='d5' type='checkbox' <?php if($access['d5']==1){ echo "checked";} ?> >&nbsp;Quotation Add Details&nbsp;<span class='w3-tiny'>d5</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='d6' type='checkbox' <?php if($access['d6']==1){ echo "checked";} ?> >&nbsp;Quotation View Details&nbsp;<span class='w3-tiny'>d6</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d4' type='checkbox' <?php if($access['d4']==1){ echo "checked";} ?> >&nbsp;Add Booking&nbsp;<span class='w3-tiny'>d4</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='d7' type='checkbox' <?php if($access['d7']==1){ echo "checked";} ?> >&nbsp;Booking Add Details&nbsp;<span class='w3-tiny'>d7</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='d8' type='checkbox' <?php if($access['d8']==1){ echo "checked";} ?> >&nbsp;Booking View Details&nbsp;<span class='w3-tiny'>d8</td></tr>
		<tr class='w3-tiny'><td></td><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-------</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d13' type='checkbox' <?php if($access['d13']==1){ echo "checked";} ?> >&nbsp;Approve Quotation / Booking&nbsp;<span class='w3-tiny'>d13</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d12' type='checkbox' <?php if($access['d12']==1){ echo "checked";} ?> >&nbsp;Cancel Quotation / Booking&nbsp;<span class='w3-tiny'>d12</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d14' type='checkbox' <?php if($access['d14']==1){ echo "checked";} ?> >&nbsp;Add Item Quotation / Booking&nbsp;<span class='w3-tiny'>d14</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d15' type='checkbox' <?php if($access['d15']==1){ echo "checked";} ?> >&nbsp;Delete Item Quotation / Booking&nbsp;<span class='w3-tiny'>d15</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d29' type='checkbox' <?php if($access['d29']==1){ echo "checked";} ?> >&nbsp;DR BACK POSTING&nbsp;<span class='w3-tiny'>d29</td></tr>
		<tr class='w3-tiny'><td></td><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-------</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d11' type='checkbox' <?php if($access['d11']==1){ echo "checked";} ?> >&nbsp;Assign Artist / Production&nbsp;<span class='w3-tiny'>d11</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d9' type='checkbox' <?php if($access['d9']==1){ echo "checked";} ?> >&nbsp;Progress&nbsp;<span class='w3-tiny'>d9</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='d16' type='checkbox' <?php if($access['d16']==1){ echo "checked";} ?> >&nbsp;Add JO Send Progress&nbsp;<span class='w3-tiny'>d16</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d10' type='checkbox' <?php if($access['d10']==1){ echo "checked";} ?> >&nbsp;Payment&nbsp;<span class='w3-tiny'>d10</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='d17' type='checkbox' <?php if($access['d17']==1){ echo "checked";} ?> >&nbsp;Post Payment&nbsp;<span class='w3-tiny'>d17</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='d28' type='checkbox' <?php if($access['d28']==1){ echo "checked";} ?> >&nbsp;BackPosting Payment&nbsp;<span class='w3-tiny'>d28</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d18' type='checkbox' <?php if($access['d18']==1){ echo "checked";} ?> >&nbsp;JO Complete&nbsp;<span class='w3-tiny'>d18</td></tr>
		
		<tr><td>&nbsp;&nbsp;</td><td><input name='d19' type='checkbox' <?php if($access['d19']==1){ echo "checked";} ?> >&nbsp;Clients&nbsp;<span class='w3-tiny'>d19</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='d25' type='checkbox' <?php if($access['d25']==1){ echo "checked";} ?> >&nbsp;Clients Override&nbsp;<span class='w3-tiny'>d25</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d20' type='checkbox' <?php if($access['d20']==1){ echo "checked";} ?> >&nbsp;Quotations&nbsp;<span class='w3-tiny'>d20</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d21' type='checkbox' <?php if($access['d21']==1){ echo "checked";} ?> >&nbsp;Bookings&nbsp;<span class='w3-tiny'>d21</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d22' type='checkbox' <?php if($access['d22']==1){ echo "checked";} ?> >&nbsp;JO List&nbsp;<span class='w3-tiny'>d22</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d23' type='checkbox' <?php if($access['d23']==1){ echo "checked";} ?> >&nbsp;Monitoring&nbsp;<span class='w3-tiny'>d23</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d24' type='checkbox' <?php if($access['d24']==1){ echo "checked";} ?> >&nbsp;Add Product Code&nbsp;<span class='w3-tiny'>d24</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d26' type='checkbox' <?php if($access['d26']==1){ echo "checked";} ?> >&nbsp;Cashier Tools&nbsp;<span class='w3-tiny'>d26</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d27' type='checkbox' <?php if($access['d27']==1){ echo "checked";} ?> >&nbsp;Sales Tools&nbsp;<span class='w3-tiny'>d27</td></tr>
		<tr><td>&nbsp;&nbsp;</td><td><input name='d30' type='checkbox' <?php if($access['d30']==1){ echo "checked";} ?> >&nbsp;JO/BO/DR/OR Finder Tools&nbsp;<span class='w3-tiny'>d30</td></tr>
		
		<tr><td colspan='2'>&nbsp;</td></tr>
	</table>
	<!--Access checkbox for Sales End ------->
	

	<!--Access checkbox for VIP Start ------->
	<table class='table w3-light-gray'>
    <tr><td colspan='2'><input name='vip1' type='checkbox' <?php if($access['vip1']==1){ echo "checked";} ?> >&nbsp;<strong>VIP</strong>&nbsp;<span class='w3-tiny'>vip1</td></tr>
	</table>
	<!--Access checkbox for VIP End ------->
	
	<!--Access checkbox for OR Monitoring ------->
	<table class='table w3-light-gray'>
    <tr><td colspan='2'><input name='p1' type='checkbox' <?php if($access['p1']==1){ echo "checked";} ?> >&nbsp;<strong>O.R. Monitoring</strong>&nbsp;<span class='w3-tiny'>p1</td></tr>
	<tr><td>&nbsp;&nbsp;</td><td><input name='p2' type='checkbox' <?php if($access['p2']==1){ echo "checked";} ?> >&nbsp;SALES: Forward to Pre-Press Button&nbsp;<span class='w3-tiny'>p2</td></tr>
	<tr><td>&nbsp;&nbsp;</td><td><input name='p3' type='checkbox' <?php if($access['p3']==1){ echo "checked";} ?> >&nbsp;PRE-PRESS: Forward to Machine Button&nbsp;<span class='w3-tiny'>p3</td></tr>
	<tr><td>&nbsp;&nbsp;</td><td><input name='p4' type='checkbox' <?php if($access['p4']==1){ echo "checked";} ?> >&nbsp;PRESS: Forward to Numbering / Gather Button&nbsp;<span class='w3-tiny'>p4</td></tr>
	<tr><td>&nbsp;&nbsp;</td><td><input name='p5' type='checkbox' <?php if($access['p5']==1){ echo "checked";} ?> >&nbsp;POST-PRESS: Gather/Stapler/PaperTape/Setting Button&nbsp;<span class='w3-tiny'>p5</td></tr>
	<tr><td>&nbsp;&nbsp;</td><td><input name='p6' type='checkbox' <?php if($access['p6']==1){ echo "checked";} ?> >&nbsp;POST-PRESS: Forward to Sales&nbsp;<span class='w3-tiny'>p6</td></tr>
	</table>
	<!--Access checkbox for OR Monitoring ------->
    
	
	<!--Access checkbox for Setting Start ------->
	<table class='table w3-light-gray'>
    <tr><td colspan='2'><input name='z1' type='checkbox' <?php if($access['z1']==1){ echo "checked";} ?> >&nbsp;<strong>SETTINGS</strong>&nbsp;<span class='w3-tiny'>z1</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='z2' type='checkbox' <?php if($access['z2']==1){ echo "checked";} ?> >&nbsp;User Maintenance&nbsp;<span class='w3-tiny'>z2</td></tr>
       <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='z3' type='checkbox' <?php if($access['z3']==1){ echo "checked";} ?> >&nbsp;Change Password&nbsp;<span class='w3-tiny'>z3</td></tr>		   
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='z4' type='checkbox' <?php if($access['z4']==1){ echo "checked";} ?> >&nbsp;Create User&nbsp;<span class='w3-tiny'>z4</td></tr>	
	   <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input name='z11' type='checkbox' <?php if($access['z11']==1){ echo "checked";} ?> >&nbsp;User Clear/Enable/Disable&nbsp;<span class='w3-tiny'>z11</td></tr>	
	   <tr><td>&nbsp;&nbsp;</td><td><input name='z5' type='checkbox' <?php if($access['z5']==1){ echo "checked";} ?> >&nbsp;User Position&nbsp;<span class='w3-tiny'>z5</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='z6' type='checkbox' <?php if($access['z6']==1){ echo "checked";} ?> >&nbsp;Company Details&nbsp;<span class='w3-tiny'>z6</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='z7' type='checkbox' <?php if($access['z7']==1){ echo "checked";} ?> >&nbsp;Create Access Level&nbsp;<span class='w3-tiny'>z7</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='z8' type='checkbox' <?php if($access['z8']==1){ echo "checked";} ?> >&nbsp;Backup Database&nbsp;<span class='w3-tiny'>z8</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='z9' type='checkbox' <?php if($access['z9']==1){ echo "checked";} ?> >&nbsp;Logbook Viewer&nbsp;<span class='w3-tiny'>z9</td></tr>
	   <tr><td>&nbsp;&nbsp;</td><td><input name='z10' type='checkbox' <?php if($access['z10']==1){ echo "checked";} ?> >&nbsp;Departments&nbsp;<span class='w3-tiny'>z10</td></tr>
	<tr><td colspan='2'>&nbsp;</td></tr>
	</table>
	<!--Access checkbox for Setting End ------->

		
	<div align='center'><input class='btn btn-danger w3-xlarge' type="submit" value="Update Access" onclick="return confirm('Update Access? Sigurado ka?')"></div>
</form>
</div>