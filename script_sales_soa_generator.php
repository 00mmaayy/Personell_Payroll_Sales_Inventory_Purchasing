<?php
session_start();
include('connection/conn.php');
if (!isset($_SESSION['username'])) {
	$loc = 'Location: index.php?msg=requires_login ' . $_SESSION['username'];
	header($loc);
}
?>
<div class="w3-center"><img src='img/soa_logo.png'></div>

<?php if(isset($_REQUEST['open'])){ ?>
<a href='script_sales_soa_generator.php?client_id=<?php echo $_REQUEST['client_id']; ?>'>x</a>
<?php } else { ?> <a href='script_sales_soa_generator.php?open=1&client_id=<?php echo $_REQUEST['client_id']; ?>'>+</a> <?php } ?>

<br/>

<?php
if(isset($_REQUEST['open']))
{
?>

	<form>
		<input name='client_id' type='hidden' value='<?php echo $_REQUEST['client_id']; ?>'>
		<input name='sdate' type='date' value='<?php echo date('Y-m-d'); ?>'>
		<input name='edate' type='date' value='<?php echo date('Y-m-d'); ?>'>
		<input type='submit' value='SET DATE'>
	</form>

<?php
}
else{}

if(isset($_REQUEST['sdate']))
{ 
	$sdate=$_REQUEST['sdate'];
	$edate=$_REQUEST['edate'];
	$range="sbd.dr_date >= '$sdate' AND sbd.dr_date <= '$edate' AND ";
}else { $range=""; }


$booking = array();
$date_today = date('Y-m-d');
$total_amount = 0;
$total_ten = 0;
$total_trty = 0;
$total_sxty = 0;
$total_otwty = 0;
$total_oety = 0;
$total_trsxty = 0;
$total_gtrsxty = 0;
$full_total_amount = 0;
$client_id = $_REQUEST['client_id'];
$select_client_details = mysql_query("SELECT * FROM sales_clients WHERE client_id = $client_id") or die(mysql_error());
$result_client_details = mysql_fetch_assoc($select_client_details);


