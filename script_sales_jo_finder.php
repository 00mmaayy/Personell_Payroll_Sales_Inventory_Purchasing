<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
date_default_timezone_set("Asia/Manila");
include("css.php");

$current_user=$_SESSION['username'];
$spas="select * from user_access where username='$current_user'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);

?>
<div class='w3-green w3-large'>&nbsp;ALC SYSTEM FINDER <i class='w3-small'>(Actual Form Numbers)</i>
</div>
	<br>
<div class='container'>
<table align='center'>
	<tr>
		<td width='300'>
			<form>
				<input class='w3-tiny' name='find_jo' type='number'><br/>
				<input class='w3-tiny' type='submit' value='FIND JO NO'>
			</form>
		</td>
	
		<td width='300'>
			<form>
				<input class='w3-tiny' name='find_bo' type='number'><br/>
				<input class='w3-tiny' type='submit' value='FIND BOOKING NO'>
			</form>
		</td>
		
		<td width='300'>
			<form>
				<input class='w3-tiny' name='find_jo_actual' type='number'><br/>
				<input class='w3-tiny' type='submit' value='FIND ACTUAL JO'>
			</form>
		</td>
		<td width='300'>
			<form>
				<input class='w3-tiny' name='find_dr' type='number'><br/>
				<input class='w3-tiny' type='submit' value='FIND ACTUAL DR'>
			</form>
		</td>
		<td>
			<form>
				<input class='w3-tiny' name='find_or' type='number'><br/>
				<input class='w3-tiny' type='submit' value='FIND O.R.'>
			</form>
		</td>
		<td width='300' align='center' valign='top'>
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
				<i><input class='w3-tiny' type="text" id="search" name="search" placeholder="Search Item Details" onkeyup="showHint('x')"/>&nbsp;&nbsp;<i/><div id="view_result"></div>
		</td>
	</tr>
</table>
</br>

<?php

