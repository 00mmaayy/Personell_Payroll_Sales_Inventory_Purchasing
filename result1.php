<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$item=$_REQUEST['s'];
$sql=mysql_query("select id,item,price from proc_items where item like '%$item%' order by item asc");
while ($row = mysql_fetch_array($sql))
{ 
	//echo "&nbsp;&nbsp;<a class='w3-tiny' href='script_podetails.php?item_add=1&po_no=".$_REQUEST['po_no']."&podetails=1&item=".$row['id']."'>".$row['item']."</a><br>";
?>
	&nbsp;&nbsp;<form method='get' action='script_podetails.php'>
					<input name='po_no' type='hidden' value='<?php echo $_REQUEST['po_no']; ?>'>
					<input name='item' type='hidden' value='<?php echo $row['id']; ?>'>
					<span class='btn w3-tiny'><?php echo $row['item']." / ".$row['price']; ?></span>
					<input name='qty' class='btn w3-pale-red w3-tiny' placeholder='Input Quantity' type='number' step='any' required>
					<input name='item_add' class='w3-tiny btn w3-red' type='submit' value='ADD ITEM' onclick='return confirm("ADD ITEM?")'>
				</form>
<?php 
} 
?>
