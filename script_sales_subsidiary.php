<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include('css.php');

$client_id=$_REQUEST['client_id'];
$s="select a.*, b.*, c.name
	from sales_jo_payments a
	left join sales_jo b on b.jo_no=a.jo_no
	left join sales_clients c on a.client_id=c.client_id
	where a.client_id=$client_id
	order by a.jo_no desc";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

echo "<table border='1' class='w3-table w3-small'>
			<tr class='w3-green'><td colspan='12'><div align='center'>SUBSIDIARY</div></td></tr>
			<tr align='center' class='w3-lime'>
				<td>CLIENT</td>
				<td>JO AMOUNT</td>
				<td>JO NO</td>
				<td>JO DATE</td>
				<td>BO NO</td>
				<td>BO DATE</td>
				<td>JO ACTUAL</td>
				<td>JO ACTUAL DATE</td>
				<td>PAYMENT</td>
				<td>RS</td>
				<td>OR</td>
				<td>OR DATE</td>
			</tr>";
do{
	echo "<tr class='w3-hover-pale-green'>
			<td>".$r['name']."</td>
			<td><div align='right'>".number_format($r['jo_amount'],2)."</div></td>
			<td>".$r['jo_no']."</td>
			<td>".$r['created_datetime']."</td>
			<td>".$r['bo_no']."</td>
			<td>".$r['bo_no_date']."</td>
			<td>".$r['jo_actual']."</td>
			<td>".$r['jo_actual_date']."</td>
			<td><div align='right'>".number_format($r['payment'],2)."</div></td>
			<td>".$r['rs_no']."</td>
			<td>".$r['or_no']."</td>
			<td>".$r['or_date']."</td>";
	echo "</tr>";
}while($r=mysql_fetch_assoc($q));
echo "</table><br/>";