if(isset($_REQUEST['find_jo']))
{
	$username=$_SESSION['username'];
	$s99="select bch from users where username='$username'";
	$q99=mysql_query($s99) or die(mysql_error());
	$r99=mysql_fetch_assoc($q99);
	
	$find=$_REQUEST['find_jo'];
	
	if($r99['bch']=="goc")
	{ $sql=mysql_query("select a.*, b.name ,b.client_id, c.b_date
                        from sales_jo a 
						inner join sales_clients b on a.client_id=b.client_id 
						inner join sales_bookings_details c on a.b_id=c.b_id 
						where jo_no=$find order by a.delivered asc"); }
	else
	{ $sql=mysql_query("select a.*, b.name ,b.client_id, c.b_date
                        from sales_jo a 
						inner join sales_clients b on a.client_id=b.client_id 
						inner join sales_bookings_details c on a.b_id=c.b_id 
						where jo_no=$find and b.vip!=1 order by a.delivered asc"); }
	
	echo "<i>You are looking for <span class='w3-text-blue'>JO NO</span> like --> <b class='w3-text-red'>*".$_REQUEST['find_jo']."</i>";
	echo "<table class='w3-tiny table'>
			<tr class='w3-green'>
				<td>CLIENT ID</td>
				<td>CLIENT NAME</td>
				<td>ACTION</td>
				<td>BOOKING ID / SYSTEM JO</td>
				<td>JO NO</td>
				<td>JO DATE</td>
				<td>JO STATUS</td>
			</tr>";
	while($row=mysql_fetch_array($sql))
	{ 
		echo "<tr class='w3-hover-pale-red'>
				<td class='w3-text-amber'>".$row['client_id']."</td>
				<td>".$row['name']."</td>
				<td>";
					echo "<a title='Open Client Profile' target='_blank' class='fa fa-user w3-large' href='admin_sales.php?client_id=".$row['client_id']."&client=".$row['name']."&sales=1&newjobs=1&create_quotation=1'></a>&nbsp;&nbsp;";
					echo "<a title='Open Payments' target='_blank' class='fa fa-money w3-large' href='script_sales_jo_payments.php?jo_no=".$row['jo_no']."'></a>&nbsp;&nbsp;";
					echo "<a title='Open DR' target='_blank' class='fa fa-truck w3-large' href='script_sales_addquotation.php?b_date=".$row['b_date']."&client=".$row['name']."&jo_no=".$row['jo_no']."&b_id=".$row['b_id']."&client_id=".$row['client_id']."&print_booking_details=DR%2FJO+DETAILS'></a>";
		  echo "</td>
				<td>(".$row['created_by']." )
					<span class='w3-text-gray'>".$row['b_id']."</span> / ".$row['jo_no'];
					
					if($access['d26']==1 or $access['d27']==1)
					{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='fa fa-pencil' target='_blank' href='script_sales_tools.php?jo_no=".$row['jo_no']."'></a>";
					}
					
		  echo "</td>
				<td class='w3-pale-red'>".$row['jo_no']."</td>
				<td>".date('m/d/Y',strtotime($row['created_datetime']))."</td>
				<td>";
				if($row['delivered']==1){ echo "<i class='w3-text-blue'>Completed</i>"; } else { echo "<i class='w3-text-red'>Inprogress</i>"; }
		  echo "</td>
			 </tr>"; 
	}
	
	echo "</table>";
}



if(isset($_REQUEST['find_bo']))
{
	$username=$_SESSION['username'];
	$s99="select bch from users where username='$username'";
	$q99=mysql_query($s99) or die(mysql_error());
	$r99=mysql_fetch_assoc($q99);
	
	$find=$_REQUEST['find_bo'];
	
	if($r99['bch']=="goc")
	{ $sql=mysql_query("select a.*, b.name ,b.client_id, c.b_date
                        from sales_jo a 
						inner join sales_clients b on a.client_id=b.client_id 
						inner join sales_bookings_details c on a.b_id=c.b_id 
						where bo_no=$find order by a.delivered asc"); }
	else
	{ $sql=mysql_query("select a.*, b.name ,b.client_id, c.b_date
                        from sales_jo a 
						inner join sales_clients b on a.client_id=b.client_id 
						inner join sales_bookings_details c on a.b_id=c.b_id 
						where bo_no=$find and b.vip!=1 order by a.delivered asc"); }
	
	echo "<i>You are looking for <span class='w3-text-blue'>BOOKING NO</span> like --> <b class='w3-text-red'>*".$_REQUEST['find_bo']."</i>";
	echo "<table class='w3-tiny table'>
			<tr class='w3-green'>
				<td>CLIENT ID</td>
				<td>CLIENT NAME</td>
				<td>ACTION</td>
				<td>BOOKING ID / SYSTEM JO</td>
				<td>BOOKING NO</td>
				<td>BOOKING DATE</td>
				<td>JO STATUS</td>
			</tr>";
	while($row=mysql_fetch_array($sql))
	{ 
		echo "<tr class='w3-hover-pale-red'>
				<td class='w3-text-amber'>".$row['client_id']."</td>
				<td>".$row['name']."</td>
				<td>";
					echo "<a title='Open Client Profile' target='_blank' class='fa fa-user w3-large' href='admin_sales.php?client_id=".$row['client_id']."&client=".$row['name']."&sales=1&newjobs=1&create_quotation=1'></a>&nbsp;&nbsp;";
					echo "<a title='Open Payments' target='_blank' class='fa fa-money w3-large' href='script_sales_jo_payments.php?jo_no=".$row['jo_no']."'></a>&nbsp;&nbsp;";
					echo "<a title='Open DR' target='_blank' class='fa fa-truck w3-large' href='script_sales_addquotation.php?b_date=".$row['b_date']."&client=".$row['name']."&jo_no=".$row['jo_no']."&b_id=".$row['b_id']."&client_id=".$row['client_id']."&print_booking_details=DR%2FJO+DETAILS'></a>";
		  echo "</td>
				<td>(".$row['created_by']." )
					<span class='w3-text-gray'>".$row['b_id']."</span> / ".$row['jo_no'];
					
					if($access['d26']==1 or $access['d27']==1)
					{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='fa fa-pencil' target='_blank' href='script_sales_tools.php?jo_no=".$row['jo_no']."'></a>";
					}
					
		  echo "</td>
				<td class='w3-pale-red'>".$row['bo_no']."</td>
				<td>".date('m/d/Y',strtotime($row['bo_no_date']))."</td>
				<td>";
				if($row['delivered']==1){ echo "<i class='w3-text-blue'>Completed</i>"; } else { echo "<i class='w3-text-red'>Inprogress</i>"; }
		  echo "</td>
			 </tr>"; 
	}
	
	echo "</table>";
}





if(isset($_REQUEST['find_jo_actual']))
{
	$username=$_SESSION['username'];
	$s99="select bch from users where username='$username'";
	$q99=mysql_query($s99) or die(mysql_error());
	$r99=mysql_fetch_assoc($q99);
	
	$find=$_REQUEST['find_jo_actual'];
	
	if($r99['bch']=="goc")
	{ $sql=mysql_query("select a.*, b.name ,b.client_id, c.b_date
                        from sales_jo a 
						inner join sales_clients b on a.client_id=b.client_id 
						inner join sales_bookings_details c on a.b_id=c.b_id 
						where jo_actual like '%$find%' order by a.delivered asc"); }
	else
	{ $sql=mysql_query("select a.*, b.name ,b.client_id, c.b_date
                        from sales_jo a 
						inner join sales_clients b on a.client_id=b.client_id 
						inner join sales_bookings_details c on a.b_id=c.b_id 
						where jo_actual like '%$find%' and b.vip!=1 order by a.delivered asc"); }
	
	echo "<i>You are looking for <span class='w3-text-blue'>ACTUAL JO NO</span> like --> <b class='w3-text-red'>*".$_REQUEST['find_jo_actual']."</i>";
	echo "<table class='w3-tiny table'>
			<tr class='w3-green'>
				<td>CLIENT ID</td>
				<td>CLIENT NAME</td>
				<td>ACTION</td>
				<td>PRE JO / SYSTEM JO</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>JO STATUS</td>
			</tr>";
	while($row=mysql_fetch_array($sql))
	{ 
		echo "<tr class='w3-hover-pale-red'>
				<td class='w3-text-amber'>".$row['client_id']."</td>
				<td>".$row['name']."</td>
				<td>";
					echo "<a title='Open Client Profile' target='_blank' class='fa fa-user w3-large' href='admin_sales.php?client_id=".$row['client_id']."&client=".$row['name']."&sales=1&newjobs=1&create_quotation=1'></a>&nbsp;&nbsp;";
					echo "<a title='Open Payments' target='_blank' class='fa fa-money w3-large' href='script_sales_jo_payments.php?jo_no=".$row['jo_no']."'></a>&nbsp;&nbsp;";
					echo "<a title='Open DR' target='_blank' class='fa fa-truck w3-large' href='script_sales_addquotation.php?b_date=".$row['b_date']."&client=".$row['name']."&jo_no=".$row['jo_no']."&b_id=".$row['b_id']."&client_id=".$row['client_id']."&print_booking_details=DR%2FJO+DETAILS'></a>";
		  echo "</td>
				<td>(".$row['created_by']." )
					<span class='w3-text-gray'>".$row['b_id']."</span> / ".$row['jo_no'];
					
					if($access['d26']==1 or $access['d27']==1)
					{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='fa fa-pencil' target='_blank' href='script_sales_tools.php?jo_no=".$row['jo_no']."'></a>";
					}
					
		  echo "</td>
				<td class='w3-pale-red'>".$row['jo_actual']."</td>
				<td>".date('m/d/Y',strtotime($row['jo_actual_date']))."</td>
				<td>";
				if($row['delivered']==1){ echo "<i class='w3-text-blue'>Completed</i>"; } else { echo "<i class='w3-text-red'>Inprogress</i>"; }
		  echo "</td>
			 </tr>"; 
	}
	
	echo "</table>";
}




if(isset($_REQUEST['find_dr']))
{
	$username=$_SESSION['username'];
	$s99="select bch from users where username='$username'";
	$q99=mysql_query($s99) or die(mysql_error());
	$r99=mysql_fetch_assoc($q99);
	
	$find=$_REQUEST['find_dr'];
	
	if($r99['bch']=="goc")
	{ 
		$sx="select a.b_id, a.b_date, a.dr_no, a.dr_date, b.jo_no, b.jo_actual, b.jo_actual_date, c.client_id, c.name, b.delivered
			 from sales_bookings_details a
			 inner join sales_jo b on a.b_id=b.b_id
			 inner join sales_clients c on b.client_id=c.client_id
			 where a.dr_no like '%$find%' order by b.delivered asc";
		$sql=mysql_query($sx); 
	}
	else
	{ 
		$sx="select a.b_id, a.b_date, a.dr_no, a.dr_date, b.jo_no, b.jo_actual, b.jo_actual_date, c.client_id, c.name, b.delivered
			 from sales_bookings_details a
			 inner join sales_jo b on a.b_id=b.b_id
			 inner join sales_clients c on b.client_id=c.client_id
			 where a.dr_no like '%$find%' and c.vip!=1 order by b.delivered asc";
		$sql=mysql_query($sx); 
	}
	echo "<i>You are looking for <span class='w3-text-blue'>ACTUAL DR NO</span> like --> <b class='w3-text-red'>*".$_REQUEST['find_dr']."</i>";
	echo "<table class='w3-tiny table'>
			<tr class='w3-green'>
				<td>CLIENT ID</td>
				<td>CLIENT NAME</td>
				<td>ACTION</td>
				<td>PRE JO / SYSTEM JO</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>DR NO</td>
				<td>DR DATE</td>
				<td>JO STATUS</td>
			</tr>";

	while($row=mysql_fetch_array($sql))
	{ 
	  echo "<tr class='w3-hover-pale-red'>
				<td class='w3-text-amber'>".$row['client_id']."</td>
				<td>".$row['name']."</td>
				<td>";
					echo "<a title='Open Client Profile' target='_blank' class='fa fa-user w3-large' href='admin_sales.php?client_id=".$row['client_id']."&client=".$row['name']."&sales=1&newjobs=1&create_quotation=1'></a>&nbsp;&nbsp;";
					echo "<a title='Open Payments' target='_blank' class='fa fa-money w3-large' href='script_sales_jo_payments.php?jo_no=".$row['jo_no']."'></a>&nbsp;&nbsp;";
					echo "<a title='Open DR' target='_blank' class='fa fa-truck w3-large' href='script_sales_addquotation.php?b_date=".$row['b_date']."&client=".$row['name']."&jo_no=".$row['jo_no']."&b_id=".$row['b_id']."&client_id=".$row['client_id']."&print_booking_details=DR%2FJO+DETAILS'></a>";
		  echo "</td>
				<td>
					<span class='w3-text-gray'>".$row['b_id']."</span> / ".$row['jo_no'];
					
					if($access['d26']==1 or $access['d27']==1)
					{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='fa fa-pencil' target='_blank' href='script_sales_tools.php?jo_no=".$row['jo_no']."'></a>";
					}
					
		  echo "</td>
				<td>".$row['jo_actual']."</td>
				<td>".date('m/d/Y',strtotime($row['jo_actual_date']))."</td>
				<td class='w3-pale-red'>".$row['dr_no']."</td>
				<td>".date('m/d/Y',strtotime($row['dr_date']))."</td>
				<td>";
				if($row['delivered']==1){ echo "<i class='w3-text-blue'>Completed</i>"; } else { echo "<i class='w3-text-red'>Inprogress</i>"; }
		  echo "</td>
			</tr>"; 
	}
	
	echo "</table>";

	$s_a="select b.jo_actual, b.b_id, b_qty, dr_qty, b_amount, (dr_qty*b_amount) as total, b_desc, b_size, b_unit, code_set, dr_no, dr_date 
	             from sales_bookings_details a 
				 left join sales_jo b on b.b_id=a.b_id
				 where dr_no='".$_REQUEST['find_dr']."'
				 order by b.delivered asc";
	$q_a=mysql_query($s_a) or die(mysql_error());
	$r_a=mysql_fetch_assoc($q_a);
	
	echo "<br/><table class='w3-tiny table' border='1'>
			<tr class='w3-light-gray' align='center'>
				<td>JO ACTUAL</td>
				<td>ORDER</td>
				<td>DR QTY</td>
				<td>AMOUNT</td>
				<td>CODE</td>
				<td>UNIT</td>
				<td>SIZE</td>
				<td>DESCRIPTION</td>
				<td>DR NO</td>
				<td>DR Date</td>
			</tr>";
	do{
		echo "<tr>";
			echo "<td align='center'>".$r_a['jo_actual']."</td>";
			echo "<td align='center'>".$r_a['b_qty']."</td>";
			echo "<td align='center'>".$r_a['dr_qty']."</td>";
			echo "<td align='right'>".number_format($r_a['total'],2)."</td>";
			echo "<td align='center'>".$r_a['code_set']."</td>";
			echo "<td align='center'>".$r_a['b_unit']."</td>";
			echo "<td align='center'>".$r_a['b_size']."</td>";
			echo "<td align='center'>".$r_a['b_desc']."</td>";
			echo "<td align='center'>".$r_a['dr_no']."</td>";
			echo "<td align='center'>".date('m/d/Y',strtotime($r_a['dr_date']))."</td>";
		echo "</tr>";
	}while($r_a=mysql_fetch_assoc($q_a));
	
	
	$s_a1="select sum(dr_qty*b_amount) as g_total from sales_bookings_details a 
				 where dr_no='".$_REQUEST['find_dr']."'";
	$q_a1=mysql_query($s_a1) or die(mysql_error());
	$r_a1=mysql_fetch_assoc($q_a1);
	
	echo "<tr>
			<td align='right' colspan='4'> DR SEARCH TOTAL: &nbsp;&nbsp;&nbsp;".number_format($r_a1['g_total'],2)."</td>
		  </tr>";
	
	echo "</table>";
}


if(isset($_REQUEST['find_or']))
{
	$username=$_SESSION['username'];
	$s99="select bch from users where username='$username'";
	$q99=mysql_query($s99) or die(mysql_error());
	$r99=mysql_fetch_assoc($q99);
	
	$find=$_REQUEST['find_or'];
	
	if($r99['bch']=="goc")
	{ 
		$sx="SELECT a.payment, a.or_no, a.or_date, a.jo_no, b.b_id, b.jo_actual, b.jo_actual_date, b.delivered, c.name
		     FROM sales_jo_payments a
			 INNER JOIN sales_jo b ON a.jo_no=b.jo_no
			 INNER JOIN sales_clients c ON b.client_id=c.client_id
			 WHERE or_no LIKE '%$find%'
			 ORDER BY b.delivered ASC";
		$sql=mysql_query($sx); 
	}
	else
	{ 
		$sx="SELECT a.payment, a.or_no, a.or_date, a.jo_no, b.b_id, b.jo_actual, b.jo_actual_date, b.delivered, c.name
		     FROM sales_jo_payments a
			 INNER JOIN sales_jo b ON a.jo_no=b.jo_no
			 INNER JOIN sales_clients c ON b.client_id=c.client_id
			 WHERE or_no LIKE '%$find%' AND c.vip!=1
			 ORDER BY b.delivered ASC";
		$sql=mysql_query($sx); 
	}
	echo "<i>You are looking for <span class='w3-text-blue'>OR NO</span> like --> <b class='w3-text-red'>*".$_REQUEST['find_or']."</i>";
	echo "<table class='w3-tiny table'>
			<tr class='w3-green'>
				<td>CLIENT</td>
				<td>BOOKING ID / SYSTEM JO</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>ACTION</td>
				<td>OR NO</td>
				<td>OR DATE</td>
				<td>OR AMOUNT</td>
				<td>STATUS</td>
			</tr>";

	while($row=mysql_fetch_array($sql))
	{ 
	  echo "<tr class='w3-hover-pale-red'>
				<td>".$row['name']."</td>
				<td>
					<span class='w3-text-gray'>".$row['b_id']."</span> / ".$row['jo_no'];
					
					if($access['d26']==1 or $access['d27']==1)
					{
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='fa fa-pencil' target='_blank' href='script_sales_tools.php?jo_no=".$row['jo_no']."'></a>";
					}
					
		  echo "</td>
				<td>".$row['jo_actual']."</td>
				<td>".date('m/d/Y',strtotime($row['jo_actual_date']))."</td>
				<td>";
			
					echo "<a title='Open Payments' target='_blank' class='fa fa-money w3-large' href='script_sales_jo_payments.php?jo_no=".$row['jo_no']."'></a>&nbsp;&nbsp;";
			
		  echo "<td class='w3-pale-red'>".$row['or_no']."</td>
				<td>";
				
				if($row['or_date']=='0000-00-00')
				{ echo $row['or_date']; }
			    else
				{ echo date('m/d/Y',strtotime($row['or_date'])); }
		  
		  echo "</td>
				<td class='w3-text-red' align='right'><b>".number_format($row['payment'],2)."</b></td>
				<td align='right'>";
				if($row['delivered']==1){ echo "<i class='w3-text-blue'>Completed</i>"; } else { echo "<i class='w3-text-red'>Inprogress</i>"; }
		  echo "</td>
			</tr>"; 
	}
	
	echo "</table>";
}

?>
<br/>
</div>