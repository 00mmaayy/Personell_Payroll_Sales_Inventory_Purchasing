<?php 
include('connection/conn.php');
session_start();
date_default_timezone_set("Asia/Manila");
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>

<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<style>
img.routing_slip { position: absolute; z-index: -1;}
div.routing { position: absolute; left: 900px; top: 30px; z-index: -1; }
div.jo_no { position: absolute; left: 1000px; top: 130px; z-index: -1; }
div.client { position: absolute; left: 20px; top: 135px; z-index: -1; }
div.particular { position: absolute; left: 20px; top: 220px; z-index: -1; }
div.qty { position: absolute; left: 30px; top: 325px; z-index: -1; }
div.size { position: absolute; left: 400px; top: 325px; z-index: -1; }
div.material { position: absolute; left: 900px; top: 225px; z-index: -1; }
div.created_datetime { position: absolute; left: 620px; top: 135px; z-index: -1; }
div.created_by { position: absolute; left: 160px; top: 600px; z-index: -1; }
div.assign_to { position: absolute; left: 800px; top: 480px; z-index: -1; }
</style>

<?php
$username=$_SESSION['username'];

//insert new routing data
$s_user_bch="SELECT bch FROM users WHERE username='$username'";
$q_user_bch=mysql_query($s_user_bch) or die(mysql_query());
$r_user_bch=mysql_fetch_assoc($q_user_bch);

$bch=$r_user_bch['bch'];

//client details
$jo_no=$_REQUEST['jo_no'];

$s="select a.client_id as client_id,
		   a.created_datetime as created_datetime,
		   a.created_by as created_by,
		   b.name as name,
		   c.first_name as first_name,
		   c.last_name as last_name
	from sales_jo as a
	inner join sales_clients as b on b.client_id=a.client_id
	inner join users as c on c.username=a.created_by
	where a.jo_no=$jo_no";
$q=mysql_query($s);
$r=mysql_fetch_assoc($q);

//for artist query only
$s1="select assign_to from sales_jo_assign where jo_no='$jo_no'";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);

//for booking details
$b_count=$_REQUEST['b_count'];

$s2="select a.b_desc as b_desc,
			a.b_size as b_size,
			a.b_qty as b_qty,
			a.b_unit as b_unit,
			b.code_set as code_set,
			b.code_name as code_name,
			b.code_desc as code_desc
     from sales_bookings_details as a
	 inner join sales_codes as b on a.code_set=b.code_set
	 where a.b_count='$b_count'";
$q2=mysql_query($s2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);

//for artist query only
$s3="select bch, routing_no, b_count from sales_jo_routing where b_count='$b_count'";
$q3=mysql_query($s3) or die(mysql_error());
$r3=mysql_fetch_assoc($q3);
?>

<img class='routing_slip' src='img/JOBROUTINGSLIP.jpg'>
<div class='client w3-xlarge'><b class='w3-text-red'><?php echo $r['name']; ?></b></div>

<div class='particular w3-large'><b class='w3-text-red'><?php echo $r['name'];; ?></b></div>
<div class='qty w3-xlarge'><b class='w3-text-red'><?php echo $r2['b_qty']." ".$r2['b_unit']; ?></b></div>
<div class='size w3-xlarge'><b class='w3-text-red'><?php echo $r2['b_size']; ?></b></div>
<div class='material w3-large'><b class='w3-text-red'><?php echo "(".$r2['code_set'].") ".$r2['code_name']; ?><br/><?php echo $r2['code_desc']; ?></b></div>

<div class='created_datetime w3-xlarge'><b class='w3-text-red'><?php echo date('m/d/Y',strtotime($r['created_datetime'])); ?></b></div>
<div class='jo_no w3-xxlarge'><b class='w3-text-red'><?php echo $_REQUEST['jo_no']; ?></b></div>
<div class='routing'><b class='w3-text-red w3-large'><i><?php echo "<span class='w3-tiny'>(item#".$r3['b_count'].")</span> ROUTING# : ".$r3['bch']."-".$r3['routing_no']; ?></i></b></div>
<div class='created_by w3-xlarge'><b class='w3-text-red'><?php echo $r['first_name']." ".$r['last_name']; ?></b></div>
<div class='assign_to w3-xlarge'><b class='w3-text-red'><?php echo $r1['assign_to']; ?></b></div>

<?php
if(isset($_REQUEST['form']))
{
	$username=$_SESSION['username'];	//routing created by *
	$bch=$r_user_bch['bch'];			//routing branch *
	$jo_no=$_REQUEST['jo_no'];			//jo *
	$b_count=$_REQUEST['b_count'];		//jo details key *
	
	$client_id=$r['client_id'];			//client ID *
	$sales_fname=$r['first_name'];		//sales fname *
	$sales_lname=$r['last_name'];		//sales lname *
	$assign_to=$r1['assign_to'];		//artist/production *
	
	
	$ss="SELECT routing_no FROM sales_jo_routing WHERE bch='$bch' ORDER BY routing_no DESC LIMIT 1";
	$qq=mysql_query($ss) or die(mysql_error());
	$rr=mysql_fetch_assoc($qq);
	$routing_no=$rr['routing_no']+1;
	
	
	$insert_routing="INSERT INTO sales_jo_routing (client_id, b_count, jo_no, sales_fname, sales_lname, assign_to, bch, routing_no, created_by, created_datetime)
				     VALUES ($client_id, $b_count, $jo_no, '$sales_fname', '$sales_lname', '$assign_to', '$bch', $routing_no, '$username', now())";
	mysql_query($insert_routing) or die(mysql_error());
	
	header('Location: script_sales_jo_routing.php?b_count='.$_REQUEST['b_count'].'&jo_no='.$_REQUEST['jo_no']);
}
?>