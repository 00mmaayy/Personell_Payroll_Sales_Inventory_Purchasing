<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
$jo_no=$_REQUEST['jo_no'];
$username=$_SESSION['username'];

if(isset($_REQUEST['assign_jo']))
  {
	$assign_to=$_REQUEST['assign_to'];
	mysql_query("insert into sales_jo_assign (jo_no,assign_to,assign_date) values ($jo_no,'$assign_to',now())") or die(mysql_error());
	
	$jo_msg="Assigned Artist: $assign_to";
	mysql_query("insert into sales_jo_progress (jo_no,jo_msg,jo_msg_by,date,time) values ($jo_no,'$jo_msg','$username',curdate(),curtime())") or die(mysql_error());
  
	$trans="assign $assign_to to $jo_no";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('Location: script_sales_jo_assign.php?client='.$_REQUEST['client'].'&jo_no='.$_REQUEST['jo_no']);
  }

  ?>
<br>
<div class='container'>

	<table class='table'>
		<tr class='w3-light-gray'>
			<td><b><?php echo $_REQUEST['client']; ?></b></td><td>JO No. <b class='w3-text-red'><?php echo $_REQUEST['jo_no']; ?></b></td>
		</tr>
		<tr>
			<?php
			$s="select * from sales_jo_assign where jo_no=$jo_no";
			$q=mysql_query($s) or die(mysql_error());
			$r=mysql_fetch_assoc($q);
			?>
			<td>Assigned Artist: <b class='w3-text-indigo'><?php echo $r['assign_to']; ?></b> </td>
			<td>Assigned Date: <b class='w3-text-indigo'><?php echo date('h:ia / D F d, Y',strtotime($r['assign_date'])); ?></b> </td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>
			<?php if($r['assign_to']=="")
		          { ?>
			Choose Artist or Destination
			    <form method='get'>
				<?php
				$sz="select e_lname,e_fname from employee where e_job_title like '%Artist%' and e_employment_status!='Resigned' and e_employment_status!='NotConnected' order by e_lname asc";
				$qz=mysql_query($sz) or die(mysql_error());
				$rz=mysql_fetch_assoc($qz);
				echo "<select required name='assign_to' class='form-control'>";
					echo "<option value='' disabled selected>none</option>";
				do{
				echo "<option>".$rz['e_lname'].", ".$rz['e_fname']."</option>";	
				}while($rz=mysql_fetch_assoc($qz));
				echo "</select>";
				?>
			</td>
			<td>
				<br>
		  	<input name='client' type='hidden' value='<?php echo $_REQUEST['client']; ?>'>
				<input name='jo_no' type='hidden' value='<?php echo $_REQUEST['jo_no']; ?>'>
				<input class='btn btn-danger' name='assign_jo' type='submit' value='ASSIGN ARTIST / PRODUCTION TEAM' onclick='return confirm("ASSIGN NOW?")'>
			<?php } 
			 else {} ?>
				</form>
			</td>
		</tr>
	</table>	

</div>

<div align='center'><a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a></div>