<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="summary_per_client_history")
{
	
	if(isset($_REQUEST['sdate']))
	{
	$sdate=$_REQUEST['sdate'];
	$edate=$_REQUEST['edate'];
	
	$sdate1=$_REQUEST['sdate']." 00:00:00";
	$edate1=$_REQUEST['edate']." 23:59:59";

	$datex="created_datetime > '$sdate1' and created_datetime < '$edate1'";
	$datex1="and a.created_datetime > '$sdate1' and a.created_datetime < '$edate1'";
	}else{ $datex=""; $datex1=""; }
	
	$s_ar_t="SELECT sum(jo_amount) - sum(jo_payment_amount) as total_ar
			 FROM sales_jo where $datex";
  
	$q_ar_t=mysql_query($s_ar_t) or die(mysql_error());
	$r_ar_t=mysql_fetch_assoc($q_ar_t);
	
	echo "<b>Overall AR Total: <span class='w3-text-red'>".number_format($r_ar_t['total_ar'],2)."</span></b>";
	
	$s="SELECT b.name,
			   a.client_id,
      	       (select sum(a.jo_amount) - sum(a.jo_payment_amount)) as ar
		FROM sales_jo a
		INNER JOIN sales_clients b ON a.client_id = b.client_id
		WHERE (select sum(a.jo_amount) - sum(a.jo_payment_amount)) != 0 $datex1
		GROUP BY a.client_id
		ORDER BY ar DESC";
  
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<table class='w3-table w3-tiny' border='1'>";
			echo "<tr class='w3-light-gray'>
					<td>#</td>
					<td>client_id</td>
					<td>name</td>
					<td>AR Total</td>
			     </tr>";

	$x=1;
	
	do
	{
			echo "<tr>
					<td>".$x++.".</td>
					<td>".$r['client_id']."</td>
					<td>".$r['name']."</td>
					<td><b><a target='_blank' href='script_sales_rep_summary_per_client_detailed1.php?client_id=".$r['client_id']."&name=".$r['name']."'>".number_format($r['ar'],2)."</a></b></td>
				  </tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";
}
?>