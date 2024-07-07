<?php
$hostname = "localhost";
$username= "root";
$password = "1342567890";
$database = "check_monitoring";
$omaryeah = @mysql_connect($hostname,$username,$password) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$omaryeah);
$db=mysql_select_db($database) or die("I Couldn't select your database");
include "css.php";

if(isset($_REQUEST['bank_name']))
{
	$bank_name=$_REQUEST['bank_name'];
	$bank_long_name=$_REQUEST['bank_long_name'];
	mysql_query("INSERT INTO bank_list (bank_name, bank_long_name, add_datetime) VALUES ('$bank_name', '$bank_long_name', now()) ") or die(mysql_error());
	header("Location: check_monitoring.php?add_bank_success=1");
}

else if(isset($_REQUEST['account_name']))
{
	$bank_id=$_REQUEST['bank_id'];
	$account_name=$_REQUEST['account_name'];
	$account_number=$_REQUEST['account_number'];
	mysql_query("INSERT INTO account_list (bank_id,account_name, account_number, add_datetime) VALUES ($bank_id, '$account_name', '$account_number', now()) ") or die(mysql_error());
	header("Location: check_monitoring.php?add_account_success=1");
}
else if(isset($_REQUEST['check_no']))
{
	$account_id=$_REQUEST['account_id'];
	$check_no=$_REQUEST['check_no'];
	$payee=$_REQUEST['payee'];
	$amount=$_REQUEST['amount'];
	$check_date=$_REQUEST['check_date'];
	
	$voucher=$_REQUEST['voucher'];
	$requested_by=$_REQUEST['requested_by'];
	$approved_by=$_REQUEST['approved_by'];
	$audited_by=$_REQUEST['audited_by'];
	$signed_by=$_REQUEST['signed_by'];
	$received_by=$_REQUEST['received_by'];
	$particulars=$_REQUEST['particulars'];
	
	$remarks=addslashes($_REQUEST['remarks']);
	$xx="INSERT INTO check_monitoring 
		(account_id, check_no, payee, amount, check_date, voucher, requested_by, approved_by, audited_by, signed_by, received_by, particulars, remarks, system_posting_datetime) 
		 VALUES 
		($account_id, $check_no, '$payee', $amount, '$check_date', $voucher, '$requested_by', '$approved_by', '$audited_by', '$signed_by', '$received_by', '$particulars', '$remarks', now()) ";
	mysql_query($xx) or die(mysql_error());
	header("Location: check_monitoring.php?add_transaction_success=1&add_transaction=1&account_id=".$_REQUEST['account_id']);
}
else{}


?>
<br/>
<title>CHECK MONITORING</title>


<div align="center">
	<img src='img/check.png'>&nbsp;&nbsp;&nbsp;
	<a class="btn btn-success" href="check_monitoring.php">HOME</a>
	<a class="btn btn-primary" href="check_monitoring.php?add_bank=1">ADD BANK</a>
	<a class="btn btn-primary" href="check_monitoring.php?add_bank_account=1">ADD BANK ACCOUNT</a>
	<a class="btn btn-danger" href="check_monitoring.php?add_check_transaction=1">ADD TRANSACTION</a>
	
