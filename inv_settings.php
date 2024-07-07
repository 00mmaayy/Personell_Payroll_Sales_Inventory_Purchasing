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
<form method="get" action="script_inv_settings.php">
	<b>Create New Storage Site</b><br/>
	<input name="storage_name" type="text" placeholder="Storage Name" required>
	<input name="storage_address" type="text" placeholder="Input Storage Addres" required>
	<input type="submit" value="Add Storage" onclick="return confirm('Confirm / Continue to Add Storage?')">
</form><br/>
<table class='table' border='1'>
	<tr align='center'>
		<td>Storage ID</td>
		<td>Name</td>
		<td>Address</td>
	</tr>
<?php
$s="select * from inv_storage_facility";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
	do
	{
		echo "<tr>
			  <td>".$r['id']."</td>
			  <td>".$r['name']."</td>
			  <td>".$r['address']."</td>
			  </tr>";
	}while($r=mysql_fetch_assoc($q));
?>	
</table>
</div>