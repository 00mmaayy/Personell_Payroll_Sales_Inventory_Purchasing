<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

/*
0 = Cash
1 = VIP
2 = Government
3 = COD
4 = X-Deal
5 = Account
*/

switch($_REQUEST['sort'])
{ 
	case "all": 		 $s="select * from sales_clients order by name asc"; break;
	
	case "cash": 		 $s="select * from sales_clients where vip=0 order by name asc"; break;
	case "vip": 		 $s="select * from sales_clients where vip=1 order by name asc"; break;
	case "government": 	 $s="select * from sales_clients where vip=2 order by name asc"; break;
	case "COD": 		 $s="select * from sales_clients where vip=3 order by name asc"; break;
	case "X-Deal": 		 $s="select * from sales_clients where vip=4 order by name asc"; break;
	case "Account": 	 $s="select * from sales_clients where vip=5 order by name asc"; break;
	
	case "terms": 		 $s="select * from sales_clients where terms!=0 order by name asc"; break;
	case "credit_limit": $s="select * from sales_clients where credit_limit!=0 order by name asc"; break;
	case "no_jobs": 	 $s="select * from sales_clients where empty_jo=0 order by name asc"; break;
}	

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
echo "<br/><div class='container'>";

		echo "<form class='w3-tiny'>";
			echo "<select name='sort'>";
				echo "<option disabled selected>".$_REQUEST['sort']."</option>";
				echo "<option>all</option>";
				
				echo "<option>cash</option>";
				echo "<option>vip</option>";
				echo "<option>government</option>";
				echo "<option>COD</option>";
				echo "<option>X-Deal</option>";
				echo "<option>Account</option>";
				
				echo "<option>terms</option>";
				echo "<option>credit_limit</option>";
				echo "<option>no_jobs</option>";
			echo "</select>";
			echo "<input type='submit' value='SORT'>";
		echo "</form>";
?>
	
	<div align="right"><a href="script_sales_client_list_email_and_mobile.php?sort=all" target="_blank">SHOW CLIENTS WITH EMAILS ANG MOBILE NUMBERS</a></div>
	
<?php
echo "<table class='w3-tiny' border='1'>
		<tr class='w3-gray'>
			<td>#</td>
			<td>client_id</td>
			<td>name</td>
			<td>mobile</td>
			<td>telno</td>
			<td>contact_person</td>
			<td>email</td>
			<td>address</td>
			<td>add_by</td>
			<td>add_date</td>
			<td>vip</td>
			<td>terms</td>
			<td>credit_limit</td>
		</tr>";
$x=1;
do{
	echo "<tr>";
	echo "<td class='w3-text-orange'>".$x++."</td>";
	echo "<td>".$r['client_id']."</td>";
	echo "<td>".$r['name']."</td>";
	echo "<td>".$r['mobile']."</td>";
	echo "<td>".$r['telno']."</td>";
	echo "<td>".$r['contact_person']."</td>";
	echo "<td>".$r['email']."</td>";
	echo "<td>".$r['address']."</td>";
	echo "<td>".$r['add_by']."</td>";
	echo "<td>".$r['add_date']."</td>";
	echo "<td>".$r['vip']."</td>";
	echo "<td align='center'>".$r['terms']."</td>";
	echo "<td align='right'>".number_format($r['credit_limit'],2)."</td></tr>";
}while($r=mysql_fetch_assoc($q));
echo "</table>";
?>