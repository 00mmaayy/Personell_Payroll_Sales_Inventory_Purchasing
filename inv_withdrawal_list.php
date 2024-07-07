<?php
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$storage=$_REQUEST['storage'];
$s="select * from inv_storage_facility where id=$storage";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
?>
<div class='container'>
	<br>
	<table class='table w3-border'>
	  <tr align="center" colspan="7">WITHDRAWAL LIST FROM: <b><span class="w3-large"><?php echo $r['name']; ?></span></b> </td>
	  <tr class='w3-blue w3-small'>
		<td><i>COUNT</i></td>
		<td>ITEM ID</td>
		<td>ITEM NAME</td>
		<td>FOR WITHDRAWAL</td>
		<td>DATE / TIME ADDED</td>
	 </tr>
	  
    <?php
	$s9="select a.transact_id,a.item_id, b.item, a.count_out, a.datetime from inv_storage_out_temp a join proc_items b on a.item_id=b.id";
	$q9=mysql_query($s9) or die(mysql_error());
	$r9=mysql_fetch_assoc($q9);
	$x=1;
	do{
		echo "<tr>";
		echo "<td class='w3-tiny w3-text-orange'><i>".$x++."</i></td>";
		echo "<td>".$r9['item_id']."</td>";
		echo "<td>".$r9['item']."</td>";
		echo "<td>".$r9['count_out']."</td>";
		echo "<td>".date('F d, Y h:i A',strtotime($r9['datetime']))."&nbsp;&nbsp;&nbsp;";
		?> <a href="script_inv_delete_item_on_list.php?transact_id=<?php echo $r9['transact_id']; ?>&storage=<?php echo $_REQUEST['storage']; ?>&count_out=<?php echo $r9['count_out']; ?>&item_id=<?php echo $r9['item_id']; ?>" class="fa fa-trash"></a></td> <?php
		echo "</tr>";
	}while($r9=mysql_fetch_assoc($q9));
	?>
	</table>
	
	<form method="get">
		<input type="hidden" name="view_withdrawal">
		<input type="hidden" name="storage" value="<?php echo $_REQUEST['storage']; ?>">
		<input type="number" name="jo_no" placeholder="Input JO NO" required>
		<input type="submit" value="Search JO NO">
	</form></br>
	
	<?php
	if(isset($_REQUEST['jo_no']))
	{
		$jo_no=$_REQUEST['jo_no'];
		$sa="SELECT a.jo_no, b.name 
			 FROM sales_jo a
			 INNER JOIN sales_clients b
				ON a.client_id=b.client_id
			 WHERE a.jo_no='$jo_no'";
		$qa=mysql_query($sa) or die(mysql_error());
		$ra=mysql_fetch_assoc($qa);
		
		echo "JO NO: <b>".$ra['jo_no']."</b></br>CLIENT: <b>".$ra['name']."</b>";
	}else{}
	?>
	
	<form method="get" action="script_inv_withdrawal_release.php">
		<?php
			if(isset($_REQUEST['jo_no']))
			{
				echo "<input type='hidden' name='jo_no' value='".$_REQUEST['jo_no']."'>";
			}else{}
		  ?>
	
		<input type="hidden" name="storage" value="<?php echo $_REQUEST['storage']; ?>">
		<input type="hidden" name="withdrawal_release" value="1">
		<input class="w3-input w3-border" type="text" name="requested_by" placeholder="Requested By" required>
		<input class="w3-input w3-border" type="text" name="withdrawal_slip_no" placeholder="Material Withdrawal Slip No" required>
		<input class="w3-input w3-border" type="date" name="actual_withdrawal_date" required>
		<input class="w3-button w3-amber" type="submit" value="RELEASE WITHDRAWAL" onclick="return confirm('Sure Release Withdrawal?')">
	</form>
</div>