<?php
if(isset($_REQUEST['add_bank']))
{ ?>
	<br/><br/>
	<form>
		<input required name="bank_name" type="text" placeholder="BANK INITIALS">
		<input required name="bank_long_name" type="text" placeholder="BANK NAME">
		<input class="btn btn-danger" type="submit" value="ADD BANK NOW" onclick="return confirm('SURE ADD BANK?')">
	</form>
<?php
}
else if(isset($_REQUEST['add_bank_account']))
{
?>
	<br/><br/>
	<form>
		<?php 
		$q1=mysql_query("SELECT bank_id, bank_name FROM bank_list ORDER BY bank_name ASC") or die(mysql_error());
		$r1=mysql_fetch_assoc($q1);
		echo "<select required name='bank_id'>
				<option disabled selected>CHOOSE BANK</option>";
		do{
		echo "<option value='".$r1['bank_id']."'>".$r1['bank_name']."</option>";
		}while($r1=mysql_fetch_assoc($q1));
		echo "</select>";
		?>
		<input required size="30" name="account_name" type="text" placeholder="ACCOUNT NAME">
		<input required size="30" name="account_number" type="text" placeholder="ACCOUNT NUMBER">
		<input class="btn btn-danger" type="submit" value="ADD BANK ACCOUNT NOW" onclick="return confirm('SURE ADD BANK ACCOUNT?')">
	</form>
<?php
}
else if(isset($_REQUEST['add_check_transaction']))
{
?>	
	
	<br/><br/>
	<div align="left" class="container">
	<form>
	
	<table>
	<tr>
	<td>
		<?php
		$s2="SELECT a.account_id, b.bank_name, a.account_name 
			FROM account_list a
			LEFT JOIN bank_list b ON a.bank_id=b.bank_id
			ORDER BY a.account_name ASC";
		$q2=mysql_query($s2) or die(mysql_error());
		$r2=mysql_fetch_assoc($q2);
		echo "<select required name='account_id' class='w3-large'>";
		
				if(isset($_REQUEST['account_id']))
				{ 
					$s5="SELECT a.account_id, b.bank_name, a.account_name 
					FROM account_list a
					LEFT JOIN bank_list b ON a.bank_id=b.bank_id
					WHERE a.account_id=".$_REQUEST['account_id']."";
					$q5=mysql_query($s5) or die(mysql_error());
					$r5=mysql_fetch_assoc($q5);
					
					echo "<option value='".$r5['account_id']."'>".$r5['account_name']." - ".$r5['bank_name']."</option>";
				}
				else
				{ echo "<option disabled selected>CHOOSE ACCOUNT</option>"; }
		do{
		echo "<option value='".$r2['account_id']."'>".$r2['account_name']." - ".$r2['bank_name']."</option>";
		}while($r2=mysql_fetch_assoc($q2));
		echo "</select>";
		?>
	</td>	
	</tr>
	
	<tr>
		<td>CHECK NO</td><td><input required name="check_no" type="number" placeholder="CHECK NO"></td>
		<td width="100"></td>
		<td>REQUESTED BY</td><td><input required name="requested_by" type="text" placeholder="REQUESTED BY"></td>
	</tr>
	<tr>
		<td>PAYEE</td><td><input required name="payee" type="text" placeholder="PAYEE"></td>
		<td width="100"></td>
		<td>APPROVED BY</td><td><input required name="approved_by" type="text" placeholder="APPROVED BY"></td>
	</tr>
	<tr>
		<td>PARTICULARS</td><td><input required name="particulars" type="text" placeholder="PARTICULARS"></td>
		<td width="100"></td>
		<td>AUDITED BY</td><td><input required name="audited_by" type="text" placeholder="AUDITED BY"></td>
	</tr>
	<tr>
		<td>AMOUNT</td><td><input required name="amount" type="number" step="any" placeholder="AMOUNT"></td>
		<td width="100"></td>
		<td>SIGNED BY</td>
		<td>	
		<select required name="signed_by">
			<option disabled selected> --- </option>
			<option>MARIA ANGELA CARINA Y. CASTRO</option>
			<option>ALEX CESAR L. CASTRO</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>CHECK DATE</td><td><input required name="check_date" type="date" value="<?php echo date('Y-m-d'); ?>"></td>
		<td width="100"></td>
		<td>RECIEVED BY</td><td><input required name="received_by" type="text" placeholder="RECEIVED BY"></td>
	</tr>
	<tr>
		<td>VOUCHER NO</td><td><input required name="voucher" type="number" placeholder="VOUCHER NO"></td>
		<td width="100"></td>
		<td>REMARKS</td><td><input size="30" name="remarks" type="text" placeholder="REMARKS(optional)"></td>
	</tr>
	
	<tr>
		<td></td><td><br/><input class="btn btn-danger" type="submit" value="ADD TRANSACTION" onclick="return confirm('ADD TRANSACTION?')"></td>
	</tr>
	
	</table>	
		
	</form>
	</div>
	
<?php	
}	
else{}
?>

</div>

<hr>

<div class="w3-container">
	<?php
		if(isset($_REQUEST['add_bank_success']) or isset($_REQUEST['add_account_success']) or isset($_REQUEST['add_transaction_success'])) 
		  { echo "<div align='center' class='w3-text-green w3-large'>ADD SUCCESS!</div>"; }
	  else{}
	?>
