<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
$client=$_REQUEST['s'];

if($client==""){}
else
{
	echo "<table class='w3-tiny'>
		  <tr align='center'>
			<tdcolspan='12'>CLIENT LIST</td>
		  </tr>
		  <tr class='bg-primary' align='center'>
			<td width='20'></td>
			<td>&nbsp;CLIENT ID&nbsp;</td>
			<td width='300' align='left'>NAME</td>
			<td width='50' align='left'>TIN</td>
			<td width='50'>MOBILE NO.</td>
			<td>EMAIL</td>
			<td width='100'>TEL NO.</td>
			<td width='100'>CONTACT PERSON</td>
			<td>ADDRESS</td>
			<td width='100'>CLIENT SINCE</td>
			<td width='100'>CLIENT TYPE</td>
			<td width='100'>TERMS</td>
			<td width='100'>CREDIT LIMIT</td>
		  </tr>";

	$username=$_SESSION['username'];
	$q99=mysql_query("select bch from users where username='$username'") or die(mysql_error());
	$r99=mysql_fetch_assoc($q99);	
	

	if($r99['bch']=="goc")
	{ $sql=mysql_query("select * from sales_clients where name like '%$client%'"); }
	else
	{ $sql=mysql_query("select * from sales_clients where name like '%$client%' and vip!=1"); }

	
	
	while ($row = mysql_fetch_array($sql))
	{ 
	  echo "<tr>
				<td>
					<a class='fa fa-pencil' href='script_sales_edit_clients.php?client_id=".$row['client_id']."' target='_blank'></a>
				</td>
				<td align='center'><i>".$row['client_id']."</i></td>
				<td>&nbsp;<a href='admin_sales.php?client_id=".$row['client_id']."&client=".$row['name']."&sales=1&newjobs=1&create_quotation=1'>".$row['name']."</a></td>
				<td align='center'><i>".$row['tin']."</i>&nbsp</td>
				<td align='center'><i>".$row['mobile']."</i>&nbsp;</td>
				<td align='center'><i>".$row['email']."</i>&nbsp;</td>
				<td align='center'><i>".$row['telno']."</i>&nbsp;</td>
				<td align='center'><i>".$row['contact_person']."</i>&nbsp;</td>
				<td><i>&nbsp;".$row['address']."</i> </td>
				<td align='center'><i>".date('m/d/Y',strtotime($row['add_date']))."</i></td>
				<td align='center'><i>";
				if($row['vip']==1){ echo "VIP"; } else {}
		  echo "</i></td>
				<td align='center'><i>";
				if($row['terms']!=0){ echo $row['terms']; } else {}
		  echo "</i></td>
				<td align='center'><i>";
				if($row['credit_limit']!=0){ echo $row['credit_limit']; } else {}
		  echo "</i></td>
			</tr>";
    }
echo "</table>";
}
?>
