<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="sales_recording")
{

$s0="SELECT
		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.pay_mode='Cash' 
			AND a.pay_type='Full'
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as xx_cash,
			
		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.pay_mode='2307'
			AND a.pay_type='Full'
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as xx_2307,

		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.pay_mode='2306'
			AND a.pay_type='Full'
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as xx_2306,
			
		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.or_no=0
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as no_or,
			
		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.or_no!=0
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as with_or,
			
		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.pay_mode='Cash' 
			AND a.pay_type='Partial'
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as xx_cash_partial,
			
		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.pay_mode='2307'
			AND a.pay_type='Partial'
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as xx_2307_partial,

		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.pay_mode='2306'
			AND a.pay_type='Partial'
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as xx_2306_partial,
			
		(	SELECT sum(a.payment)
			FROM sales_jo_payments a 
			INNER JOIN sales_jo b on a.jo_no=b.jo_no
			INNER JOIN sales_bookings e on b.b_id=e.b_id
			LEFT JOIN users c on b.created_by=c.username
			LEFT JOIN sales_clients d on b.client_id=d.client_id
			WHERE e.bch='main'
			AND a.or_no=0
			AND a.pay_type='Partial'
			AND a.payment_datetime>='$sdate1'
			AND a.payment_datetime<='$edate1'
			AND b.created_datetime>='$sdate1'
			AND b.created_datetime<='$edate1' )  as no_or_partial	
	";
	
$q0=mysql_query($s0) or die(mysql_error());
$r0=mysql_fetch_assoc($q0);

	//All JO created within the day; Fully Paid within the day
	echo "<table border='1'>
			<tr><td>CASH</td><td>".$r0['xx_cash']."</td><td></td><td></td></tr>
			<tr><td>2307</td><td>".$r0['xx_2307']."</td><td></td><td></td></tr>
			<tr><td>2306</td><td>".$r0['xx_2306']."</td><td></td><td></td></tr>
			<tr><td></td><td>Sales A</td><td>".number_format($r0['no_or'],2)."</td></tr>
			<tr><td></td><td>Sales B</td><td>".number_format($r0['with_or']/1.12,2)."</td></tr>
			<tr><td></td><td>Output Tax</td><td>".number_format(($r0['with_or']/1.12)*0.12,2)."</td></tr>
		</table>
		
		<br/><br/>";
	
	//All JO created within the day; Partially Paid within the day
	echo "<table border='1'>
			<tr><td>CASH</td><td>".$r0['xx_cash_partial']."</td><td></td><td></td></tr>
			<tr><td>2307</td><td>".$r0['xx_2307_partial']."</td><td></td><td></td></tr>
			<tr><td>2306</td><td>".$r0['xx_2306_partial']."</td><td></td><td></td></tr>
			<tr><td></td><td>Sales A</td><td>".number_format($r0['no_or_partial'],2)."</td></tr>
		</table>";	
}
?>