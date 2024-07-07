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

$spas="select * from user_access where username='$username'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);

if(isset($_REQUEST['submit_msg']))
  {
    $jo_msg=$_REQUEST['jo_msg'];
	mysql_query("insert into sales_jo_progress (jo_no,jo_msg,jo_msg_by,date,time) values ('$jo_no','$jo_msg','$username',curdate(),curtime())") or die(mysql_error());
  
    $trans="jo msg inserted by $username $jo_no";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	$location='Location: script_sales_jo_progress.php?jo_no='.$_REQUEST['jo_no'];
	header($location);
  }	

$q=mysql_query("select * from sales_jo_progress where jo_no='$jo_no' order by date desc, time desc") or die(mysql_error());  
$r=mysql_fetch_assoc($q);  

$q1=mysql_query("select * from sales_jo where jo_no='$jo_no'") or die(mysql_error());  
$r1=mysql_fetch_assoc($q1);

?>

<div class='container'>
<?php 
     echo "<br><div align='center' class='w3-large'>JOB ORDER PROGRESS TRACKING</div><br>";
	 echo "<span class='w3-tiny'>JO No.</span> <b class='w3-text-red'>".$r1['jo_no']."</b><br>";
	 echo "<span class='w3-tiny'>Client: </span> <b class='w3-text-indigo'>".$_REQUEST['client']."</b><br>";
	 echo "<span class='w3-tiny'>Amount:</span> <b class='w3-text-red'>".number_format($r1['jo_amount'],2)."</b><br>";
	 echo "<span class='w3-tiny'>JO Date:</span> <b class='w3-text-red'>".date('h:ia / D F d, Y',strtotime($r1['created_datetime']))."</b><br>";
	 echo "<span class='w3-tiny'>Assign to:</span> <b class='w3-text-red'></b>";
	 echo "<br><br>"; 

?>

	<table class='table'>
<?php do { ?>  
		  <tr>
			<td>
			  <?php echo "<span class='w3-tiny'>".date('h:ia',strtotime($r['time']))." ".date('D F d, Y',strtotime($r['date']))."</span><br><b class='w3-text-orange'>".$r['jo_msg_by']."</b> : ".$r['jo_msg']; ?> 
			</td>
		  </tr>
<?php } while ($r=mysql_fetch_assoc($q)); ?>   		  
	</table>
</div>

		<?php if($access['d16']==1){ ?>
		<div class='container'>
          <table width='100%'> 
		     <tr>
			 
				<?php if($r1['completed_by']==""){ ?>
			    <form method='post'>
					 <input name='jo_no' type='hidden' value='<?php echo $jo_no; ?>'>
				 <td><input required class='form-control' name='jo_msg' type='text' placeholder='Input Message Here'></td>
				 <td>&nbsp;</td>
				 <td width='100'><input class='form-control btn-danger' name='submit_msg' type='submit' value='SEND' onclick='return confirm("Add your Messege?")'></td>
				</form>
				<?php } ?>
				
			 </tr>  
		  </table>	   
		</div>
		<?php } ?>

<br><br>
<div align='center'><a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a></div>