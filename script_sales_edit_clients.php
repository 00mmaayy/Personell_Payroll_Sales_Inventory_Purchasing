<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
if(isset($_REQUEST['override_success'])){ echo "<span class='w3-text-green w3-xxlarge'>override_success!</span>"; }

$client_id=$_REQUEST['client_id'];
$s="SELECT * FROM sales_clients where client_id=$client_id";
$q=mysql_query($s);
$r=mysql_fetch_assoc($q);

if(isset($_REQUEST['name']))
{
	$client_id=$_REQUEST['client_id'];
	$name=$_REQUEST['name'];
	mysql_query("UPDATE sales_clients SET name='$name' WHERE client_id=$client_id ");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id new name $name";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?client_id='.$_REQUEST['client_id']);
}

if(isset($_REQUEST['tin']))
{
	$client_id=$_REQUEST['client_id'];
	$tin=$_REQUEST['tin'];
	mysql_query("UPDATE sales_clients SET tin='$tin' WHERE client_id=$client_id ");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id new tin $tin";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?client_id='.$_REQUEST['client_id']);
}

if(isset($_REQUEST['address']))
{
	$client_id=$_REQUEST['client_id'];
	$address=$_REQUEST['address'];
	mysql_query("UPDATE sales_clients SET address='$address' WHERE client_id=$client_id ");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id new address $address";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?client_id='.$_REQUEST['client_id']);
}

if(isset($_REQUEST['mobile']))
{
	$client_id=$_REQUEST['client_id'];
	$mobile=$_REQUEST['mobile'];
	mysql_query("UPDATE sales_clients SET mobile='$mobile' WHERE client_id=$client_id ");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id new mobile $mobile";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?client_id='.$_REQUEST['client_id']);
}

if(isset($_REQUEST['telno']))
{
	$client_id=$_REQUEST['client_id'];
	$telno=$_REQUEST['telno'];
	mysql_query("UPDATE sales_clients SET telno='$telno' WHERE client_id=$client_id") or die(mysql_error());
	
	$username=$_SESSION['username'];
	$trans="update client id $client_id new telno $telno";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?client_id='.$_REQUEST['client_id']);
}

if(isset($_REQUEST['contact_person']))
{
	$client_id=$_REQUEST['client_id'];
	$contact_person=$_REQUEST['contact_person'];
	mysql_query("UPDATE sales_clients SET contact_person='$contact_person' WHERE client_id=$client_id ");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id new contact person $contact_person";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?client_id='.$_REQUEST['client_id']);
}

if(isset($_REQUEST['email']))
{
	$client_id=$_REQUEST['client_id'];
	$email=$_REQUEST['email'];
	mysql_query("UPDATE sales_clients SET email='$email' WHERE client_id=$client_id ");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id new email $email";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?client_id='.$_REQUEST['client_id']);
}


//----------------------------------------------
if(isset($_REQUEST['vip']))
{
	$id=$_REQUEST['id'];
	$client_id=$_REQUEST['client_id'];
	$vip=$_REQUEST['vip'];
	mysql_query("UPDATE sales_clients SET vip='$vip' WHERE client_id=$client_id ");
	mysql_query("DELETE FROM sales_client_override WHERE id='$id'");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id client_category status = $vip";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?override_success=1');
}

if(isset($_REQUEST['terms']))
{
	$id=$_REQUEST['id'];
	$client_id=$_REQUEST['client_id'];
	$terms=$_REQUEST['terms'];
	mysql_query("UPDATE sales_clients SET terms='$terms' WHERE client_id=$client_id ");
	mysql_query("DELETE FROM sales_client_override WHERE id='$id'");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id terms status = $terms";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?override_success=1');
}

if(isset($_REQUEST['credit_limit']))
{
	$id=$_REQUEST['id'];
	$client_id=$_REQUEST['client_id'];
	$credit_limit=$_REQUEST['credit_limit'];
	
	mysql_query("UPDATE sales_clients SET credit_limit='$credit_limit' WHERE client_id=$client_id ");
	mysql_query("DELETE FROM sales_client_override WHERE id='$id'");
	
	$username=$_SESSION['username'];
	$trans="update sales client id $client_id credit_limit status = $credit_limit";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('location: script_sales_edit_clients.php?override_success=1');
}
//----------------------------------------------


