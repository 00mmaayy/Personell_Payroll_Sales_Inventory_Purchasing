<?php
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
date_default_timezone_set("Asia/Manila");

$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);


if(isset($_REQUEST['production_status']))
{
$prod_stat=$_REQUEST['prod_stat'];	
$jo_no=$_REQUEST['jo_no'];	
$client_id=$_REQUEST['client_id'];
$client=$_REQUEST['client'];
mysql_query("update sales_jo set production_status=$prod_stat, production_date=now() where jo_no='$jo_no'");

$username=$_SESSION['username'];
$trans="set production status to $prod_stat to jo no:$jo_no client:$client set by ".$_SESSION['username']." time: ".date('m/d/Y h:i A')." ";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin_sales.php?client_id='.$_REQUEST['client_id'].'&client='.$_REQUEST['client'].'&sales=1&newjobs=1&create_quotation=1');
}

//for job orders list start
/*
if(isset($_REQUEST['production_status1']))
{
$prod_stat=$_REQUEST['prod_stat'];
$jo_no=$_REQUEST['jo_no'];	
mysql_query("update sales_jo set production_status=$prod_stat, production_date=now() where jo_no='$jo_no'");

$username=$_SESSION['username'];
$trans="set production status to $prod_stat jo no:$jo_no client:$client set by ".$_SESSION['username']." time: ".date('m/d/Y h:i A')."";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

	if(isset($_REQUEST['sdate']))
	{
		$day_sort='&sdate='.$_REQUEST['sdate'].'&edate='.$_REQUEST['edate'].'&user='.$_REQUEST['user'].'&sortby='.$_REQUEST['sortby'];
	
	}else{ $day_sort=''; }

header('Location: admin_sales.php?sales=1&joborders=1'.$day_sort);
}
*/
//for job orders list end


if(isset($_REQUEST['jo_actual']))
{
$jo_no=$_REQUEST['jo_no'];	
$client_id=$_REQUEST['client_id'];
$client=$_REQUEST['client'];
$jo_actual=$_REQUEST['jo_actual'];
$jo_actual_date=$_REQUEST['jo_actual_date'];
mysql_query("update sales_jo set jo_actual='$jo_actual', jo_actual_date='$jo_actual_date' where jo_no='$jo_no'");

$trans="set actual jo $jo_actual $jo_actual_date to jo no $jo_no client $client";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin_sales.php?client_id='.$_REQUEST['client_id'].'&client='.$_REQUEST['client'].'&sales=1&newjobs=1&create_quotation=1');
}

if(isset($_REQUEST['po_no']))
{
$jo_no=$_REQUEST['jo_no'];	
$client_id=$_REQUEST['client_id'];
$client=$_REQUEST['client'];
$po_no=$_REQUEST['po_no'];
$po_date=$_REQUEST['po_date'];
mysql_query("update sales_jo set po_no='$po_no', po_date='$po_date' where jo_no='$jo_no'");

$trans="set po $po_no $po_date to po no $po_no client $client";
$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
$log_query=mysql_query($log_sql) or die(mysql_error());

header('Location: admin_sales.php?client_id='.$_REQUEST['client_id'].'&client='.$_REQUEST['client'].'&sales=1&newjobs=1&create_quotation=1');
}


?>
<!DOCTYPE html>
<html>
<title><?php echo $r['company_name']; ?></title>
<!--<meta http-equiv="Refresh" content="300"> -->
<?php include("css.php"); ?>
<body class="w3-light-grey">
<!-- Top container ----->
<div class="w3-container w3-top w3-green w3-large w3-padding" style="z-index:4">
  <button class="w3-button w3-hide-large w3-padding-0 w3-green w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
<span class="w3-right"><?php echo $r['company_name']; ?></span>
</div>
<!-- Top container ----->
<!-- Sidenav/menu -->
<?php 
include("current_user.php");
$bch=$r9['bch'];
?>
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav">
  <br/>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
	<img src="img/id/<?php echo $r91['e_no']; ?>.jpg" class="w3-circle" style="width:80%">
	</div>
    <div class="w3-col s8 w3-bar">
	<span class="text-primary">Current User:</span><br>
   <span class="text-primary"><strong><?php echo $r9['first_name']." ".$r9['last_name'];?></strong><br>
   <?php echo $r8['pos_description'];?></span>
     </div>
	</div>
<hr>
  
<?php include("menu.php"); ?>

</nav>

<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="mySidenav"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:35px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px"></header>
  <div class="w3-row-padding w3-margin-bottom">

 
<!--Sales Start-------->
<?php if(isset($_REQUEST['sales'])) { ?>   
	<div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
        <div class="w3-left w3-xlarge"><i class="fa fa-calculator w3-xlarge"></i>  Sales</div>
      </div>
	  <br>
 
<?php include('script_sales_artist_notification.php'); ?>
	
	  <!--Sales Menu Start -->
	  <div class="container">
         <ul class="nav nav-tabs">
		  
		<?php include('script_sales_menu_override.php'); ?>
		  
		  <?php if($access['d2']==1){ ?>
		          <?php if(isset($_REQUEST['newjobs'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				   <a href="admin_sales.php?sales=1&newjobs=1">New Jobs</a></li>
		  <?php } ?>
		  
		  <?php if($access['d30']==1){ ?>
		          <?php if(isset($_REQUEST['jo_finder'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				   <a href="script_sales_jo_finder.php" target="_blank">JO/BO/DR/OR Finder</a></li>
		  <?php } ?>
		  
		  <?php if($access['d19']==1){ ?>
		         <?php if(isset($_REQUEST['clients'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				 <a href="admin_sales.php?sales=1&clients=1">Clients</a></li>
		  <?php } ?>
		  
		  <?php if($access['d21']==1){ ?>
		        <?php if(isset($_REQUEST['bookings'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
		        <a href="admin_sales.php?sales=1&bookings=1">Pending Bookings</a></li>
		  <?php } ?>
		  
		  <?php if($access['d22']==1){ ?>
		        <?php if(isset($_REQUEST['joborders'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_sales.php?sales=1&joborders=1">Job Orders</a></li>
		  <?php } ?>
		  
		  <?php if($access['d23']==1){ ?>
				<?php if(isset($_REQUEST['monitoring'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_sales.php?sales=1&monitoring=1">Reports / Monitoring</a></li>
		  <?php } ?>
		  
		        <?php if(isset($_REQUEST['guides'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
		        <a href="admin_sales.php?sales=1&guides=1">Product Code Guides</a></li>
				
		  <?php if($access['vip1']==1){ ?>
				<?php if(isset($_REQUEST['it_tool'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="script_sales_jo_details_search_area.php" target="_blank">IT Tools</a></li>
		  <?php } ?>	

		  
		  <?php if(isset($_REQUEST['routing'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href=<?php echo 'script_sales_routing_forms.php?bch='.$bch; ?> target='_blank'>Routing</a></li>
		  
		  <?php if(isset($_REQUEST['finish_goods'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href=<?php echo 'script_sales_fg.php?search=finish_goods&branch=ALL&bch='.$bch; ?> target='_blank'>Finish Goods</a></li>
		
		 </ul>
      </div>
	  <br>
	<!--Sales Menu End -->
	  

<?php
//Contents Here Start
include('script_sales_newjobs.php');
include('script_sales_menuclient.php');	
include('script_sales_bookings.php');
include('script_sales_joborders.php');
include('script_sales_menu_monitoring.php'); 
include('script_sales_product_guide.php');
//Contents Here End
	
} 
?>
<!--Sales End-------->

 </div>

</div>
</body>
</html>

<script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}
</script>  
