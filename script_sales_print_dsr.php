<link rel="stylesheet" href="css/w3.css">
<?php
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

include("current_user.php");

switch($_REQUEST['branch1'])
{
	case "SALES": if($r9['bch']=="goc"){ $bch="goc"; } else{ $bch="main"; } break;
	case "SM SALES": $bch="sm"; break;
	case "RIZAL SALES": $bch="rzl"; break;
	case "SANPEDRO SALES": $bch="sp"; break;
	case "SANJOSE SALES": $bch="sj"; break;
}
?>
<div class='w3-container'>
	<div align='center'>
		<span class='w3-small'>ALC PRINTING HOUSE</span><br/>
		<span class='w3-tiny'><?php echo $_REQUEST['branch1']; ?></span><br/>
		<span class='w3-tiny'>Schedule of Deposited Remittance</span><br/>
		<span class='w3-tiny'><?php echo date('M d, Y',strtotime($_REQUEST['sdate']))." - ".date('M d, Y',strtotime($_REQUEST['edate'])); ?></span>
	</div>
	<table class='w3-table w3-tiny' border='1'>
		<tr class='w3-light-gray'>
			<td>JO Number</td>
			<td>JO Date</td>
			<td>Client Name</td>
			<td>Branch</td>
			<td>Mode of Payment</td>
			<td>OR No</td>
			<td>OR Date</td>
			<td>Amount</td>
			<td>User</td>
		</tr>
		
	<?php
		$sdate = $_REQUEST['sdate']." 00:00:00";
		$edate = $_REQUEST['edate']." 23:59:59";
		$s="SELECT 
				a.rs_bch, a.pay_mode, a.or_no, a.or_date, a.payment, a.payment_by,
				b.jo_no, b.created_datetime,
				c.name
			FROM sales_jo_payments a
			LEFT JOIN sales_jo b on a.jo_no = b.jo_no
			LEFT JOIN sales_clients c on b.client_id = c.client_id
			WHERE a.rs_bch = '$bch' and a.deposited = 1 and a.payment_datetime >= '$sdate' and a.payment_datetime <= '$edate'
			ORDER BY b.created_datetime DESC";
		$q=mysql_query($s) or die(mysql_error());
		$r=mysql_fetch_assoc($q);
		do{
		echo "<tr>
				<td>".$r['jo_no']."</td>
				<td>".$r['created_datetime']."</td>
				<td>".$r['name']."</td>
				<td>".$r['rs_bch']."</td>
				<td>".$r['pay_mode']."</td>
				<td>".$r['or_no']."</td>
				<td>".$r['or_date']."</td>
				<td>".$r['payment']."</td>
				<td>".$r['payment_by']."</td>
			</tr>";
		$total += $r['payment'];
		}while($r=mysql_fetch_assoc($q));
		
		echo "<tr>
				<td colspan='7'></td><td colspan='2'>".number_format($total,2)."</td>
			  </tr>";
	?>
	</table>
</div>