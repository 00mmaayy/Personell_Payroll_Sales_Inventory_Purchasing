<?php 
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
$item=$_REQUEST['s'];


echo "<table border='1'>";


if($item!="")
{
	  echo "<tr class='w3-tiny'>
				<td><b>&nbsp;<i>NAME</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>PRE JO</i></b>&nbsp;</td>
				<td><b>&nbsp;<i>JO NO</i></b>&nbsp;</td>
				<td><b>&nbsp;<i>JO ACTUAL</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>JO ACTUAL DATE</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>DR NO</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>DR DATE</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>JO QTY</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>DR QTY</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>UNIT PRICE</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>JO AMOUNT</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>DR AMOUNT</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>PARTICULAR</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>CREATED BY</i>&nbsp;</b></td>
				<td><b>&nbsp;<i>CREATED DATE</i>&nbsp;</b></td>
			</tr>";
}	


if($item!="")
{	
	$sql=mysql_query("select a.b_id as b_id,
							 a.b_qty as b_qty,
							 a.dr_qty as dr_qty,
							 a.b_amount as b_amount,
							 a.code_set as code_set,
							 a.b_desc as b_desc,
							 a.created_by as created_by,
							 a.created_date as created_date,
							 a.dr_no as dr_no,
							 a.dr_date as dr_date,
							 b.jo_no as jo_no,
							 b.jo_amount as jo_amount,
							 b.jo_actual as jo_actual,
							 b.jo_actual_date as jo_actual_date,
							 c.name as name 
							 from sales_bookings_details as a 
							 inner join sales_jo as b on a.b_id=b.b_id
							 inner join sales_clients as c on b.client_id=c.client_id
							 where a.b_desc like '%$item%'
								  or c.name like '%$item%' 
							  or b.jo_actual like '%$item%'
							  or b.jo_no like '%$item%'");
	while ($row = mysql_fetch_array($sql))
	{ 
	  echo "<tr class='w3-hover-pale-red'>
				<td class='w3-tiny'><i>".$row['name']."</i></td>
				<td class='w3-tiny'>
					<i><a class='w3-text-blue' href='script_sales_tools.php?b_id=".$row['b_id']."&jo_no=".$row['jo_no']."' target='_blank'>".$row['b_id']."</a></i>
				</td>
				<td class='w3-tiny'>
					<i><a class='w3-text-green' href='script_sales_tools.php?b_id=".$row['b_id']."&jo_no=".$row['jo_no']."' target='_blank'>".$row['jo_no']."</a></i>
				</td>
				<td class='w3-tiny'><i>".$row['jo_actual']."</i></td>
				<td class='w3-tiny'><i>".$row['jo_actual_date']."</i></td>
				<td class='w3-tiny'><i>";
					if($row['dr_no']!=0){ echo $row['dr_no']; }
					echo "</i>
				</td>
				<td class='w3-tiny'><i>";
					if($row['dr_date']!="0000-00-00"){ echo $row['dr_date']; }
					echo "</i></td>
				<td class='w3-tiny' align='center'><i>".$row['b_qty']."</i></td>
				<td class='w3-tiny' align='center'><i>";
					if($row['dr_qty']!=0){ echo $row['dr_qty']; }
					echo "</i>
				</td>
				<td class='w3-tiny' align='right'><i>".number_format($row['b_amount'],2)."</i></td>
				<td class='w3-tiny' align='right'><i>".number_format($row['jo_amount'],2)."</i></td>
				<td class='w3-tiny' align='right'><i>".number_format($row['dr_qty']*$row['b_amount'],2)."</i></td>
				<td class='w3-tiny'><i>".$row['code_set']." - ".$row['b_desc']."</i></td>
				<td class='w3-tiny'><i>".$row['created_by']."</i></td>
				<td class='w3-tiny'><i>".date('m/d/Y h:i:s',strtotime($row['created_date']))."</i></td>
			</tr>";
    }
}


echo "</table>";

?>
