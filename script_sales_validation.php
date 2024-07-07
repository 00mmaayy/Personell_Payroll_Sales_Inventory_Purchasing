<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>

<style>
body
{ font-family: monospace; }
</style>

<body>
<?php
$username=$_SESSION['username'];
$jo_no=$_REQUEST['jo_no'];
$s="select * from sales_jo where jo_no=$jo_no";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

if(isset($_REQUEST['vprint']))
{ 
	mysql_query("update sales_jo set validation=1, validation_date=now() where jo_no=$jo_no") or die(mysql_error()); 
	$trans="1st validation print on jo $jo_no";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	header('Location: script_sales_validation.php?jo_no='.$jo_no.'&show_validation=1');
}

if(isset($_REQUEST['re_vprint']))
{ 
	mysql_query("update sales_jo set validation=2, 2nd_validation=now() where jo_no=$jo_no") or die(mysql_error());
    $trans="Re-print validation on jo $jo_no";
	$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
	$log_query=mysql_query($log_sql) or die(mysql_error());
	header('Location: script_sales_validation.php?jo_no='.$jo_no.'&show_validation=1');
}


if(isset($_REQUEST['show_validation']))
{
	
echo "<table><tr>
		<td width='100'></td>
		<td>";
echo "|------------ ALC SYSTEM VALIDATION -----------------<br/>";
echo "| JO No: ".$r['jo_no']."<br/>";
echo "| JO Amount: ".number_format($r['jo_amount'],2)."<br/>";
echo "| Salesperson: ".$r['salesperson']."<br/>";
echo "| Created Date: ".date('m/d/Y h:i:s A',strtotime($r['created_datetime']))."<br/>";
echo "| Created by: ".$r['created_by']."<br/>";
echo "|<br/>";
echo "| Booking No: ".$r['bo_no']."<br/>";
echo "| Booking Date: ".$r['bo_no_date']."<br/>";
echo "|----------------------------------------------------";
echo "</td>
		<td>|<br/>|<br/>|<br/>|<br/>|<br/>|<br/>|<br/>|<br/>|<br/>|</td>
	</tr>
	<tr><td width='100'></td>
		<td>";
	if($r['validation']==2)
	{
		if($r['2nd_validation']!="0000-00-00 00:00:00")
		{ 
			echo "<br/><br/><span style='text-decoration:overline'>Salesperson Name & Signature</span><br/>&nbsp;&nbsp;&nbsp;VALIDATION DATE: ".date('m/d/Y h:i:s A',strtotime($r['2nd_validation']))."<br/>"; 
			echo "RE-PRINTED COPY"; 
		}
		else
		{ echo ""; }
	}
	elseif($r['validation']==1)
	{
		if($r['validation_date']!="0000-00-00 00:00:00")
		{ 
			echo "<br/><br/><span style='text-decoration:overline'>Salesperson Name & Signature</span><br/>VALIDATION DATE: ".date('m/d/Y h:i:s A',strtotime($r['validation_date'])); 
		}
		else
		{ echo ""; }
	}
	else{}
	echo "</td>
	</tr></table>";

	
}
?>
</body>