$select_delivered = mysql_query("SELECT sbd.dr_date,
										sbd.dr_no,
										sbd.b_desc,
										sbd.b_qty,
										sbd.dr_qty,
										sbd.b_amount,
										sbd.b_unit,
										sj.jo_actual,
										sj.bo_no,
										sj.completed_by,
										sj.jo_payment_amount 
								FROM sales_bookings_details AS sbd 
								LEFT JOIN sales_jo AS sj USING(b_id) 
								LEFT JOIN sales_bookings AS sb USING(b_id) 
								LEFT JOIN sales_clients AS sc ON sb.client_id = sc.client_id 
								WHERE $range 
									sc.client_id = $client_id 
									AND sbd.dr_no <> 0 
									AND (sbd.dr_qty <> 0 AND sbd.b_amount <> 0)
									AND sj.completed_by = ''
								ORDER BY sbd.dr_date ASC") or die(mysql_error());								

//echo $select_delivered;

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>SOA GENERATOR</title>

	<link rel="stylesheet" href="css/w3.css">
</head>

<body>
<div class="w3-container">
    <table class="w3-table w3-small" align="center" border="1">
	<tr class="w3-green" align="center"><td style="text-align: center" colspan="8">STATEMENT OF ACCOUNT</td></tr>
	<tr>
		<td>CLIENT NAME</td>
			<td colspan="5"><?php echo $result_client_details['name']; ?></td>
		
		<td>SOA NO.</td>
	</tr>
	<tr>
		<td>ADDRESS</td>
			<td colspan="5"><?php echo $result_client_details['address']; ?></td>
		
		
		<td>DATE</td>
			<td><?php echo date('F d, Y'); ?></td>
	</tr>
	<tr><td>TIN</td><td colspan="7"><?php echo $result_client_details['tin']; ?></td></tr>
		<tr align='center'>
			<th>DR NO</th>
			<th>DR DATE</th>
			<th>JO NO/BK NO</th>
			<th>ITEM DESCRIPTION</th>
			<th>QTY</th>
			<th>UNIT PRICE</th>
			<!--<th>AGING</th> -->
			<th>DR AMOUNT</th>
			<th>BALANCE</th>

		</tr>

		<?php while ($dr_row = mysql_fetch_assoc($select_delivered)) :

			$date_subtracted = strtotime($date_today) - strtotime($dr_row['dr_date']);
			$aging = $date_subtracted / 86400;


			$total_amnt = ($dr_row['dr_qty'] * $dr_row['b_amount']);

			if ($dr_row['jo_actual'] != '') 
			{
				if(array_key_exists($dr_row['jo_actual'],$booking))
				{
					$total_pay = $booking[$dr_row['jo_actual']]['payBalance'];
				} else {
					$total_pay = $dr_row['jo_payment_amount'];
				}
			} elseif ($dr_row['jo_actual'] == '') 
			{
				if(array_key_exists($dr_row['bo_no'],$booking))
				{
					$total_pay = $booking[$dr_row['bo_no']]['payBalance'];
				} else {
					$total_pay = $dr_row['jo_payment_amount'];
				}
			} 


		
			if($total_amnt >= $total_pay)
			{
				$dr_balance = $total_amnt - $total_pay;
				$pay_balance = 0;
			} else {
				$pay_balance = $total_pay - $total_amnt;
				$dr_balance = 0;
			}

			if ($dr_row['jo_actual'] != '') 
			{
				$booking[$dr_row['jo_actual']] = array (
					"payBalance" =>	$pay_balance			
									
				);
			} elseif ($dr_row['jo_actual'] == '') 
			{
				$booking[$dr_row['bo_no']] = array (
					"payBalance" =>	$pay_balance	
				);
			} 

			if($dr_balance == 0)
			{
				continue;
			}
			?>
			<tr class="data" style="text-align: center;">
				<td><?php echo $dr_row['dr_no']; ?></td>
				<td><?php echo $dr_row['dr_date']; ?></td>
				<td>
					<?php if ($dr_row['jo_actual'] != '') {
							echo $dr_row['jo_actual'];
						} elseif ($dr_row['jo_actual'] == '') {
							echo $dr_row['bo_no'];
						} ?>
				</td>
				<td><?php echo $dr_row['b_desc'] ?></td>
				<td><?php echo $dr_row['dr_qty'] . " " . $dr_row['b_unit']; ?></td>
				<td><?php echo number_format($dr_row['b_amount'], 2); ?></td>
				
					<?php //echo "<td>".round($aging,2)."</td>"; ?>
				
				<td>
					<?php echo number_format(($dr_row['dr_qty'] * $dr_row['b_amount']),2); ?>
				</td>
				<td>
					<?php echo number_format($dr_balance,2); ?>
				</td>
			</tr>
		<?php
			$total_amount += ($dr_row['dr_qty'] * $dr_row['b_amount']);
			$full_total_amount += $dr_balance;
		endwhile; ?>
		
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align='center'><b>-</b></td>
			<td align='center'><b>-</b></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align='center'><b>-</b></td>
			<td align='center'><b>-</b></td>
			<td align='center'><b>-</b></td>
		</tr>
		<tr>
			<td class="grand-amount-label" colspan='6' style="text-align: right"><b>TOTAL AMOUNT DUE(VAT Inclusive)&nbsp;</b></td>
			<td class="grand-amount-total" align='right'><b><?php echo number_format($total_amount, 2); ?></b></td>
			<td class="grand-amount-total" align='right'><b><?php echo number_format($full_total_amount, 2); ?></b></td>
		</tr>
	</table>

	</br></br>
	<table class="w3-small">
		<tr>
			<td>PAYMENT OPTIONS</td>
		</tr>
		<tr>
			<td>CASH</td>
		</tr>
		
		<tr><td>GCASH</td><td>Account Name</td><td>Alex Ceasar Castro</td></tr>
		<tr><td></td><td>Number No.</td><td>09171599208</td></tr>
		
		<tr>
			<td>CHECK</td>
			<td colspan="2">Please make check payable to "ALC PRINTING HOUSE"</td>
		</tr>
		
		<tr><td>BANK</td><td></td><td></td></tr>
		<tr><td></td><td>Account Name</td><td>ALC Printing House</td></tr>
		<tr><td></td><td>Account No.</td><td>759-0555-230</td></tr>
	</table>
	</br></br>
	
	<?php 
		$sss="select * from signatories where form_area = 'PREPARED BY' and form_name = 'SOA' "; 
		$qqq=mysql_query($sss) or die(mysql_error());
		$rrr=mysql_fetch_assoc($qqq);
	?>
	<table>
		<tr valign='top'>
			<td width='300'>Prepared by:<br /><br /><br />
				<u><b><?php echo $rrr['fullname']; ?></b></u>
				<br />
				<?php echo $rrr['position']; ?>
			</td>


<?php 
		$sss1="select * from signatories where form_area = 'REVIEWED BY' and form_name = 'SOA' "; 
		$qqq1=mysql_query($sss1) or die(mysql_error());
		$rrr1=mysql_fetch_assoc($qqq1);
	?>
			<td width='300'>Reviewed by:<br /><br /><br />
				<u><b><?php echo $rrr1['fullname']; ?></b></u>
				<br />
				<?php echo $rrr1['position']; ?>
			</td>

			<td width='300'>Received by:<br /><br /><br />
				<u>________________________</u>
				<br />
				PRINT NAME & SIGNATURE
			</td>
		</tr>
	</table>
	
	
</br></br>	
<div class="w3-small"><b>"THIS DOCUMENT IS NOT VALID FOR CLAIMING INPUT TAXES."</b></div>

</div>
</body>

</html>
