<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$po_no=$_REQUEST['s'];
$sql=mysql_query("select po_no from proc_po where po_no like '%$po_no%' order by po_no asc");
while ($row = mysql_fetch_array($sql))
{ 
?>
	&nbsp;&nbsp;<form method='get' action='script_rfpdetails.php'>
					<span class='btn w3-tiny'><?php echo $row['po_no']; ?></span>
					<input name='po_no' type='hidden' value='<?php echo $row['po_no']; ?>'>
					<input name='rfp_no' type='hidden' value='<?php echo $_REQUEST['rfp_no']; ?>'>
					<input name='add_po' class='w3-tiny btn w3-red' type='submit' value='SELECT PO' onclick='return confirm("SELECT PO?")'>
				</form>
<?php 
} 
?>
