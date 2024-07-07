<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

echo "<div class='w3-small'>";
echo "<a href='script_sales_forms_monitor.php?ar=1&show_ar_it_inserted=1'>SHOW AR (ALL IT CREATED)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<a href='script_sales_forms_monitor.php?ar=1&show_ar_from_sales=1'>SHOW AR (FROM SALES)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<a href='script_sales_forms_monitor.php?ar=1&show_ar_from_finance=1'>SHOW AR (FROM FINANCE)</a>";
echo "<br/><br/></div>";

//SHOW ALL AR
if(isset($_REQUEST['ar']))
{	
	if(isset($_REQUEST['show_ar_from_sales']))
	{
		echo "<b class='w3-pale-blue'>SHOW ALL A.R. NA PINAGAWA SA IT GALING SALES</b><br/>";
		echo "<div class='w3-small'>";
		$s_total="SELECT SUM(jo_amount) AS jo_amount_total,
						 SUM(jo_payment_amount) AS jo_payment_amount_total
				  FROM sales_jo
				  WHERE created_by='oliver_main' AND created_datetime>='2019-05-03 00:00:00' AND created_datetime<='2019-05-03 23:59:59'";
	
		$s="SELECT a.b_id, a.jo_actual, a.jo_no, a.client_id, a.jo_amount, a.jo_payment_amount, a.created_datetime, b.name
		FROM sales_jo a
		LEFT JOIN sales_clients b
			ON a.client_id=b.client_id
		WHERE a.created_by='oliver_main' AND a.created_datetime>='2019-05-03 00:00:00' AND a.created_datetime<='2019-05-03 23:59:59'
		ORDER BY a.created_datetime ASC, b.name ASC";
	}
	
	if(isset($_REQUEST['show_ar_from_finance']))
	{
		echo "<b class='w3-pale-blue'>SHOW ALL A.R. NA PINAGAWA SA IT GALING FINANCE</b><br/>";
		echo "<div class='w3-small'>";
		$s_total="SELECT SUM(jo_amount) AS jo_amount_total,
						 SUM(jo_payment_amount) AS jo_payment_amount_total
				  FROM sales_jo
				  WHERE created_by='oliver_main' AND created_datetime>='2019-05-23 00:00:00' AND created_datetime<='2019-06-30 23:59:59'";
	
		$s="SELECT a.b_id, a.jo_actual, a.jo_no, a.client_id, a.jo_amount, a.jo_payment_amount, a.created_datetime, b.name
		FROM sales_jo a
		LEFT JOIN sales_clients b
			ON a.client_id=b.client_id
		WHERE a.created_by='oliver_main' AND a.created_datetime>='2019-05-23 00:00:00' AND a.created_datetime<='2019-06-30 23:59:59'
		ORDER BY a.created_datetime ASC, b.name ASC";
	}
	
	if(isset($_REQUEST['show_ar_it_inserted']))
	{
		echo "<b class='w3-pale-blue'>SHOW ALL A.R. NA PINAGAWA SA IT GALING FINANCE</b><br/>";
		echo "<div class='w3-small'>";
		$s_total="SELECT SUM(jo_amount) AS jo_amount_total,
						 SUM(jo_payment_amount) AS jo_payment_amount_total
				  FROM sales_jo
				  WHERE created_by='oliver_main'";
	
		$s="SELECT a.b_id, a.jo_actual, a.jo_no, a.client_id, a.jo_amount, a.jo_payment_amount, a.created_datetime, b.name
		FROM sales_jo a
		LEFT JOIN sales_clients b
			ON a.client_id=b.client_id
		WHERE a.created_by='oliver_main'
		ORDER BY a.created_datetime ASC, b.name ASC";
	}
	
	$q_total=mysql_query($s_total) or die(mysql_error());
	$r_total=mysql_fetch_assoc($q_total);
	
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "JO TOTAL: <b>".number_format($r_total['jo_amount_total'],2)."</b><br/>";
	echo "JO PAYMENT TOTAL: <b class='w3-text-green'>".number_format($r_total['jo_payment_amount_total'],2)."</b><br/>";
	echo "AR LESS PAYMENT TOTAL: <b class='w3-text-red'>".number_format($r_total['jo_amount_total']-$r_total['jo_payment_amount_total'],2)."</b><br/>";
	echo "</div>";
	
	echo "<div class='w3-tiny'><i>records: <b>".mysql_num_rows($q)."</b></i></div>";

	echo "<table class='w3-tiny' border='1'>
			<tr class='w3-light-gray'>
				<td>#</td>
				<td>client_id</td>
				<td>name</td>
				<td>jo_no</td>
				<td>jo_actual</td>
				<td>jo_amount</td>
				<td>jo_payment_amount</td>
				<td>dr_no / date</td>
				<td>created_by</td>
				<td>created_datetime</td>
			</tr>";
	$x=1;
	do{
		
		echo "<tr class='w3-hover-pale-red'>
				<td><i class='w3-text-orange'>".$x++."</i></td>
				<td>".$r['client_id']."</td>
				<td>".$r['name']."</td>
				<td align='right'>".$r['jo_no']."</td>
				<td align='right'>".$r['jo_actual']."</td>";
				
				if($r['jo_amount']==$r['jo_payment_amount'])
				{
					echo "<td align='right' class='w3-pale-green'>".number_format($r['jo_amount'],2)."</td>";
					echo "<td align='right' class='w3-pale-green'>".number_format($r['jo_payment_amount'],2)."</td>";
				}
				elseif($r['jo_payment_amount']>0 and $r['jo_payment_amount']<$r['jo_amount'])
				{
					echo "<td align='right' class='w3-pale-red'>".number_format($r['jo_amount'],2)."</td>";
					echo "<td align='right' class='w3-pale-red'>".number_format($r['jo_payment_amount'],2)."</td>";
				}
				else
				{
					echo "<td align='right'>".number_format($r['jo_amount'],2)."</td>";
					echo "<td align='right'>".number_format($r['jo_payment_amount'],2)."</td>";
				}
				
		  echo "<td align='right'>";
				
				$b_id=$r['b_id'];
				$sc="SELECT dr_no, dr_date FROM sales_bookings_details WHERE b_id=$b_id";
				$qc=mysql_query($sc) or die(mysql_error());
				$rc=mysql_fetch_assoc($qc);
				
				do{ 
					if($rc['dr_no']!="0")
					{
					echo $rc['dr_no']." / ".$rc['dr_date']."<br/>"; 
					}else{}
				  } while($rc=mysql_fetch_assoc($qc));
		  
		  echo "</td>
				<td align='right'>".$r['created_by']."</td>
				<td align='right'>".$r['created_datetime']."</td>
			  </tr>";
		
	}while($r=mysql_fetch_assoc($q));
	echo "</table><br/>";
}

?>