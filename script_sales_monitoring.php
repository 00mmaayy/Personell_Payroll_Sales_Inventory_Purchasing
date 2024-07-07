<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

date_default_timezone_set("Asia/Manila");
$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
?>
<title><?php echo $r['company_name']; ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php
$sdate=$_REQUEST['sdate'];
$edate=$_REQUEST['edate'];

$sdate1=$_REQUEST['sdate']." 00:00:00";
$edate1=$_REQUEST['edate']." 23:59:59";

$username=$_SESSION['username'];
$qxx=mysql_query("select bch from users where username='$username'");
$rxx=mysql_fetch_assoc($qxx);

//quotaion code ranking start-----
if(isset($_REQUEST['quotation_code_ranking_monitor']))
{
$branch=$_REQUEST['branch'];	
$code_set=$_REQUEST['code_set'];

if($_REQUEST['branch']=="ALL")
{ $s="select * from sales_quotations_details where q_date>='$sdate' and q_date<='$edate' and code_set='$code_set' order by q_id desc"; }
else
{
  $s="SELECT b.*
  FROM sales_quotations_details AS b
  JOIN sales_codes AS c ON b.code_set=c.code_set
  JOIN users AS u ON b.created_by=u.username
  WHERE u.department='$branch' AND b.q_date>='$sdate' AND b.q_date<='$edate' AND b.code_set='$code_set' 
  ORDER BY b.q_id DESC";
}	

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
$count=mysql_num_rows($q);

$s2="select * from sales_codes where code_set='$code_set'";
$q2=mysql_query($s2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);

echo "<div class='container'><br>";

echo "<table class='table'>
		<tr class='w3-light-gray' align='center'>
			<td colspan='7'><b class='w3-text-indigo'>".$code_set."</b> / ".$r2['code_name']." / ".$r2['code_desc']." <b class='w3-text-red'>($count)</b> entries</td>
		</tr>
		<tr class='w3-light-gray'>
			<td>CLIENT</td><td>QUOTATION NO</td><td>QUANTITY</td><td>UNIT</td><td>SIZE</td><td>DETAILS</td><td>AMOUNT</td>
		</tr>";
        do{
			$q_id=$r['q_id'];
			$sx="select sales_clients.name as client from sales_clients inner join sales_quotations on sales_quotations.client_id=sales_clients.client_id where sales_quotations.q_id=$q_id";
			$qx=mysql_query($sx) or die(mysql_error());
			$rx=mysql_fetch_assoc($qx);
			
			echo "<tr class='w3-hover-pale-red'>
						<td><b class='w3-text-indigo'>".$rx['client']."</b></td>
						<td>".$r['q_id']."</td>
						<td>".$r['q_qty']."</td>
						<td>".$r['q_unit']."</td>
						<td>".$r['q_size']."</td>
						<td>".$r['q_desc']."</td>
						<td class='w3-text-red'>".number_format($r['q_qty']*$r['q_amount'],2)."</td>
				  </tr>";
		  }while($r=mysql_fetch_assoc($q));

 echo "</table>";

echo "</div>";

}
//quotation code ranking end-----




