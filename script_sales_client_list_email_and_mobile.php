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
	case "all": 		 $s="select * from sales_clients where 
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
						    order by name asc"; break;
	
	case "cash": 		 $s="select * from sales_clients where vip=0 and 
									    email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
							order by name asc"; break;
							
	case "vip": 		 $s="select * from sales_clients where vip=1 and 
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
							order by name asc"; break;
										
	case "government": 	 $s="select * from sales_clients where vip=2 and
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'	
							order by name asc"; break;
										
	case "COD": 		 $s="select * from sales_clients where vip=3 and
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
							order by name asc"; break;
										
	case "X-Deal": 		 $s="select * from sales_clients where vip=4 and
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
							order by name asc"; break;
							
	case "Account": 	 $s="select * from sales_clients where vip=5 and
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
							order by name asc"; break;
							
	case "terms": 		 $s="select * from sales_clients where terms!=0 and
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
							order by name asc"; break;
							
	case "credit_limit": $s="select * from sales_clients where credit_limit!=0 and
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
							order by name asc"; break;
							
	case "no_jobs": 	 $s="select * from sales_clients where empty_jo=0 and
										email != 'N/A' and 
										email != '' and 
										email != '00' and 
										email != '0' and
										email != 'na' and
										email != 'NA' and
										email != '.'
							order by name asc"; break;
}	

$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
echo "<br/><div class='container'>";

		echo "<form>";
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

echo "<table border='1'>
		<tr class='w3-gray'>
			<td>#</td>
			<td>client_id</td>
			<td>name</td>
			<td>email</td>
			<td>mobile</td>
		</tr>";
$x=1;
do{
	echo "<tr>";
	echo "<td class='w3-text-orange'>".$x++."</td>";
	echo "<td>".$r['client_id']."</td>";
	echo "<td>".$r['name']."</td>";
	echo "<td>".$r['email']."</td>";
	echo "<td>".$r['mobile']."</td>";
	echo "</tr>";
}while($r=mysql_fetch_assoc($q));
echo "</table>";
?>