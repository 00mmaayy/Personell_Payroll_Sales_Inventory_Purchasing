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
echo "<strong>Current User is: <span class='w3-red'>&nbsp;".$_SESSION['username']."&nbsp;</span></strong>";
if(isset($_REQUEST['edit']))
{
     if(isset($_REQUEST['e_basic_pay']))
     {
	  $e_no=$_REQUEST['e_no'];
	  $value=$_REQUEST['e_basic_pay'];
	  $field="e_basic_pay";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_batch_comp.php');
	 }
	 
	 
	 if(isset($_REQUEST['e_tax']))
     {
	  $e_no=$_REQUEST['e_no'];
	  $value=$_REQUEST['e_tax'];
	  $field="e_tax";
	  
	  $sx="update employee set $field='$value' where e_no='$e_no'"; 
      $qx=mysql_query($sx) or die(mysql_error());
	  $user=$_SESSION['username'];
	  $trans=addslashes($sx);
      $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
      $log_query=mysql_query($log_sql) or die(mysql_error());
	  header('Location:script_batch_comp.php');
	 }

}	 
	
$s="select * from employee order by e_no asc";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<table border='1' class='table-hover'>
        <tr class='w3-blue' align='center'>
		  <td width='100'>ID No</td>
		  <td width='100'>Name</td>
		  <td class='w3-green' width='100'>Basic</td>
		  <td class='w3-green' width='100'>W-Tax</td>
		  <td class='w3-red' width='100'>Basic</td>
		  <td class='w3-red' width='100'>W-Tax</td>
		</tr>";

do{

echo "<tr><td>".$r['e_no']."</td>
          <td>".$r['e_lname'].", ".$r['e_fname']."</td>
		  <td align='right'>".number_format($r['e_basic_pay'],2)."</td>
		  <td align='right'>".number_format($r['e_tax'],2)."</td>
		  <form method='get'>
		  <input name='e_no' type='hidden' value='".$r['e_no']."'>
		  <td><input value='".$r['e_basic_pay']."' required type='number' name='e_basic_pay' step='any'></td>
		  <td><input value='".$r['e_tax']."' required type='number' name='e_tax' step='any'></td>
		  <td><input name='edit' type='submit' value='update'>
		  </form></td>
		  </tr>";

 } while($r=mysql_fetch_assoc($q)); ?>
</table>