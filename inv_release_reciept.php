<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include('css.php');
$s="select a.*,b.name,b.address,c.first_name,c.last_name
	from inv_storage_out a 
	join inv_storage_facility b
		on a.storage=b.id 
	join users c 
		on a.officer=c.username
	group by withdrawal_number order by transact_id DESC";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$withdrawal_number=$r['withdrawal_number'];

$s1="select a.*,b.item from inv_storage_out a join proc_items b on a.item_id=b.id where withdrawal_number='$withdrawal_number'";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);

?>
</br>
<div class="container">
<table>
				<tr><td>DATE RELEASED: <b><?php echo date('F d, Y h:1 A',strtotime($r['datetime'])); ?></b><td></tr>
				<tr><td>RELEASE RECIEPT NO: <b><?php echo $r['withdrawal_number']; ?></b><td></tr>
				<tr><td>STORAGE: <b><?php echo $r['name']; ?></b><td></tr>
				<tr><td>STORAGE ADDRESS: <b><?php echo $r['address']; ?></b><td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr class="w3-border"><td>ITEM NAME</td><td>QTY</td></tr>
		<?php
		do{
		  echo "<tr class='w3-border'>
					<td>".$r1['item']."</td>
					<td>".$r1['count_out']."</td>
				</tr>";
			
		}while($r1=mysql_fetch_assoc($q1));
		?>
				<tr><td>&nbsp;</td></tr>
				<tr><td>MATERIAL WITHDRAWAL SLIP NO:: <b><?php echo $r['withdrawal_slip_no']; ?></b></td></tr>
				<tr><td>MATERIAL WITHDRAWAL SLIP DATE:: <b><?php echo date('F d, Y',strtotime($r['withdrawal_slip_date'])); ?></b></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>FOR JO NO: <b><?php echo $r['for_jo']; ?></b></td></tr>
			<?php
				$jo_no=$r['for_jo'];
				$sa="SELECT a.jo_no, b.name 
					 FROM sales_jo a
					 INNER JOIN sales_clients b
						ON a.client_id=b.client_id
					 WHERE a.jo_no='$jo_no'";
				$qa=mysql_query($sa) or die(mysql_error());
				$ra=mysql_fetch_assoc($qa);
			?>
				<tr><td>CLIENT: <b><?php echo $ra['name']; ?></b></td></tr>
				<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
				<tr><td>REQUESTED BY: <b><?php echo $r['requested_by']; ?></b><td></tr>
				<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
				<tr><td>RELEASED BY: <b><?php echo $r['first_name']." ".$r['last_name']; ?></b><td></tr>
				
</table>
</div>

