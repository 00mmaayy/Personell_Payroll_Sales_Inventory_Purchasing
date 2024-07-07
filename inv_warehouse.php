<?php
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$s="select * from inv_storage_facility";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
?>
<br/>
<div class='container'>
<form method="get">
	<select name="storage">
		<option>Please Select Storage</option>
	<?php
	do{
	   echo "<option value=".$r['id'].">".$r['name']."</option>";
	}while($r=mysql_fetch_assoc($q));	
	?>
	</select>
	
	<input type="submit" value="SELECT THIS STORAGE">
</form>


<?php 
if(isset($_REQUEST['storage']))
{
$storage=$_REQUEST['storage'];
$s1="select * from inv_storage_facility where id=$storage";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);

$s3="select sum(item_price*count_in) as total_inv from inv_storage_in where storage = '$storage' ";
$q3=mysql_query($s3) or die(mysql_error());
$r3=mysql_fetch_assoc($q3);

echo "<table class='w3-table'>
	<tr class='w3-green'>
		<td>Name: <b>".$r1['name']."</b></td>
		<td>Address :<b>".$r1['address']."</b></td>
		<td>Invertory Total: <span class='w3-large' ><b>".number_format($r3['total_inv'],2)."</b></span></td>
	</tr>
</table>";

	if(isset($_REQUEST['search']))
	{
		$search=$_REQUEST['search'];
		$s2="select a.*,
				b.price,
				b.item
		from inv_storage_in a 
		join proc_items b on a.item_id=b.id
		where a.storage=$storage and b.item like '%$search%'";
		echo "<i class='w3-text-red w3-small'>You search for: <b>$search</b></i>";
	}
	else
	{
	$s2="select a.*,
				b.price,
				b.item
		from inv_storage_in a 
		join proc_items b on a.item_id=b.id
		where a.storage=$storage";
	}
	$q2=mysql_query($s2) or die(mysql_error());
	$r2=mysql_fetch_assoc($q2);

echo "<table class='w3-striped w3-border w3-table'>
		<tr>
			<td colspan=3>
				<form method='get'>
					<input type='hidden' name='storage' value='".$_REQUEST['storage']."'>
					<input type='text' name='search' placeholder='type item name here' required></br>
					<input class='w3-button w3-blue' type='submit' value='Search Item Now!'>
				</form>
			</td>
			<td>
				<form method='get'>
					<input type='hidden' name='storage' value='".$_REQUEST['storage']."'>
			</td>"; 
					?>
			<td><input class="w3-button w3-blue" name="withdrawal" type="submit" value="Open Withdrawal Tool"></br>
			    <input class="w3-button w3-red" type="submit" value="Reset"></td>
			<td>
			</form>
					<?php	$sw="select count(transact_id) as active from inv_storage_out_temp";
							$qw=mysql_query($sw) or die(mysql_error());
							$rw=mysql_fetch_assoc($qw);
							if($rw['active']){  echo "<b><i class='w3-text-red'>Pending Withdraw List!</i></b>"; ?>
												      <form method="get" action="script_inv_delete_list.php">
														<input name="storage" type="hidden" value="<?php echo $_REQUEST['storage']; ?>">
														<input class="w3-button w3-red" name="delete_list" type="submit" value="Delete List?" onclick="return confirm('Sure? Delete Pending Withdrawal List?')">
													  </form>
					                   <?php }else{}
					?>
			</td>
			<td>		
	<?php echo "<form method='get' action='inv_withdrawal_list.php' target='_blank'>
					<input type='hidden' name='storage' value='".$_REQUEST['storage']."'>";
					if($rw['active']){ ?>
						<input class='w3-button w3-yellow' type='submit' name='view_withdrawal' value='View Withdrawal List'>
				<?php	} 
		  echo "</form>
			</td>
		</tr>
		<tr class='w3-light-blue'>
			<td>ITEM ID</td>";
	  if(isset($_REQUEST['withdrawal'])){
	  echo "<td>WITHDRAW</td>";
	  }else{ echo "<td></td>"; }
		echo "<td>COUNT</td>
			<td>NAME</td>
			<td>PRICE</td>
			<td>DATE ADDED</td>
			<td>FROM PO NO:</td>
		</tr>";
	do{
		echo "<tr class='w3-hover-pale-red'>
				<td>".$r2['item_id']."</td>
				<td>
					<form method='get' action='script_inv_add_withdrawal.php'>
						<input type='hidden' name='item_id' value='".$r2['item_id']."'>
						<input type='hidden' name='price' value='".$r2['price']."'>
						<input type='hidden' name='officer' value='".$_SESSION['username']."'>
						<input type='hidden' name='storage' value='".$_REQUEST['storage']."'>
						<input type='hidden' name='po_no' value='".$r2['po_no']."'>"; 
						
						if(isset($_REQUEST['withdrawal'])){ 
							$item_id=$r2['item_id'];
							$sx1="select sum(count_out) as count_out1 from inv_storage_out_temp where item_id=$item_id";
							$qx1=mysql_query($sx1) or die(mysql_error());
							$rx1=mysql_fetch_assoc($qx1);
						
						    $total_balance=$r2['count_in']-$rx1['count_out1'];
						?>
						<input class="w3-input w3-border" size="3" type="number" max="<?php echo $total_balance; ?>" name="withdraw_count" required>
						<input class="w3-button w3-amber" title="ADD TO WITHDRAWAL" type="submit" name="add_withdraw" value="Add To List" onclick="return confirm('Add Item?')">
						
						<?php }else{}
						
			  echo "</form>
				</td>";
		  echo "<td>";
				if(isset($_REQUEST['withdrawal']))
				{
					echo "<b>$total_balance</b>";
				}else{ echo "</b>".$r2['count_in']."</b>"; }
		  echo "</td>
				<td>".$r2['item']."</td>
				<td>".$r2['price']."</td>
				<td>".$r2['datetime']." / ".$r2['officer']."</td>
				<td>".$r2['po_no']."</td>
			</tr>";
	}while($r2=mysql_fetch_assoc($q2));
	
	
echo "</table>";

}
?>

</div>