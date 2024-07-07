<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");
?>
<br/>
<div class='container'>

<?php
if(isset($_REQUEST['transfer_to']))
{
$id=$_REQUEST['id'];
$transfer_from=$_REQUEST['transfer_from'];
$transfer_to=$_REQUEST['transfer_to'];
mysql_query("update inv_mr set e_no='$transfer_to', department=(select e_department from employee where e_no='$transfer_to') where id='$id'") or die(mysql_error());
mysql_query("insert into inv_transfer_log (id,transfer_from,transfer_to,transfer_date) values ('$id','$transfer_from','$transfer_to',now())") or die(mysql_error());
header('Location: inv_transfer_asset.php?transfer=1&id='.$id.'&e_no='.$transfer_to.'&view_asset=SHOW+ASSIGNED+ASSET');
}

$id=$_REQUEST['id'];
$ss1="select * from inv_mr where id='$id'";
$qq1=mysql_query($ss1) or die(mysql_error());
$rr1=mysql_fetch_assoc($qq1);
$e_no=$rr1['e_no'];

$qeno1=mysql_query("select e_lname,e_fname from employee where e_no=$e_no");
$reno1=mysql_fetch_assoc($qeno1);
$e_lname=$reno1['e_lname'];
$e_fname=$reno1['e_fname'];

echo "<table class='table w3-tiny' border='1'>
		<tr>";
		if($_REQUEST['e_no']=='Damaged')
		{ echo "<td colspan='5'>THIS ASSET IS MARKED AS: <b class='w3-text-red w3-large'>Damaged</b></td>"; }
		else { echo "<td colspan='5'>THIS ASSET IS ASSIGNED TO: <b class='w3-text-red w3-large'>$e_lname, $e_fname</b></td>"; }
			
	  if(isset($_REQUEST['transfer']) and $_REQUEST['e_no']!='Damaged'){
	  echo "<td colspan='5'>TRASFER THIS ASSET TO:";
			$qeno=mysql_query("select e_no,e_lname,e_fname from employee where e_company='ALC' and e_employment_status!='Resigned' and e_employment_status!='NotConnected' order by e_lname asc");
			$reno=mysql_fetch_assoc($qeno);
	  echo "<form>
				<input name='id' type='hidden' value='$id'>
				<input name='e_no' type='hidden' value='$e_no'>
				<input name='transfer_from' type='hidden' value='$e_no'>
				<select name='transfer_to'>
					<option></option><option>Damaged</option>";
				do{
					echo "<option value=".$reno['e_no'].">".$reno['e_lname'].", ".$reno['e_fname']."</option>";
				}while($reno=mysql_fetch_assoc($qeno));
	      echo "</select>"; ?>
				<input type='submit' value='TRANSFER NOW' onclick='return confirm("TRANSFER ASSET NOW?")'>
		<?php 
	  echo "</form>";
	  echo "</td>";
	  }
	  
	echo "</tr>
		<tr class='w3-tiny w3-green' align='center'>
			<td>SERIAL NO</td>
			<td>ASSET TYPE</td>
			<td>DESCRIPTION</td>
			<td>MACHINE</td>
			<td>BRANCH</td>
			<td>DEPARTMENT</td>
			<td>NO OF UNITS</td>
			<td>ACQUISITION COST</td>
			<td>ACQUISITION DATE</td>
			<td>REMARKS</td>
		</tr>			
		<tr>
		  <td>".$rr1['serial_no']."</td>
		  <td>".$rr1['asset_type']."</td>
		  <td>".$rr1['description']."</td>
		  <td>".$rr1['machine']."</td>
		  <td>".$rr1['branch']."</td>
		  <td>".$rr1['department']."</td>
		  <td align='center'>".$rr1['no_of_units']."</td>
		  <td align='right'>".number_format($rr1['acquisition_cost'],2)."</td>
		  <td align='right'>".date('F d, Y',strtotime($rr1['acquisition_date']))."</td>
		  <td>".$rr1['remarks']."</td>
		</tr>
	  </table>";	

if(isset($_REQUEST['transfer_log']))
{
	$id=$_REQUEST['id'];
	$slog="select * from inv_transfer_log where id='$id' order by transfer_date asc";
	$qlog=mysql_query($slog) or die(mysql_error());
	$rlog=mysql_fetch_assoc($qlog);
	echo "<table class='table w3-tiny' border='1'>
			<tr><td>TRANSFER FROM</td><td>TRANSFER TO</td><td>TRANSFER DATE</td></tr>";
		do{
			
			$e_no_from=$rlog['transfer_from'];
			$slog1="select e_lname, e_fname from employee where e_no='$e_no_from'";
			$qlog1=mysql_query($slog1) or die(mysql_error());
			$rlog1=mysql_fetch_assoc($qlog1);
			
			$e_no_to=$rlog['transfer_to'];
			$slog2="select e_lname, e_fname from employee where e_no='$e_no_to'";
			$qlog2=mysql_query($slog2) or die(mysql_error());
			$rlog2=mysql_fetch_assoc($qlog2);
			
			echo "<tr>
					<td>".$e_no_from." ".$rlog1['e_lname'].", ".$rlog1['e_fname']."</td>
					<td>".$e_no_to." ".$rlog2['e_lname'].", ".$rlog2['e_fname']."</td>
					<td>".date('F d, Y H:i:s A',strtotime($rlog['transfer_date']))."</td>
				  </tr>";
		}while($rlog=mysql_fetch_assoc($qlog));
	echo "</table>";
}	
?>
</div>