//booking code ranking start-----
if(isset($_REQUEST['booking_code_ranking_monitor']))
{
$branch=$_REQUEST['branch'];	
$code_set=$_REQUEST['code_set'];

	if($_REQUEST['branch']=="ALL")
	{ $s="select a.*, d.jo_no 
			from sales_bookings_details a 
			LEFT JOIN sales_jo d ON a.b_id=d.b_id 
		where b_date>='$sdate' and b_date<='$edate' and code_set='$code_set' order by b_id desc"; }
	else
	{
	  $s="SELECT b.*,d.jo_no
	  FROM sales_bookings_details AS b
	  JOIN sales_codes AS c ON b.code_set=c.code_set
	  JOIN users AS u ON b.created_by=u.username
	  LEFT JOIN sales_jo AS d ON b.b_id=d.b_id
	  WHERE u.department='$branch' AND b.b_date>='$sdate' AND b.b_date<='$edate' AND b.code_set='$code_set' 
	  ORDER BY b.b_id DESC";
	}	
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	$count=mysql_num_rows($q);

	$s2="select * from sales_codes where code_set='$code_set'";
	$q2=mysql_query($s2) or die(mysql_error());
	$r2=mysql_fetch_assoc($q2);

echo "<div class='container'><br>";

echo "<table class='table w3-small'>
		<tr class='w3-light-gray' align='center'>
			<td colspan='7'><b class='w3-text-indigo'>".$code_set."</b> / ".$r2['code_name']." / ".$r2['code_desc']." <b class='w3-text-red'>($count)</b> entries. Total of <b class='w3-text-pink w3-xlarge'>P ".number_format($_REQUEST['total'],2)."</b></td>
		</tr>
		<tr class='w3-light-gray'>
			<td>CLIENT</td><td>JO NO</td><td>JO QTY</td><td>UNIT</td><td>SIZE</td><td>DETAILS</td><td>AMOUNT</td>
		</tr>";
        do{
			$b_id=$r['b_id'];
			$sx="select sales_clients.name as client, sales_clients.mobile as mobile, sales_clients.telno as telno from sales_clients inner join sales_bookings on sales_bookings.client_id=sales_clients.client_id where sales_bookings.b_id=$b_id";
			$qx=mysql_query($sx) or die(mysql_error());
			$rx=mysql_fetch_assoc($qx);
			
			echo "<tr class='w3-hover-pale-red'>
						<td><b class='w3-text-indigo'>".$rx['client']."</b></td>
						<td>".$r['jo_no']."</td>
						<td>".$r['b_qty']."</td>
						<td>".$r['b_unit']."</td>
						<td>".$r['b_size']."</td>
						<td>".$r['b_desc']."</td>
						<td class='w3-text-red'>".number_format($r['b_qty']*$r['b_amount'],2)."</td>
				  </tr>";
		  }while($r=mysql_fetch_assoc($q));

 echo "</table>";

echo "</div>";
}
//booking code ranking end-----




//transaction ranking start-----
if(isset($_REQUEST['trans_no']))
{
$branch=$_REQUEST['branch'];	
$trans_no=$_REQUEST['trans_no'];

if($_REQUEST['branch']=="ALL")
{ $s="select * from sales_jo where created_datetime>='$sdate' and created_datetime<='$edate' and trans_type=$trans_no order by jo_no desc"; }
else
{	
$s="SELECT s.jo_no AS jo_no, s.client_id AS client_id, u.department AS branch
FROM sales_jo AS s
INNER JOIN users AS u ON u.username=s.created_by
WHERE u.department='$branch' AND created_datetime>='$sdate' AND created_datetime<='$edate' AND trans_type=$trans_no
ORDER BY jo_no DESC";
}

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
$count=mysql_num_rows($q);

$s2="select * from sales_transaction_type where trans_no=$trans_no";
$q2=mysql_query($s2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);

echo "<div class='container'><br>";

echo "<table class='table'>
		<tr class='w3-light-gray'>
			<td colspan='6' class='w3-text-indigo' align='center'>(<b class='w3-text-red'>".$_REQUEST['branch']."</b>) <b class='w3-xlarge'>".$r2['trans_desc']."</b> <b class='w3-text-red'>($count)</b> entries</td>
		</tr>
		<tr class='w3-light-gray'>
			<td>JO NO.</td>
			<td>CLIENT NAME</td>
			<td>MOBILE</td>
			<td>TEL. NO</td>
			<td>EMAIL</td>
			<td>CONTACT PERSON</td>
		</tr>";
		
        do{
			$client_id=$r['client_id'];
			$s1="select * from sales_clients where client_id=$client_id";
			$q1=mysql_query($s1) or die(mysql_error());
			$r1=mysql_fetch_assoc($q1);
			
			echo "<tr class='w3-hover-pale-red'>
					<td>".$r['jo_no']."</td>
					<td>".$r1['name']."</td>
					<td>".$r1['mobile']."</td>
					<td>".$r1['telno']."</td>
					<td>".$r1['email']."</td>
					<td>".$r1['contact_person']."</td>
				  </tr>";
		  
		  } while($r=mysql_fetch_assoc($q));
	  
 echo "</table>";

echo "</div>";
}
//transaction ranking end-----








//CLIENT ranking start-----
if(isset($_REQUEST['client_id']))
{
echo "<div class='container'><br>";

$sdate=$_REQUEST['sdate'];
$edate=$_REQUEST['edate'];
$client_id=$_REQUEST['client_id'];

$s="SELECT a.*, b.jo_no, c.name
	FROM sales_bookings_details a
	INNER JOIN sales_jo b ON a.b_id=b.b_id
	LEFT JOIN sales_clients c ON b.client_id=c.client_id
	WHERE b.client_id=$client_id AND a.dr_date>='$sdate' AND a.dr_date<='$edate' AND a.dr_qty!=0";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<table class='w3-table' border='1'>
		<tr class='w3-pink'>
			<td colspan='8'>".$r['name']."</td>
		</tr>
		<tr class='w3-green'>
			<td>JO NO</td>
			<td>UNIT PRICE</td>
			<td>DR QTY</td>
			<td>UNIT</td>
			<td>SIZE</td>
			<td>CODE</td>
			<td>PARTICULAR</td>
			<td>DR TOTAL</td>
		</tr>";

do{
	echo "<tr>
			<td>".$r['jo_no']."</td>
			<td>".$r['b_amount']."</td>
			<td>".$r['dr_qty']."</td>
			<td>".$r['b_unit']."</td>
			<td>".$r['b_size']."</td>
			<td>".$r['code_set']."</td>
			<td>".$r['b_desc']."</td>
			<td>".number_format($r['dr_qty']*$r['b_amount'],2)."</td>
		  </tr>";
		  $grand_total += $r['dr_qty']*$r['b_amount'];
			
  }while($r=mysql_fetch_assoc($q));

  echo "<tr><td colspan='7'></td><td><b>".number_format($grand_total,2)."<b/></td></tr>
	  </table>";

	
echo "</div>";
}
//CLIENT ranking end-----








if(isset($_REQUEST['cash_dr']))
{
	if(isset($_REQUEST['branch1']))
	{
		if($_REQUEST['branch1']!="ALL")
		{
			if(isset($_REQUEST['bch']))
			{
				if($_REQUEST['bch']=="main"){ $branch2="SALES"; }
				if($_REQUEST['bch']=="sm"){ $branch2="SM SALES"; }
				if($_REQUEST['bch']=="rzl"){ $branch2="RIZAL SALES"; }
				if($_REQUEST['bch']=="sp"){ $branch2="SANPEDRO SALES"; }
				if($_REQUEST['bch']=="sj"){ $branch2="SANJOSE SALES"; }
				$branchx="and d.department='$branch2'";
			}
			else
			{
				$branch2=$_REQUEST['branch1'];
				$branchx="and d.department='$branch2'";
			}
		
		}
		else 
		{ $branchx=""; }
	
	}
	else
	{ $branchx=""; }
		
	$s="select a.dr_qty as dr_qty,
			   a.b_amount as b_amount,
			   a.created_by as created_by,
			   a.dr_no as dr_no,
			   a.dr_date as dr_date,
			   a.dr_posted_date as dr_posted_date,
			   a.dr_posted_by as dr_posted_by,
			   b.jo_no as jo_no,
			   b.jo_actual as jo_actual,
			   b.jo_actual_date as jo_actual_date,
			   b.client_id as client_id,
			   c.name as name,
			   d.department as department
		from sales_bookings_details as a
		inner join sales_jo as b on a.b_id=b.b_id
		inner join sales_clients as c on b.client_id=c.client_id
		inner join users as d on a.created_by=d.username
		where a.dr_date>='$sdate1' and a.dr_posted_date<='$edate1' and a.dr_no>0 and b.paid=1 $branchx
		order by d.department asc";
		
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	
	$payment_total1="select sum(a.dr_qty*a.b_amount) as payment_total
				     from sales_bookings_details as a
			         inner join sales_jo as b on a.b_id=b.b_id
				     inner join users as d on a.created_by=d.username
			         where a.dr_posted_date>='$sdate1' and a.dr_posted_date<='$edate1' and a.dr_no>0 and b.paid=1 $branchx";
	$payment_total_query=mysql_query($payment_total1) or die(mysql_error());
	$payment_total=mysql_fetch_assoc($payment_total_query);
	
	
	
	echo "<div class='container'><div align='center'>(CASH DR) TOTAL SALES VIEW</div>";
	echo "<table align='center' class='table w3-small'>";
      echo "<tr>
				<td align='center' colspan='11'>
					<i>Report from</i> <b>".date('F d, Y',strtotime($_REQUEST['sdate']))."</b> <i>to</i> <b>".date('F d, Y',strtotime($_REQUEST['edate']))."</b>
				</td>
			</tr>";
	  echo "<tr>
				<td colspan='14'>
					<table width='100%'>
						<tr valign='top'>
							<td align='left' width='40%'>"; 
							
							if($rxx['bch']=="goc")
							{	
							?>
							
								<form>
									<input name='cash_dr' type='hidden' value='1'>
									<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
									<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
									<select required class='w3-tiny' name='branch1'>
									<option class='w3-tiny' value='<?php echo $_REQUEST['branch1']; ?>'><?php echo $_REQUEST['branch1']; ?></option>
									<option class='w3-tiny'></option>
									<option class='w3-tiny'>ALL</option>
									<?php
									 $sa="select department from users where department like '%SALES%' group by department";
									 $qa=mysql_query($sa);
									 $ra=mysql_fetch_assoc($qa);
									 do{
										echo "<option class='w3-tiny'>".$ra['department']."</option>"; 
									 }while($ra=mysql_fetch_assoc($qa));
									?>
								</select>
								<input class='btn w3-tiny' type='submit' value='FILTER'>
								</form>
							
							<?php
							}
							
								echo "<i class='w3-tiny'>AMOUNT TOTAL:</i> <b class='w3-text-green'>".number_format($payment_total['payment_total'],2)."</b><br/>
							</td>
						</tr>
					</table>
				</td>
			</tr>";
		
	  echo "<tr class='w3-light-gray'>
				<td>#</td>
				<td><b>CLIENT</b></td>
				<td><b>BRANCH</b></td>
				<td align='right'><b>JO</b></td>
				<td align='right'><b>JO ACTUAL</b></td>
				<td align='right'><b>JO DATE</b></td>
				<td align='right'><b>DR</b></td>
				<td align='right'><b>DR DATE</b></td>
				<td align='right'><b>DR POSTED BY</b></td>
				<td align='right'><b>DR POSTED DATE</b></td>
				<td align='right'><b>DR AMOUNT</b></td>
			</tr>";
		$x=1;	
	do{
		
		echo "<tr class='w3-hover-pale-red'>
				  <td>".$x++."</td>
				  <td>".$r['name']."</td>
				  <td>".$r['department']."</td>
				  <td align='right'>".$r['jo_no']."</td>
				  <td align='right'>".$r['jo_actual']."</td>
				  <td align='right'>".$r['jo_actual_date']."</td>
				  <td align='right'>".$r['dr_no']."</td>
				  <td align='right'>".$r['dr_date']."</td>
				  <td align='right'>".$r['dr_posted_by']."</td>
				  <td align='right'>".$r['dr_posted_date']."</td>
				  <td align='right'><b class='w3-text-indigo'>".number_format($r['dr_qty']*$r['b_amount'],2)."</b></td>";
		echo "</tr>";
	
	}while($r=mysql_fetch_assoc($q));
    
	echo "</table>";
	echo "</div>";

}








if(isset($_REQUEST['sales_on_account']))
{
	if(isset($_REQUEST['branch1']))
	{
	
  	  if($_REQUEST['branch1']!="ALL")
		{
			if(isset($_REQUEST['bch']))
			{
				if($_REQUEST['bch']=="main"){ $branch2="SALES"; }
				if($_REQUEST['bch']=="sm"){ $branch2="SM SALES"; }
				if($_REQUEST['bch']=="rzl"){ $branch2="RIZAL SALES"; }
				if($_REQUEST['bch']=="sp"){ $branch2="SANPEDRO SALES"; }
				if($_REQUEST['bch']=="sj"){ $branch2="SANJOSE SALES"; }
				$branchx="and d.department='$branch2'";
			}
			else
			{
				$branch2=$_REQUEST['branch1'];
				$branchx="and d.department='$branch2'";
			}
		}
		else 
		{ $branchx=""; }
	
	}
	else
	{ $branchx=""; }
		
	
	$s="select a.dr_qty as dr_qty,
			   a.b_amount as b_amount,
			   a.created_by as created_by,
			   a.dr_no as dr_no,
			   a.dr_date as dr_date,
			   a.dr_posted_date as dr_posted_date,
			   a.dr_posted_by as dr_posted_by,
			   b.jo_no as jo_no,
			   b.jo_actual as jo_actual,
			   b.jo_actual_date as jo_actual_date,
			   b.client_id as client_id,
			   c.name as name,
			   d.department as department
		from sales_bookings_details as a
		inner join sales_jo as b on a.b_id=b.b_id
		inner join sales_clients as c on b.client_id=c.client_id
		inner join users as d on a.created_by=d.username
		where a.dr_posted_date>='$sdate1' and a.dr_posted_date<='$edate1' and a.dr_no>0 and b.paid=0 $branchx
		order by d.department asc";		
	

	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	
	$payment_total1="select sum(a.dr_qty*a.b_amount) as payment_total
				    from sales_bookings_details as a
			        inner join sales_jo as b on a.b_id=b.b_id
				    inner join users as d on a.created_by=d.username
			        where a.dr_posted_date>='$sdate1' and a.dr_posted_date<='$edate1' and a.dr_no>0 and b.paid=0 $branchx";
	$payment_total_query=mysql_query($payment_total1) or die(mysql_error());
	$payment_total=mysql_fetch_assoc($payment_total_query);
	
	
	
	echo "<div class='container'><div align='center'>(SALES ON ACCOUNT DR) TOTAL SALES VIEW</div>";
	echo "<table align='center' class='table w3-small'>";
      echo "<tr>
				<td align='center' colspan='11'>
					<i>Report from</i> <b>".date('F d, Y',strtotime($_REQUEST['sdate']))."</b> <i>to</i> <b>".date('F d, Y',strtotime($_REQUEST['edate']))."</b>
				</td>
			</tr>";
	  echo "<tr>
				<td colspan='14'>
					<table width='100%'>
						<tr valign='top'>
							<td align='left' width='40%'>"; 
							
							if($rxx['bch']=="goc")
							{	
							?>
							
								<form>
									<input name='sales_on_account' type='hidden' value='1'>
									<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
									<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
									<select required class='w3-tiny' name='branch1'>
									<option class='w3-tiny' value='<?php echo $_REQUEST['branch1']; ?>'><?php echo $_REQUEST['branch1']; ?></option>
									<option class='w3-tiny'></option>
									<option class='w3-tiny'>ALL</option>
									<?php
									 $sa="select department from users where department like '%SALES%' group by department";
									 $qa=mysql_query($sa);
									 $ra=mysql_fetch_assoc($qa);
									 do{
										echo "<option class='w3-tiny'>".$ra['department']."</option>"; 
									 }while($ra=mysql_fetch_assoc($qa));
									?>
								</select>
								<input class='btn w3-tiny' type='submit' value='FILTER'>
								</form>
							
							<?php
							}
								echo "<i class='w3-tiny'>AMOUNT TOTAL:</i> <b class='w3-text-green'>".number_format($payment_total['payment_total'],2)."</b><br/>
							</td>
						</tr>
					</table>
				</td>
			</tr>";
		
	  echo "<tr class='w3-light-gray'>
				<td>#</td>
				<td><b>CLIENT</b></td>
				<td><b>BRANCH</b></td>
				<td align='right'><b>JO</b></td>
				<td align='right'><b>JO ACTUAL</b></td>
				<td align='right'><b>JO DATE</b></td>
				<td align='right'><b>DR</b></td>
				<td align='right'><b>DR DATE</b></td>
				<td align='right'><b>DR POSTED BY</b></td>
				<td align='right'><b>DR POSTED DATE</b></td>
				<td align='right'><b>DR AMOUNT</b></td>
			</tr>";
		$x=1;	
	do{
		
		echo "<tr class='w3-hover-pale-red'>
				  <td>".$x++."</td>
				  <td>".$r['name']."</td>
				  <td>".$r['department']."</td>
				  <td align='right'>".$r['jo_no']."</td>
				  <td align='right'>".$r['jo_actual']."</td>
				  <td align='right'>".$r['jo_actual_date']."</td>
				  <td align='right'>".$r['dr_no']."</td>
				  <td align='right'>".$r['dr_date']."</td>
				  <td align='right'>".$r['dr_posted_by']."</td>
				  <td align='right'>".$r['dr_posted_date']."</td>
				  <td align='right'><b class='w3-text-indigo'>".number_format($r['dr_qty']*$r['b_amount'],2)."</b></td>";
		echo "</tr>";
	
	}while($r=mysql_fetch_assoc($q));
    
	echo "</table>";
	echo "</div>";

}








if(isset($_REQUEST['total_posted']))
{ 
	if(isset($_REQUEST['deposit']))
	{
		$id=$_REQUEST['id'];
		$user=$_SESSION['username'];
		if($_REQUEST['deposit']=='yes')
		{ 
			mysql_query("update sales_jo_payments set deposited=1 where id=$id");
			$trans="set payment id: $id to deposited";
			$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
			$log_query=mysql_query($log_sql) or die(mysql_error());
		}
		else
		{ 
			mysql_query("update sales_jo_payments set deposited=0 where id=$id");
			$trans="set payment id: $id to not yet deposited";
			$log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$user','$trans')";
			$log_query=mysql_query($log_sql) or die(mysql_error());
		}
	header('Location: script_sales_monitoring.php?sortby='.$_REQUEST['sortby'].'&total_posted='.$_REQUEST['total_posted'].'&sdate='.$_REQUEST['sdate'].'&edate='.$_REQUEST['edate'].'&branch1='.$_REQUEST['branch1']);
	}

	if(isset($_REQUEST['branch1']))
	{	
		if($_REQUEST['branch1']=="ALL")															{ $branch1=""; }
		if($_REQUEST['branch1']=="SALES" or $_REQUEST['branch1']=="FINANCE") 					{ $branch1=" and c.department='SALES'"; }
		if($_REQUEST['branch1']=="SANJOSE SALES" or $_REQUEST['branch1']=="SANJOSE FINANCE")  	{ $branch1=" and c.department='SANJOSE SALES'"; }
		if($_REQUEST['branch1']=="SANPEDRO SALES" or $_REQUEST['branch1']=="SANPEDRO FINANCE")	{ $branch1=" and c.department='SANPEDRO SALES'"; }
		if($_REQUEST['branch1']=="SM SALES" or $_REQUEST['branch1']=="SM FINANCE")				{ $branch1=" and c.department='SM SALES'"; }		
		
		if($_REQUEST['sortby']=="jo")    { $sortby="a.jo_no desc"; }
		if($_REQUEST['sortby']=="date")  { $sortby="a.payment_datetime desc"; }
		if($_REQUEST['sortby']=="user")  { $sortby="a.payment_by desc"; }
		if($_REQUEST['sortby']=="client"){ $sortby="a.client_id desc"; }
		if($_REQUEST['sortby']=="status"){ $sortby="a.pay_type desc"; }
	}
	else
	{ $sortby="a.pay_type desc"; }

	 $s="select a.*,
				b.jo_actual as jo_actual,
				b.jo_actual_date as jo_actual_date,
				b.b_id as b_id,
				b.completed_by as completed_by,
				c.department as department
		from sales_jo_payments as a
		inner join sales_jo as b
		on a.jo_no=b.jo_no
		inner join users as c
		on b.created_by=c.username
		where a.or_date>='$sdate' and a.or_date<='$edate' $branch1
		order by $sortby";
		
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<div>";
	echo "<div align='center'>TOTAL POSTED PAYMENTS VIEW <i>(Based on OR date)</i><br/>";
	echo "<a href='script_sales_print_dsr.php?sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&branch1=".$_REQUEST['branch1']."' target='_blank'><i class='fa fa-print'></i> PRINT</a><i class='w3-text-gray w3-tiny'>(Note: Deposited Amount Only)</i>";
	echo "</div>";
	echo "<table align='center' class='table w3-small'>";
      echo "<tr>
				<td align='center' colspan='9'>
					<i>Report from</i> <b>".date('F d, Y',strtotime($_REQUEST['sdate']))."</b> <i>to</i> <b>".date('F d, Y',strtotime($_REQUEST['edate']))."</b>
				</td>
				<td colspan='9'>"; 
				
				if($rxx['bch']=="goc")
				{ ?>
			
					<form method='get'>
						<b class='w3-tiny'>SORT BY CATEGORY:</b>
						    <input name='total_posted' type='hidden' value='1'>
							<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
							<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
							<select required name='sortby'>
								<option class='w3-tiny' value='<?php echo $_REQUEST['sortby']; ?>'><?php echo $_REQUEST['sortby']; ?></option>
								<option class='w3-tiny'></option>
								<option class='w3-tiny' value='jo'>JO</option>
								<option class='w3-tiny' value='date'>DATE</option>
								<option class='w3-tiny' value='user'>USER</option>
								<option class='w3-tiny' value='client'>CLIENT</option>
								<option class='w3-tiny' value='status'>STATUS</option>
							</select>
							
							<select required name='branch1'>
								<option class='w3-tiny' value='<?php echo $_REQUEST['branch1']; ?>'><?php echo $_REQUEST['branch1']; ?></option>
								<option class='w3-tiny'></option>
								<option class='w3-tiny'>ALL</option>
								<?php
								 $sa="select department from users where department like '%SALES%' group by department";
								 $qa=mysql_query($sa);
								 $ra=mysql_fetch_assoc($qa);
								 do{
									echo "<option>".$ra['department']."</option>"; 
								 }while($ra=mysql_fetch_assoc($qa));
							    ?>
							</select>
							<input class='btn w3-tiny' type='submit' value='GO!'>
					</form>
	
	<?php 		}
	
		echo "</td>
			</tr>";
			
			
			
		
	$s1="select 
			(	select sum(a.payment)
				from sales_jo_payments as a
				inner join sales_jo as b
				on a.jo_no=b.jo_no
				inner join users as c
				on b.created_by=c.username
				where a.or_date>='$sdate' and a.or_date<='$edate' $branch1	) as total_all,
				
			(	select sum(a.payment)
				from sales_jo_payments as a
				inner join sales_jo as b
				on a.jo_no=b.jo_no
				inner join users as c
				on b.created_by=c.username
				where a.pay_mode='Discount' and a.or_date>='$sdate' and a.or_date<='$edate' $branch1  ) as total_Discount,
				
			(	select sum(a.payment)
				from sales_jo_payments as a
				inner join sales_jo as b
				on a.jo_no=b.jo_no
				inner join users as c
				on b.created_by=c.username
				where a.pay_mode='Sponsor' and a.or_date>='$sdate' and a.or_date<='$edate' $branch1  ) as total_Sponsor,
				
			(	select sum(a.payment)
				from sales_jo_payments as a
				inner join sales_jo as b
				on a.jo_no=b.jo_no
				inner join users as c
				on b.created_by=c.username
				where a.pay_mode='Exdeal' and a.or_date>='$sdate' and a.or_date<='$edate' $branch1  ) as total_Exdeal,
				
			(	select sum(a.payment)
				from sales_jo_payments as a
				inner join sales_jo as b
				on a.jo_no=b.jo_no
				inner join users as c
				on b.created_by=c.username
				where a.pay_mode='VatExempt' and a.or_date>='$sdate' and a.or_date<='$edate' $branch1  ) as total_VatExempt,
			
			(	select sum(a.payment)
				from sales_jo_payments as a
				inner join sales_jo as b
				on a.jo_no=b.jo_no
				inner join users as c
				on b.created_by=c.username
				where a.pay_mode='2306' and a.or_date>='$sdate' and a.or_date<='$edate' $branch1  ) as total_2306,

			(	select sum(a.payment)
				from sales_jo_payments as a
				inner join sales_jo as b
				on a.jo_no=b.jo_no
				inner join users as c
				on b.created_by=c.username
				where a.pay_mode='2307' and a.or_date>='$sdate' and a.or_date<='$edate' $branch1  ) as total_2307
			";	
		
	$q1=mysql_query($s1) or die(mysql_error());
	$r1=mysql_fetch_assoc($q1);
	
	echo "<tr>";
	echo "<td colspan='2'>Total:<br/><b>".number_format($r1['total_all'],2)."</b></td>";
	echo "<td colspan='2'>Discount:<br/><b>".number_format($r1['total_Discount'],2)."</b></td>";		
	echo "<td colspan='2'>Sponsor:<br/><b>".number_format($r1['total_Sponsor'],2)."</b></td>";		
	echo "<td colspan='2'>Exdeal:<br/><b>".number_format($r1['total_Exdeal'],2)."</b></td>";		
	echo "<td colspan='2'>Vat Exempt:<br/><b>".number_format($r1['total_VatExempt'],2)."</b></td>";		
	echo "<td colspan='2'>Total 2306:<br/><b>".number_format($r1['total_2306'],2)."</b></td>";		
	echo "<td colspan='2'>Total 2307:<br/><b>".number_format($r1['total_2307'],2)."</b></td>";		
	echo "</tr>";
			
			
			
	  echo "<tr class='w3-light-gray'>
				<td>#</td>
				<td>NAME</td>
				<td>BRANCH</td>
				<td align='right'>JO NO</td>
				<td align='right'>JO ACTUAL</td>
				<td align='right'>JO ACTUAL DATE</td>
				<td align='right'>JO AMOUNT</td>
				<td align='right'>JO STATUS</td>
				<td align='right'>PAY MODE</td>
				<td align='right'>PAYMENT</td>
				<td align='right'>RS NO</td>
				<td align='right'>OR NO</td>
				<td align='right'>OR DATE</td>
				<td align='right'>DR</td>
				<td align='right'>PAY INFO</td>
				<td align='right'>PAYMENT BY</td>
				<td align='right'>PAYMENT POSTED</td>
				<td align='right'>DEPOSITED</td>
				<td align='right'>ACTION</td>
			</tr>";
		$x=1;	
	do{
		
		$client_id=$r['client_id'];
		$q1=mysql_query("select * from sales_clients where client_id='$client_id'");
		$r1=mysql_fetch_assoc($q1);
		
		echo "<tr class='w3-hover-pale-red'>";
			echo "<td>".$x++."</td>
				  <td>".$r1['client_id']." - ".$r1['name']."</td>
				  <td>".$r['department']."</td>
				  <td align='right'>".$r['jo_no']."</td>
				  <td align='right'>".$r['jo_actual']."</td>
				  <td align='right'>".date('m/d/Y',strtotime($r['jo_actual_date']))."</td>
				  <td align='right'><b class='w3-text-blue'>".number_format($r['jo_amount'],2)."</b></td>
				  <td align='right'>";
						if($r['completed_by']!=""){ echo "<i class='w3-text-blue'>Completed</i>"; }
			echo "</td>
				  <td align='right'>";
				  
				  if($r['pay_mode']=="Cash" or $r['pay_mode']=="Cheque")
				  {
					echo $r['pay_mode'];
				  }			  
				  else
				  {
					  echo "<span class='w3-text-red'>".$r['pay_mode']."</span>";
				  }
			 
			 echo "</td>
				  
				  
				  <td align='right'><b class='w3-text-green'>".number_format($r['payment'],2)."</b></td>
				  
				  <td align='right'>".$r['rs_no']."</td>
				  <td align='right'>".$r['or_no']."</td>
				  <td align='right' class='w3-text-purple'>".date('m/d/Y',strtotime($r['or_date']));
				  echo "<td align='right'>";
					
					$b_id=$r['b_id'];
					$sxx="select dr_no from sales_bookings_details where b_id='$b_id' group by dr_no";
					$qxx=mysql_query($sxx) or die(mysql_error());
					$rxx=mysql_fetch_assoc($qxx);
					do{ if($rxx['dr_no']!=0){ echo $rxx['dr_no']."</br>"; }else{ if($r['pay_type']=="Partial"){}else{ echo "<i class='w3-text-red'>UnEarned</i><br/>"; } } } while ($rxx=mysql_fetch_assoc($qxx));
					
			echo "</td>";
				  
			echo "<td align='right'>";
				  
				  if($r['pay_type']=="Full")
				  { echo "<i class='w3-text-green'>".$r['pay_type']."</i>"; }
				  elseif($r['pay_type']=="Partial")
				  { echo "<i class='w3-text-red'>".$r['pay_type']."</i>"; }	  
				  else
				  { echo "<i class='w3-text-deep-orange'>".$r['pay_type']."</i>"; }	  
			
			echo "</td>";
		
			echo "<td align='right'>".$r['payment_by']."</td>
				  <td align='right'>".date('m/d/Y',strtotime($r['payment_datetime']))."</td>";
		
			
			echo "<td align='center'>";
			
					if(date('Y-m-d',strtotime($r['payment_datetime'])) >= date('Y-m-d',strtotime('-1 day')))
					{	
						switch($r['deposited'])
						{
							case 0: echo "<a href='script_sales_monitoring.php?sortby=".$_REQUEST['sortby']."&total_posted=".$_REQUEST['total_posted']."&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&deposit=yes&id=".$r['id']."&branch1=".$_REQUEST['branch1']."' class='w3-text-red'>NO</a>"; break;
							case 1: echo "<a href='script_sales_monitoring.php?sortby=".$_REQUEST['sortby']."&total_posted=".$_REQUEST['total_posted']."&sdate=".$_REQUEST['sdate']."&edate=".$_REQUEST['edate']."&deposit=no&id=".$r['id']."&branch1=".$_REQUEST['branch1']."' class='w3-text-blue'>YES</a>"; break;
						}
					}	
					else
					{
						switch($r['deposited'])
						{
							case 0: echo "NO"; break;
							case 1: echo "YES"; break;
						}
					}
						
			echo "</td>";
			
			
			$hh=mysql_query("select created_datetime from sales_bookings where b_id='$b_id'") or die(mysql_error());
			$jj=mysql_fetch_assoc($hh);
			
			echo "<td align='right'>
					<a class='fa fa-money' title='Open Payments' target='_blank' href='script_sales_jo_payments.php?jo_no=".$r['jo_no']."'></a>&nbsp;&nbsp;";
			  echo "<a class='fa fa-truck' title='Open DR' target='_blank' href='script_sales_addquotation.php?b_date=".$jj['created_datetime']."&client=".$r1['name']."&jo_no=".$r['jo_no']."&b_id=".$r['b_id']."&client_id=".$r['client_id']."&print_booking_details=DR%2FJO+DETAILS'></a>";
		    echo "</td>";
			
		echo "</tr>";
	
	}while($r=mysql_fetch_assoc($q));
    
	echo "</table>";
	echo "</div>";
}







//CODE RANKING REPORT BASED ON DR - START-----
if(isset($_REQUEST['code_rank']))
{ ?>

<form class='w3-tiny'>
<input name='branch' type='hidden' value='<?php echo $_REQUEST['branch']; ?>'>
<input name='code_rank' type='hidden' value='1'>
<input name='code_set' type='hidden' value='<?php echo $_REQUEST['code_set']; ?>'>
<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
<select required name='branch'>
	<option value='<?php echo $_REQUEST['branch']; ?>'><?php echo $_REQUEST['branch']; ?></option>
	<option></option>
	<option>ALL</option>
	<?php
	 $sa="select department from users where department like '%SALES%' group by department";
	 $qa=mysql_query($sa);
	 $ra=mysql_fetch_assoc($qa);
	 do{
		echo "<option>".$ra['department']."</option>"; 
	 }while($ra=mysql_fetch_assoc($qa));
	?>
</select>
<input type='submit' value='FILTER'>
</form>

<?php 
$branch=$_REQUEST['branch'];	
$code_set=$_REQUEST['code_set'];

	if($_REQUEST['branch']=="ALL")
	{ 
		$s="select * from sales_bookings_details where dr_date>='$sdate' and dr_date<='$edate' and code_set='$code_set' order by b_id desc";
		$s1="select sum(dr_qty*b_amount) as code_total1 from sales_bookings_details where dr_date>='$sdate' and dr_date<='$edate' and code_set='$code_set'";
	}
	else
	{
	  $s="SELECT b.*
	  FROM sales_bookings_details AS b
	  JOIN sales_codes AS c ON b.code_set=c.code_set
	  JOIN users AS u ON b.created_by=u.username
	  WHERE u.department='$branch' AND b.dr_date>='$sdate' AND b.dr_date<='$edate' AND b.code_set='$code_set' 
	  ORDER BY b.b_id DESC";
	  
	  $s1="SELECT SUM(dr_qty*b_amount) AS code_total1
	  FROM sales_bookings_details AS b
	  JOIN sales_codes AS c ON b.code_set=c.code_set
	  JOIN users AS u ON b.created_by=u.username
	  WHERE u.department='$branch' AND b.dr_date>='$sdate' AND b.dr_date<='$edate' AND b.code_set='$code_set'";
	}	
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	$count=mysql_num_rows($q);
	
	$q1=mysql_query($s1) or die(mysql_error());
	$r1=mysql_fetch_assoc($q1);

	$s2="select * from sales_codes where code_set='$code_set'";
	$q2=mysql_query($s2) or die(mysql_error());
	$r2=mysql_fetch_assoc($q2);

echo "<div class='container'><br>";

echo "<table class='table w3-small'>
		<tr class='w3-light-gray' align='center'>
			<td colspan='7'><b class='w3-text-indigo'>".$code_set."</b> / ".$r2['code_name']." / ".$r2['code_desc']." <b class='w3-text-red'>($count)</b> entries. Total of <b class='w3-text-pink w3-xlarge'>P ".number_format($r1['code_total1'],2)."</b></td>
		</tr>
		<tr class='w3-light-gray'>
			<td>CLIENT</td><td>PRE JO</td><td>JO QTY</td><td>UNIT</td><td>SIZE</td><td>DETAILS</td><td>AMOUNT</td>
		</tr>";
        do{
			$b_id=$r['b_id'];
			$sx="select sales_clients.name as client, sales_clients.mobile as mobile, sales_clients.telno as telno from sales_clients inner join sales_bookings on sales_bookings.client_id=sales_clients.client_id where sales_bookings.b_id=$b_id";
			$qx=mysql_query($sx) or die(mysql_error());
			$rx=mysql_fetch_assoc($qx);
			
			echo "<tr class='w3-hover-pale-red'>
						<td><b class='w3-text-indigo'>".$rx['client']."</b></td>
						<td>".$r['b_id']."</td>
						<td>".$r['b_qty']."</td>
						<td>".$r['b_unit']."</td>
						<td>".$r['b_size']."</td>
						<td>".$r['b_desc']."</td>
						<td class='w3-text-red' align='right'>".number_format($r['b_qty']*$r['b_amount'],2)."</td>
				  </tr>";
				  
		  }while($r=mysql_fetch_assoc($q));

 echo "</table>";

echo "</div>";
}
//CODE RANKING REPORT BASED ON DR - END-----
?>

<div align='center'>
<a class='w3-xlarge' href="javascript:window.open('','_self').close();">X</a>
</div>