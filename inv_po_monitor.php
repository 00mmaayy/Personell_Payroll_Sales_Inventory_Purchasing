<?php
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");
?>
<div class='container'>
	<br>
	<table class='table'>
	  <tr class='w3-dark-gray w3-tiny'>
		<td>COUNT</td>
		<td>PO NO.</td>
		<td>PO AMOUNT</td>
		<td>CREATED INFO</td>
		<td>RECEIVED INFO</td>
		<td>CENCELLED INFO</td>
		<td>STATUS</td>
		<td>ACTION</td>
	 </tr>
	  
    <?php
	$s9=mysql_query("select * from proc_po order by add_date DESC") or die(mysql_error());
	$r9=mysql_fetch_assoc($s9);
	$x=1;
	do{
		echo "<tr>";
		echo "<td>".$x++."</td>";
		echo "<td><a href='podetails.php?po_no=".$r9['po_no']."' target='_blank'>".$r9['po_no']."</a></td>";
		echo "<td class='w3-text-red'>".number_format($r9['po_amount'],2)."</td>";
		echo "<td>".$r9['add_date']."</td>";
		echo "<td>".$r9['recieved_date']."</td>";
		echo "<td>".$r9['cancelled_date']."</td>";
		echo "<td>";
		
		if($r9['status']==0){ echo "<span class='w3-text-red'>Pending</span>"; }
		else{ echo "<span class='w3-text-green'>PO received</span>";}
		
		echo "</td>";
		echo "<td>";
		
		
		if($r9['status']==0){
		$s="select * from inv_storage_facility";
		$q=mysql_query($s) or die(mysql_error());
		$r=mysql_fetch_assoc($q);
		?>
		<form method="get" action="inv_script_storage_in_out.php">
			<input name="storage_in" type="hidden" value="1">
			<input name="po_amount" type="hidden" value="<?php echo $r9['po_amount']; ?>">
			<input name="po_no" type="hidden" value="<?php echo $r9['po_no']; ?>">
			<select name="storage" required>
				<option>Select Storage --</option>
			<?php
			do{
			   echo "<option value=".$r['id'].">".$r['name']."</option>";
			}while($r=mysql_fetch_assoc($q));	
			?>
			</select></br>
			
			<input type="submit" value="RECIEVE PO" onclick="return confirm('Receive this PO?')">
		</form>
		
		<?php }else{ echo "Recieved by: ".$r9['recieved_by']; }
		echo "</td>";
		echo "</tr>";
	}while($r9=mysql_fetch_assoc($s9));
	?>
	  
	</table>
</div>