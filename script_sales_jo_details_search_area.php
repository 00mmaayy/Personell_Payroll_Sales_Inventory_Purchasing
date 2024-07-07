<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
date_default_timezone_set("Asia/Manila");
include("css.php");
?>
<!---Ajax Search Start--->
<script src="js/ajaxloader.js"></script>
    <script>
		function showHint(str)
		{
			var s=document.getElementById("search").value;
			var xmlhttp;

			if(window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.onreadystatechange=function()
			{
				if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("view_result").innerHTML=xmlhttp.responseText;
				}
			}
				
			xmlhttp.open("GET","script_sales_search_jo_details.php?s="+s,true);
			xmlhttp.send();
		}
	</script>

<div class='w3-green w3-large'>&nbsp;IT TOOLS <i class='w3-small'>(Actual System Generated Numbers)</i>
</div>
	<br>
<div class='w3-container'>
<table width='100%'>
	<tr>
		<td class='w3-text-blue w3-tiny'><b>JO DETAIL SEARCH</b></td>
	    <td class='w3-text-blue w3-tiny'><b>IT LOGBOOK SEARCH</b></td>
		<td class='w3-text-blue w3-tiny'><b>JO SEARCH</b></td>
		<td class='w3-text-blue w3-tiny'><b>BOOKING ID SEARCH</b></td>
		<td class='w3-text-red w3-tiny'><b>MAINTENANCE:DELETE<br/>PENDING / CANCELLED BOOKINGS</b></td>
		<td class='w3-text-red w3-tiny'><b>MAINTENANCE:<br/>CLEAR OVERRIDE LIST</b></td>
		<td class='w3-text-green w3-tiny'><b>MERGE CLIENTS</b></td>
	</tr>
	<tr valign='top'>
		<td><i><input class='w3-tiny' type="text" id="search" name="search" onkeyup="showHint('x')"/>&nbsp;&nbsp;<i/><div id="view_result"></div></td>
		<td><form class='w3-tiny'><input name='it_logbook' type='text'>&nbsp;<input type='submit' value='search'></form></td>
		<td><form class='w3-tiny' action='script_sales_tools.php' method='get' target='_blanks'><input name='jo_no' type='text'>&nbsp;<input type='submit' value='search'></form></td>
		<td><form class='w3-tiny' action='script_sales_tools.php' method='get' target='_blanks'><input name='b_id' type='text'>&nbsp;<input type='submit' value='search'></form></td>
		<td class='w3-small'>
			<form action='script_sales_tools2.php'>
				<input name='clear_cancelled' type='submit' value='clear'>
			</form>
			<?php if(isset($_REQUEST['cleared'])){ echo "Pending Bookings Cleared!"; } ?>
		</td>
		<td class='w3-small'>
			<form action='script_sales_tools2.php'>
				<input name='clear_override_list' type='submit' value='clear override'>
			</form>
			<?php if(isset($_REQUEST['override_deleted'])){ echo "Override list, Cleared!"; } ?>
		</td>
		
		
		
		<td>
		
			<table class='w3-tiny'>
				<tr align='center'>
					<td>KEEP</td><td>REMOVE</td><td>ACTION</td>
				</tr>
				
				<form action='script_sales_merge_clients.php'>
				<tr>
					<td>
						<input required name='client_keep' type='number' placeholder='client_id'>
					</td>
					<td>	
						<input required name='client_remove' type='number' placeholder='client_id'>
					</td>
					<td>	
						<input name='merge_clients' type='submit' value='Merge!' onclick='return confirm("Merge Clients?")'>
					</td>
				</tr>
				</form>
				<tr>
					<td><?php if(isset($_REQUEST['merge_success'])){ echo "<b class='w3-green'>Merge Success!</b>"; } ?></td>
				</tr>
			</table>
			
		</td>
		
		
		
	</tr>
</table>


<?php
if(isset($_REQUEST['it_logbook']))
{
	
	$it_logbook=$_REQUEST['it_logbook'];
	$q5=mysql_query("select * from logbook_it where transaction like '%$it_logbook%'") or die(mysql_error());
	$r5=mysql_fetch_assoc($q5);
	echo "<table class='w3-table w3-small w3-border'>
			<tr class='w3-border'><td>update by</td><td>date time</td><td>transaction</td></tr>";
	do{
		
		echo "<tr class='w3-border'><td class='w3-text-red'>".$r5['update_by']."</td><td>".date('m/d/Y h:ia',strtotime($r5['date']))."</td><td>".$r5['transaction']."</td><tr>";
		
	}while($r5=mysql_fetch_assoc($q5));
	echo "</table>";
	echo "<br/>";
}
?>
</div>         
<!---Ajax Search End--->