if(isset($_REQUEST['client_id']))
{

?>
<br>
<div class='container'>
	<table class='table'>
		<tr>
			<td>ID</td>
			<td colspan='3'><?php echo $r['client_id']; ?></td>
		</tr>
		
		
		<tr>
			<td>CLIENT NAME</td>
			<td><?php echo $r['name']; ?></td>
			
				<form method='get'>
				<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
			<td>
				<input class='form-control' name='name' type='text' value='<?php echo $r['name']; ?>'>
			</td>
			<td>
				<input class='btn btn-danger' type='submit' value='UPDATE' onclick='return confirm("UPDATE NOW?")'>
			</td>
				</form>
		</tr>
		
		<tr>
			<td>TIN</td>
			<td><?php echo $r['tin']; ?></td>
			
				<form method='get'>
				<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
			<td>
				<input class='form-control' name='tin' type='text' value='<?php echo $r['tin']; ?>'>
			</td>
			<td>
				<input class='btn btn-danger' type='submit' value='UPDATE' onclick='return confirm("UPDATE NOW?")'>
			</td>
				</form>
		</tr>
		
		<tr>
			<td>ADDRESS</td>
			<td><?php echo $r['address']; ?></td>
			
				<form method='get'>
				<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
			<td>
				<input class='form-control' name='address' type='text' value='<?php echo $r['address']; ?>'>
			</td>
			<td>
				<input class='btn btn-danger' type='submit' value='UPDATE' onclick='return confirm("UPDATE NOW?")'>
			</td>
				</form>
		</tr>
		
		
		<tr>
			<td>MOBILE NO.</td>
			<td><?php echo $r['mobile']; ?></td>
			
				<form method='get'>
				<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
			<td>
				<input class='form-control' name='mobile' type='text' value='<?php echo $r['mobile']; ?>'>
			</td>
			<td>
				<input class='btn btn-danger' type='submit' value='UPDATE' onclick='return confirm("UPDATE NOW?")'>
			</td>
				</form>
		</tr>
		
		
		<tr>
			<td>TEL NO.</td>
			<td><?php echo $r['telno']; ?></td>
			
				<form method='get'>
				<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
			<td>
				<input class='form-control' name='telno' type='text' value='<?php echo $r['telno']; ?>'>
			</td>
			<td>
				<input class='btn btn-danger' type='submit' value='UPDATE' onclick='return confirm("UPDATE NOW?")'>
			</td>
				</form>
		</tr>
		
		
		<tr>
			<td>CONTACT PERSON</td>
			<td><?php echo $r['contact_person']; ?></td>
			
				<form method='get'>
				<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
			<td>
				<input class='form-control' name='contact_person' type='text' value='<?php echo $r['contact_person']; ?>'>
			</td>
			<td>
				<input class='btn btn-danger' type='submit' value='UPDATE' onclick='return confirm("UPDATE NOW?")'>
			</td>
				</form>
		</tr>
		
		
		<tr>
			<td>EMAIL</td>
			<td><?php echo $r['email']; ?></td>
			
				<form method='get'>
				<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
			<td>
				<input class='form-control' name='email' type='text' value='<?php echo $r['email']; ?>'>
			</td>
			<td>
				<input class='btn btn-danger' type='submit' value='UPDATE' onclick='return confirm("UPDATE NOW?")'>
			</td>
				</form>
		</tr>
		
		
		
		
		
	<?php 
	$so="SELECT * FROM sales_client_override where client_id=$client_id";
	$qo=mysql_query($so);
	$ro=mysql_fetch_assoc($qo);
		
	if(!($ro['id']))
	{ ?>
		
		<tr>
			<td>CATEGORY</td>
			<td>
				<?php if($r['vip']==1){ echo "VIP"; }
				      else if($r['vip']==2){ echo "Government"; }
					  else if($r['vip']==3){ echo "COD"; }
					  else if($r['vip']==4){ echo "X-Deal"; }
					  else if($r['vip']==5){ echo "Account"; }
					  else{ echo "Cash";}    
				?>
			</td>
			
			<form method='get' action='script_sales_override.php'>
			<td>	
				<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
				<select class='form-control' name='vip_x'>
					<option></option>
					<option value='0'>Cash</option>
					<option value='1'>VIP</option>
					<option value='2'>Government</option>
					<option value='3'>COD</option>
					<option value='4'>X-Deal</option>
					<option value='5'>Account</option>
				</select>
			</td>
			<td><input class='btn btn-danger' type='submit' value='REQUEST OVERRIDE' onclick='return confirm("UPDATE NOW?")'></td>	
			</form>
			<?php ?>
			
			
			
		</tr>
		

<?php if($r['vip']!=0)
	    { ?>
				<tr>
					<td>TERMS</td>
					<td><?php if($r['terms']!=0){ echo $r['terms']." days"; }else{} ?></td>
						<td>
							<form method='get' action='script_sales_override.php'>
							<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
							<input class='form-control' name='terms_x' type='number' value='<?php echo $r['terms']; ?>'>
						</td>
						<td><input class='btn btn-danger' type='submit' value='REQUEST OVERRIDE' onclick='return confirm("UPDATE NOW?")'></td>
							</form>
				</tr>
			
				<tr>
					<td>CREDIT LIMIT</td>
					<td><?php echo number_format($r['credit_limit'],2); ?></td>
					<td>
						<form method='get' action='script_sales_override.php'>
						<input name='client_id' type='hidden' value='<?php echo $r['client_id']; ?>'>
						<input class='form-control' name='credit_limit_x' type='text' value='<?php echo $r['credit_limit']; ?>'>
					</td>
					<td><input class='btn btn-danger' type='submit' value='REQUEST OVERRIDE' onclick='return confirm("UPDATE NOW?")'></td>
						</form>
				</tr>
  <?php } 
  
	} else { echo "<tr>
						<td align='center' colspan='4' class='w3-pink w3-xlarge'>";
						switch($ro['trans'])
						{
							case "vip":				echo "CLIENT CATEGORY"; break; 
							case "terms": 			echo "CLIENT TERMS: ".$r['terms']." DAYS TO ".$ro['trans_terms']." DAYS"; break; 
							case "credit_limit": 	echo "CLIENT CREDIT LIMIT: ".number_format($r['credit_limit'],2)." TO ".$ro['trans_credit_limit']; break; 
						}	
						echo "<br/>PENDING: REQUEST OVERRIDE 
						</td>
				   </tr>"; } ?>
		
		
	


	
		
		<tr>
			<td>ADD BY</td>
			<td colspan='3'><?php echo $r['add_by']; ?></td>		
		</tr>
		
		
		<tr>
			<td>ADD DATE</td>
			<td colspan='3'><?php echo $r['add_date']; ?></td>
		</tr>
	</table>
</div>

<?php } ?>

<br><br>
<div align='center'><a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a></div>