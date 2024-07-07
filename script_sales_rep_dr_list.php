<?php
if(isset($_REQUEST['search']) and $_REQUEST['search']=="dr_list")
{
	if(isset($_REQUEST['sort']))
	{
		if($_REQUEST['sort']=="dr_no")     { $sort="a.dr_no asc"; }
		if($_REQUEST['sort']=="jo_no")     { $sort="b.jo_no asc"; }
		if($_REQUEST['sort']=="client")    { $sort="d.name asc"; }
		if($_REQUEST['sort']=="particular"){ $sort="a.code_set asc"; }
		if($_REQUEST['sort']=="dr_date")   { $sort="a.dr_date asc"; }
	}
	else
	{ 
		$sort="a.dr_no asc";
	}

	
	if($rp['bch']=="goc")
	{ 
		if($_REQUEST['branch']!="ALL")
		{
			$branch1=$_REQUEST['branch']; 
			$s="select 		   a.dr_no as dr_no,
						   a.dr_date as dr_date,
						   a.dr_posted_date as dr_posted_date,
						   a.dr_qty as dr_qty,
						   a.b_amount as b_amount,
						   a.code_set as code_set,
						   a.b_unit as b_unit,
						   a.b_size as b_size,
						   a.b_desc as b_desc,
						   a.bch as department,
						   
						   b.jo_no as jo_no,
						   b.jo_actual as jo_actual,
						   b.jo_actual_date as jo_actual_date,
						   b.client_id as client_id,
						   b.jo_payment_amount as jo_payment_amount,
						   
						   d.name as name
					
		from sales_bookings_details as a
		left join sales_jo as b on a.b_id=b.b_id
		left join sales_clients as d on b.client_id=d.client_id
		where a.dr_date>='$sdate' and a.dr_date<='$edate' 
		order by $sort";
		
			//echo $s."<br/>not all<br/><br/><br/>";
		}
		else
		{
		
		$s="select 		   a.dr_no as dr_no,
						   a.dr_date as dr_date,
						   a.dr_posted_date as dr_posted_date,
						   a.dr_qty as dr_qty,
						   a.b_amount as b_amount,
						   a.code_set as code_set,
						   a.b_unit as b_unit,
						   a.b_size as b_size,
						   a.b_desc as b_desc,
						   a.bch as department,
						   
						   b.jo_no as jo_no,
						   b.jo_actual as jo_actual,
						   b.jo_actual_date as jo_actual_date,
						   b.client_id as client_id,
						   b.jo_payment_amount as jo_payment_amount,
						   
						   d.name as name
					
		from sales_bookings_details as a
		left join sales_jo as b on a.b_id=b.b_id
		left join sales_clients as d on b.client_id=d.client_id
		where a.dr_date>='$sdate' and a.dr_date<='$edate' 
		order by $sort";
		
		//echo $s."<br/>All<br/><br/><br/>";
		
		}
	}
	
	
	else
	{ 
		$branch1=$rp['department'];
		$s="select 		   a.dr_no as dr_no,
						   a.dr_date as dr_date,
						   a.dr_posted_date as dr_posted_date,
						   a.dr_qty as dr_qty,
						   a.b_amount as b_amount,
						   a.code_set as code_set,
						   a.b_unit as b_unit,
						   a.b_size as b_size,
						   a.b_desc as b_desc,
						   a.bch as department,
						   
						   b.jo_no as jo_no,
						   b.jo_actual as jo_actual,
						   b.jo_actual_date as jo_actual_date,
						   b.client_id as client_id,
						   b.jo_payment_amount as jo_payment_amount,
						   
						   d.name as name
					
		from sales_bookings_details as a
		left join sales_jo as b on a.b_id=b.b_id
		left join sales_clients as d on b.client_id=d.client_id
		where a.dr_date>='$sdate' and a.dr_date<='$edate' 
		order by $sort";
		
		//echo $s."<br/>dept only<br/><br/><br/>";
	} 
	
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	
	
	
	
	//for total amount only
	if($rp['bch']=="goc")
	{
		if($_REQUEST['branch']!="ALL")
		{
			//Backup code
		    //$branch1=$_REQUEST['branch']; 
		    // $s1="select  sum(a.dr_qty*a.b_amount) as dr_amount,
			//			count(a.b_count) as total_records
			//	from sales_bookings_details as a
			//	inner join sales_jo as b on a.b_id=b.b_id
			//	inner join users as c on a.created_by=c.username
			//	where a.dr_date>='$sdate' and a.dr_date<='$edate' and c.department='$branch1'";	
				
		   $branch1=$_REQUEST['branch']; 
		   $s1="select  sum(a.dr_qty*a.b_amount) as dr_amount,
						count(a.b_count) as total_records
				from sales_bookings_details as a
				inner join users as c on a.created_by=c.username
				where a.dr_date>='$sdate' and a.dr_date<='$edate' and c.department='$branch1'";		
		}
		else
		{
			
			//Backup code
			//$s1="select  sum(a.dr_qty*a.b_amount) as dr_amount, 
			//			count(a.b_count) as total_records
			//	from sales_bookings_details as a
			//	inner join sales_jo as b 
			//			on a.b_id=b.b_id
			//	inner join users as c 
			//			on a.created_by=c.username
			//	where a.dr_date>='$sdate' and a.dr_date<='$edate'";	
			
			
		   $s1="select  sum(a.dr_qty*a.b_amount) as dr_amount, 
						count(a.b_count) as total_records
				from sales_bookings_details as a
				where a.dr_date>='$sdate' and a.dr_date<='$edate'";	
		}	
	}
	else
	{
		
	//Backup code	
	//$branch1=$rp['department'];
	//$s1="select sum(a.dr_qty*a.b_amount) as dr_amount,
   	//     count(a.b_count) as total_records
	//	 from sales_bookings_details as a
	//	 inner join sales_jo as b on a.b_id=b.b_id
	//	 inner join users as c on a.created_by=c.username
	//	 where a.dr_date>='$sdate' and a.dr_date<='$edate' and c.department='$branch1'";
	//echo $s1."<br/>dept only<br/><br/><br/>";
	
	$branch1=$rp['department'];
	$s1="select sum(a.dr_qty*a.b_amount) as dr_amount,
   	     count(a.b_count) as total_records
		 from sales_bookings_details as a
		 inner join users as c on a.created_by=c.username
		 where a.dr_date>='$sdate' and a.dr_date<='$edate' and c.department='$branch1'";
	}
	
	$q1=mysql_query($s1) or die(mysql_error());
	$r1=mysql_fetch_assoc($q1);
	
	
	
	
	
	
	echo "<table align='center'>
			<tr>
				<td>";
	?>

	<form>
		<input name='sdate' type='hidden' value='<?php echo $_REQUEST['sdate']; ?>'>
		<input name='edate' type='hidden' value='<?php echo $_REQUEST['edate']; ?>'>
		<input name='search' type='hidden' value='dr_list'>
		<select class='w3-tiny' required name='sort'>
			<option><?php if(isset($_REQUEST['sort'])){ echo $_REQUEST['sort']; }else{} ?></option>
			<option value='dr_no'>DR NO</option>
			<option value='jo_no'>JO NO</option>
			<option value='client'>CLIENT</option>
			<option value='particular'>PARTICULAR</option>
			<option value='dr_date'>DR DATE</option>
		</select>
		
		<?php if($rp['bch']=="goc")
				      { ?>	
					<select required class='w3-tiny' name='branch'>
						<option><?php if($_REQUEST['branch']!=""){ echo $_REQUEST['branch'];} ?></option>
						<option>ALL</option>
				   <?php $sa="select users.department as dept,count(department) from users inner join sales_jo on sales_jo.created_by=users.username group by users.department";
						 $qa=mysql_query($sa);
						 $ra=mysql_fetch_assoc($qa);
						do{
						 echo "<option>".$ra['dept']."</option>"; 
						}while($ra=mysql_fetch_assoc($qa)); ?>
					</select>
				<?php } ?>
		
		<input class='w3-tiny' type='submit' value='SORT LIST'>
	</form>
	
<?php

			echo "<span class='w3-red w3-text-white'>&nbsp;DR LIST REPORT. <i>(Based on Actual DR Date)</i>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL AMOUNT: <b><i class='w3-text-red'>".number_format($r1['dr_amount'],2)."</i> total_records: ".$r1['total_records']."</b>";

	echo "</td></tr></table>";
	
	echo "<table class='table'>
			<tr class='w3-tiny w3-green'>
				<td>count</td>
				<td>BRANCH</td>
				<td>CLIENT ID</td>
				<td>CLIENT NAME</td>
				<td>PARTICULAR</td>
				<td>JO NO</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>PAYMENT</td>
				<td>DR NO</td>
				<td>DR DATE</td>
				<td>DR POSTING DATE</td>
				<td align='right'>DR AMOUNT</td>
			</tr>";
		$x=1;	
	do{
	echo "<tr class='w3-tiny w3-hover-pale-red'>
			<td class='w3-text-amber'>".$x++."</td>
			<td>".$r['department']."</td>
			<td>".$r['client_id']."</td>
			<td>".$r['name']."</td>
			<td>".$r['code_set']." - ".$r['b_desc']."</td>
			<td>".$r['jo_no']."</td>
			<td>".$r['jo_actual']."</td>
			<td>".date('m/d/Y',strtotime($r['jo_actual_date']))."</td>
			<td>".number_format($r['jo_payment_amount'],2)."</td>
			<td>".$r['dr_no']."</td>
			<td class='w3-pale-red'>".date('m/d/Y',strtotime($r['dr_date']))."</td>
			<td>".date('m/d/Y',strtotime($r['dr_posted_date']))."</td>
			<td align='right'><b class='w3-text-red'>".number_format($r['dr_qty']*$r['b_amount'],2)."</b></td>
		  </tr>";
	}while($r=mysql_fetch_assoc($q));
	echo "</table>";
}
?>