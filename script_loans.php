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

<div class='container col-xs-6'>



<?php
//INSERT OFFENSE DETAILS TO EMPLOYEE START----
if(isset($_REQUEST['add_offense_details']))
  {
	
    $e_no=$_REQUEST['e_no'];
	$class_type=$_REQUEST['class_type'];
	$class_no1=$_REQUEST['class_no1'];
	$class_no2=$_REQUEST['class_no2'];
	$reference=$_REQUEST['reference'];
	$remarks=$_REQUEST['remarks'];
	$offense_date=$_REQUEST['offense_date'];
	$username=$_SESSION['username'];
	
	mysql_query("insert into employee_offense (e_no,class_type,class_no1,class_no2,reference,remarks,offense_date,add_by) values ('$e_no','$class_type','$class_no1','$class_no2','$reference','$remarks','$offense_date','$username')") or die(mysql_error());
    header('Location: script_offense.php?e_no='.$_REQUEST['e_no'].'&add_offense=&success=1');
  }
//INSERT OFFENSE DETAILS TO EMPLOYEE END----
  
  
  
//ADD OFFENSE TO EMPLOYEE DATABASE START----
if(isset($_REQUEST['add_offense']))
  { 
	echo "<br>";
	$e_no=$_REQUEST['e_no'];
	if(isset($_REQUEST['success'])){ echo "<b class='w3-text-green w3-xxlarge'>Add Loans Success!!!</b>"; }
	echo "<table class='table' border='1'>";
	echo "<tr class='w3-dark-gray'><td colspan='2'>ADD LOANS DETAILS<br>".$_REQUEST['name']."</td></tr>";
	echo "<tr>
			<td>Loan Type</td>
			<form method='get'>
			<input name='e_no' type='hidden' value='".$_REQUEST['e_no']."'>
			<td>
			   <select class='form-control' required name='class_type'>
					<option></option>
					<option>CLASS I</option>
					<option>CLASS II</option>
					<option>CLASS III</option>
				</select>
			</td>
		  </tr>";
	echo "<tr>
			<td>Class Type</td>
			<td>
			   <select class='form-control' required name='class_no1'>
					<option></option>
					<option>A</option>
					<option>B</option>
					<option>C</option>
					<option>E</option>
					<option>F</option>
				</select>
			</td>
		  </tr>";	  
	echo "<tr>
			<td>Class No.</td>
			<td><input class='form-control' required name='class_no2' type='number'></td>
		  </tr>";
	echo "<tr>
			<td>Reference</td>
			<td><input class='form-control' required name='reference' type='text'></td>
		  </tr>";	  
	echo "<tr>
			<td>Remarks</td>
			<td><input class='form-control' required name='remarks' type='text'></td>
		  </tr>";
    echo "<tr>
			<td>Offense Date</td>
			<td><input class='form-control' required name='offense_date' type='date'></td>
		  </tr>";
    echo "<tr align='center'>
			<td colspan='2'>"; ?>
				<input name='add_offense_details' class='btn-info form-control' type='submit' value='SUBMIT' onclick='return confirm("Add Offense to Employee Now?")'>
			</form>	
            </td>
		  </tr>		  
         </table> 
	
	<div align='center'>
			<a class='w3-xxlarge' href="javascript:window.open('','_self').close();">X</a>
	</div>

<?php 
   } 
//ADD OFFENSE DETAILS TO EMPLOYEE DATABASE END----  
?>
</div>




<div class='container'>
<?php
//OFFENSE HISTORY START-----
if(isset($_REQUEST['offense_history']))
  {
    echo "<br>";
	$e_no=$_REQUEST['e_no'];
	$q=mysql_query("select * from employee_offense where e_no='$e_no' order by offense_date desc") or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	echo "<table class='table' border='1'>";
	echo "<tr class='w3-dark-gray'><td colspan='6'>LOANS HISTORY<br>".$_REQUEST['name']."</td></tr>";
	echo "<tr>
			<td>Loan Type</td>
			<td>Loan Amount</td>
			<td>Reference</td>
			<td>Remarks</td>
			<td>Offense Date</td>
			<td>Posted by</td>
		  </tr>";
		  
	echo "<tr>
			<td>".$r['class_type']."</td>
			<td>".$r['class_no1']."".$r['class_no2']."</td>
			<td>".$r['reference']."</td>
			<td>".$r['remarks']."</td>
			<td>".date('m/d/Y',strtotime($r['offense_date']))."</td>
			<td>".$r['add_by']."</td>
		  </tr>";
		  
    echo "</table>"; ?>
	<div align='center'><a class='w3-xxlarge' href="javascript:window.open('','_self').close();">X</a></div>
<?php
  }
//OFFENSE HISTORY END-----  
?>
</div>
