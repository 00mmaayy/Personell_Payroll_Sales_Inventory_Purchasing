<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

if(isset($_REQUEST['xxx']))
{
	$s="SELECT a.*, b.name, c.department
		FROM sales_jo a 
		LEFT JOIN sales_clients b ON a.client_id = b.client_id
		LEFT JOIN users c ON a.created_by = c.username
		WHERE a.production_status<=1 AND a.jo_amount=a.jo_payment_amount AND a.jo_amount!=0 AND a.paid=1 AND c.department!='SALES'
		ORDER BY a.production_status DESC, c.department ASC";
			
	$q=mysql_query($s) or die(mysql_fetch_assoc());
	$r=mysql_fetch_assoc($q);
	$x=1;
	do{
		
		$b_id=$r['b_id'];
		$s1="SELECT SUM(dr_qty*b_amount) AS dr_total FROM sales_bookings_details WHERE b_id='$b_id'";
		$q1=mysql_query($s1) or die(mysql_error());
		$r1=mysql_fetch_assoc($q1);	
		
		if($r['jo_amount']==$r1['dr_total'])
		{
				$jo_no=$r['jo_no'];
				$s1="UPDATE sales_jo SET production_status = 8, production_date = now() WHERE jo_no = $jo_no";
				$q1=mysql_query($s1) or die(mysql_query());
		}
		else{}
				
	}while($r=mysql_fetch_assoc($q));

	header('Location: script_sales_fg_cleaner.php?done=1');
}

else
{
	echo "DONE!";
	?>
		<!-- 3 seconds count down to close -->
		<script type='text/javascript'>
			setTimeout(function () { window.close(); }, 3000);
		</script>
	
	<?php
}
?>
