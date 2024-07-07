<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");


echo "<div class='container'>";
$client_id=$_REQUEST['client_id'];
$historyStart=$_REQUEST['historyStart'];
$historyEnd=$_REQUEST['historyEnd'];


$sclient="select name from sales_clients where client_id='$client_id'";
$qclient=mysql_query($sclient) or die(mysql_error());
$rclient=mysql_fetch_assoc($qclient);
echo "<b class='w3-text-indigo'>".$rclient['name']."</b><br/>";


if(isset($_REQUEST['system']))
{
$sHistory="select sum(jo_amount) as jo_amount, sum(jo_payment_amount) as jo_payment_amount from sales_jo where client_id='$client_id' and created_datetime>='$historyStart 00:00:00' and created_datetime<='$historyEnd 23:59:59'";
$qHistory=mysql_query($sHistory) or die(mysql_error());
$rHistory=mysql_fetch_assoc($qHistory);
echo "<i class='w3-text-red'>(Based on System Creation.)</i><br/>";
echo "TOTAL JO AMOUNT PER DATE: <b class='w3-text-indigo'>".number_format(round($rHistory['jo_amount'],2),2)."</b><br/>";
echo "TOTAL JO PAID AMOUNT PER DATE: <b class='w3-text-blue'>".number_format(round($rHistory['jo_payment_amount'],2),2)."</b>";

$sHistory="select * from sales_jo where client_id='$client_id' and created_datetime>='$historyStart 00:00:00' and created_datetime<='$historyEnd 23:59:59' order by created_datetime asc";
$qHistory=mysql_query($sHistory) or die(mysql_error());
$rHistory=mysql_fetch_assoc($qHistory);

echo "<table border='1' class='w3-small'>
		<tr class='w3-green'>
			<td>#</td>
			<td>JO NO</td>
			<td>JO ACTUAL</td>
			<td>JO ACTUAL DATE</td>
			<td>PO NO</td>
			<td>PO DATE</td>
			<td>PRE JO</td>
			<td>JO AMOUNT</td>
			<td>JO PAYMENT AMOUNT</td>
			<td>CREATED DATE</td>
			<td>CREATED BY</td>
			<td>COMPLETED DATE</td>
			<td>COMPLETED BY</td>
			<td>PAID</td>
			<td>DELIVERED</td>
		</tr>";
		$x=1;
do{
   echo "<tr align='right' class='w3-hover-pale-red'>
			<td>".$x++."</td>
			<td>".$rHistory['jo_no']."</td>
			<td>".$rHistory['jo_actual']."</td>
			<td>";
				if($rHistory['jo_actual_date']!="0000-00-00"){ echo date('m/d/Y',strtotime($rHistory['jo_actual_date'])); }
	  echo "</td>
			<td>".$rHistory['po_no']."</td>
			<td>";
				if($rHistory['po_date']!="0000-00-00"){ echo date('m/d/Y',strtotime($rHistory['po_date'])); }
	  echo "</td>
			<td>".$rHistory['b_id']."</td>
			<td>".number_format($rHistory['jo_amount'],2)."</td>
			<td>".number_format($rHistory['jo_payment_amount'],2)."</td>
			<td>".date('m/d/Y',strtotime($rHistory['created_datetime']))."</td>
			<td>".$rHistory['created_by']."</td>
			<td>";
				if($rHistory['completed_datetime']!="0000-00-00 00:00:00"){ echo date('m/d/Y',strtotime($rHistory['completed_datetime'])); }
	  echo "</td>
			<td>".$rHistory['completed_by']."</td>
			<td>";
				if($rHistory['paid']!=0){ echo "YES"; }
	  echo "</td>
			<td>";
				if($rHistory['delivered']!=0){ echo "YES"; }
	  echo "</td>
		</td>";
  } while ($rHistory=mysql_fetch_assoc($qHistory));
echo "</table><br/>";
}



if(isset($_REQUEST['actual']))
{	
$sHistory_actual="select sum(jo_amount) as jo_amount, sum(jo_payment_amount) as jo_payment_amount from sales_jo where client_id='$client_id' and jo_actual_date>='$historyStart' and jo_actual_date<='$historyEnd'";
$qHistory_actual=mysql_query($sHistory_actual) or die(mysql_error());
$rHistory_actual=mysql_fetch_assoc($qHistory_actual);
echo "<i class='w3-text-red'>(Based on Actual JO Date.)</i><br/>";
echo "TOTAL JO AMOUNT PER ACTUAL DATE: <b class='w3-text-red'>".number_format(round($rHistory_actual['jo_amount'],2),2)."</b><br/>";
echo "TOTAL JO PAID AMOUNT PER ACTUAL DATE: <b class='w3-text-deep-orange'>".number_format(round($rHistory_actual['jo_payment_amount'],2),2)."</b>";

$sHistory_actual="select * from sales_jo where client_id='$client_id' and jo_actual_date>='$historyStart' and jo_actual_date<='$historyEnd' order by jo_actual_date asc";
$qHistory_actual=mysql_query($sHistory_actual) or die(mysql_error());
$rHistory_actual=mysql_fetch_assoc($qHistory_actual);

echo "<table border='1' class='w3-small'>
		<tr class='w3-green'>
			<td>#</td>
			<td>JO NO</td>
			<td>JO ACTUAL</td>
			<td>JO ACTUAL DATE</td>
			<td>PO NO</td>
			<td>PO DATE</td>
			<td>PRE JO</td>
			<td>JO AMOUNT</td>
			<td>JO PAYMENT AMOUNT</td>
			<td>CREATED DATE</td>
			<td>CREATED BY</td>
			<td>COMPLETED DATE</td>
			<td>COMPLETED BY</td>
			<td>PAID</td>
			<td>DELIVERED</td>
		</tr>";
		$x=1;
do{
   echo "<tr align='right' class='w3-hover-pale-red'>
			<td>".$x++."</td>
			<td>".$rHistory_actual['jo_no']."</td>
			<td>".$rHistory_actual['jo_actual']."</td>
			<td>";
				if($rHistory_actual['jo_actual_date']!="0000-00-00"){ echo date('m/d/Y',strtotime($rHistory_actual['jo_actual_date'])); }
	  echo "</td>
			<td>".$rHistory_actual['po_no']."</td>
			<td>";
				if($rHistory_actual['po_date']!="0000-00-00"){ echo date('m/d/Y',strtotime($rHistory_actual['po_date'])); }
	  echo "</td>
			<td>".$rHistory_actual['b_id']."</td>
			<td>".number_format($rHistory_actual['jo_amount'],2)."</td>
			<td>".number_format($rHistory_actual['jo_payment_amount'],2)."</td>
			<td>".date('m/d/Y',strtotime($rHistory_actual['created_datetime']))."</td>
			<td>".$rHistory_actual['created_by']."</td>
			<td>";
			if($rHistory_actual['completed_datetime']!="0000-00-00 00:00:00"){ echo date('m/d/Y',strtotime($rHistory_actual['completed_datetime'])); }
	  echo "</td>
			<td>".$rHistory_actual['completed_by']."</td>
			<td>";
				if($rHistory_actual['paid']!=0){ echo "YES"; }
	  echo "</td>
			<td>";
				if($rHistory_actual['delivered']!=0){ echo "YES"; }
	  echo "</td>
		</td>";
  } while ($rHistory_actual=mysql_fetch_assoc($qHistory_actual));
echo "</table><br/>";
}

echo "</div>";
?>