<table class="w3-table">
	<tr>
		<td width="200">
			<i class='w3-text-gray w3-small'>* BANK LIST *</i><br/>
			<?php
			$s="SELECT * FROM bank_list ORDER BY bank_name ASC";
			$q=mysql_query($s);
			$r=mysql_fetch_assoc($q);
			  do{
				echo "<a href='check_monitoring.php?bank_id=".$r['bank_id']."' title='".$r['bank_long_name']."'>".$r['bank_name']."</a><br/>";
			  }while($r=mysql_fetch_assoc($q));
			?>
			
			<br/>  
			

			<i class='w3-text-gray w3-small'>* ACCOUNT LIST *</i><br/>
			<?php
			$s="SELECT a.*, b.bank_name
				FROM account_list a
				LEFT JOIN bank_list b ON a.bank_id=b.bank_id
				ORDER BY a.account_name, b.bank_name ASC";
			$q=mysql_query($s);
			$r=mysql_fetch_assoc($q);
			  do{
				echo "<a href='check_monitoring.php?account_id=".$r['account_id']."'>".$r['account_name']." - ".$r['bank_name']."<br/>";
				if($r['account_number']!=""){ echo "<i class='w3-text-red w3-small'>".$r['account_number']."</i>"; } 
				else { echo "<i class='w3-text-red w3-small'>NA</i>"; }
				echo "</a><br/><br/>";
			  }while($r=mysql_fetch_assoc($q));  
			?>
		</td>
		<td valign="top">
		<i class='w3-text-gray w3-small'>* TRANSACTION HISTORY *</i><br/>
		<?php
			if(isset($_REQUEST['bank_id']))    { $sort_by="WHERE b.bank_id = ".$_REQUEST['bank_id']." "; }
	   else if(isset($_REQUEST['account_id'])) { $sort_by="WHERE b.account_id = ".$_REQUEST['account_id']." "; }
		  else{ $sort_by=""; }
			
			$s3="SELECT a.*, b.account_name, b.account_number, c.bank_name
				 FROM check_monitoring a
				 LEFT JOIN account_list b ON a.account_id=b.account_id
				 LEFT JOIN bank_list c ON b.bank_id=c.bank_id
				 $sort_by
				 ORDER BY a.id DESC";
			$q3=mysql_query($s3);
			$r3=mysql_fetch_assoc($q3);
			
			
			$q7=mysql_query($s3);
			$r7=mysql_fetch_assoc($q7);
			
			if(isset($_REQUEST['account_id'])){
			echo "<b class='w3-xlarge'>".$r7['bank_name']." ".$r7['account_name']." - ";
			if($r7['account_number']!=""){ echo "<span class='w3-text-red'>".$r7['account_number']."</span>"; } else { echo "<span class='w3-text-red'>NA</span>"; }
			echo "</b>"; }else{}
			
			
			echo "<table class='w3-table w3-small w3-striped' border='1'>
					<tr class='w3-green'>
						<td>SYSTEM POSTING DATE</td>
						<td>BANK</td>
						<td>ACCOUNT NAME</td>
						<td>CHECK NO</td>
						<td>PAYEE</td>
						<td>PARTICULARS</td>
						<td>AMOUNT</td>
						<td>CHECK DATE</td>
						<td>VOUCHER</td>
						<td>REQUESTED BY</td>
						<td>APPROVED BY</td>
						<td>AUDITED BY</td>
						<td>SIGNED BY</td>
						<td>RECEIVED BY</td>
						<td>REMARKS</td>
					</tr>";
			
			  do{
				echo "<tr class='w3-hover-pale-green'>";
					echo "<td>".date('M d, Y h:i A',strtotime($r3['system_posting_datetime']))."</td>";
					echo "<td>".$r3['bank_name']."</td>";
					echo "<td>".$r3['account_name']." | ";
						if($r3['account_number']!=""){ echo "<span class='w3-text-red'>".$r3['account_number']."</span>"; } else { echo "<span class='w3-text-red'>NA</span>"; }
					echo "<td><b>".$r3['check_no']."<b></td>";
					echo "<td>".$r3['payee']."</td>";
					echo "<td>".$r3['particulars']."</td>";
					echo "<td><b>".number_format($r3['amount'],2)."</b></td>";
					echo "<td>".date('M d, Y',strtotime($r3['check_date']))."</td>";
					echo "<td>".$r3['voucher']."</td>";
					echo "<td>".$r3['requested_by']."</td>";
					echo "<td>".$r3['approved_by']."</td>";
					echo "<td>".$r3['audited_by']."</td>";
					echo "<td>".$r3['signed_by']."</td>";
					echo "<td>".$r3['received_by']."</td>";
					echo "<td>".$r3['remarks']."</td>";
				echo "</tr>";	
			  }while($r3=mysql_fetch_assoc($q3));
			  
			echo "</table>";  
		?>
		</td>
	</tr>
</table>	
</div>