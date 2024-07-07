<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");


$e_no=$_REQUEST['e_no'];
$e_lname=$_REQUEST['e_lname'];
$e_fname=$_REQUEST['e_fname'];


if(isset($_REQUEST['print_asset_all']))
{
	if($_REQUEST['e_no']!='Damaged')
	{
		$s="select a.*, b.e_fname, b.e_mname, b.e_lname, b.e_department from inv_mr as a join employee as b on b.e_no=a.e_no where a.e_no='$e_no'"; 
	}
	else
	{
		$s="select * from inv_mr where e_no='$e_no'"; 
	}
}


if(isset($_REQUEST['print_asset_specific']))
{
	if($_REQUEST['e_no']!='Damaged')
	{
		$s="select a.*, b.e_fname, b.e_mname, b.e_lname, b.e_department from inv_mr as a join employee as b on b.e_no=a.e_no where a.e_no='$e_no' and a.print_specific=1"; 
	}
	else
	{
		$s="select * from inv_mr where e_no='$e_no' and print_specific=1";
	}
}


$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
$name=$r['e_fname']." ".$r['e_mname']." ".$r['e_lname'];


echo "<table>";
echo "<tr><td><b class='w3-large'>MEMORANDUM RECEIPT</b><br/><br/><br/></td></tr>";

echo "<tr align='left'>";
	if($_REQUEST['e_no']!='Damaged')
	{
		echo "<td>Employee Name: <b>".$r['e_fname']." ".$r['e_mname']." ".$r['e_lname']."</b></td>";
		echo "<td>Department/Branch: <b>".$r['e_department']."</b><br/><br/></td>";
	}
	else
	{
		echo "<td><b class='w3-text-red'>".$_REQUEST['e_no']."</b></td>";
		echo "<td></td>";
	}
echo "</tr>";
echo "<tr>
		  <td colspan='2'>";
		
		echo "<table width='100%' border='1'>
				<tr class='w3-small'>
					<td>FIXED ASSET CODE</td>
					<td>DESCRIPTION</td>
					<td>QTY ISSUED</td>
					<td>UNIT PRICE</td>
					<td>AMOUNT</td>
					<td>DATE RECEIVED</td>
					<td>DATE LOST/DAMAGED</td>
					<td>CHARGE AMOUNT</td>
					<td>DATE PAID</td>
				</tr>";
		do{
		
			if(isset($_REQUEST['print_asset_all'])){
			echo "<tr class='w3-small'>";
				echo "<td>".$r['serial_no']."</td>";
				echo "<td>".$r['description']."</td>";
				echo "<td align='center'>".$r['no_of_units']."</td>";
				echo "<td align='right'>".number_format($r['acquisition_cost'],2)."</td>";
				echo "<td align='right'>".number_format($r['no_of_units']*$r['acquisition_cost'],2)."</td>";
				echo "<td align='right'>".date('F d, Y',strtotime($r['acquisition_date']))."</td>";
				echo "<td align='right'>";
						if($_REQUEST['e_no']=='Damaged'){ echo date('F d, Y',strtotime($r['acquisition_date'])); }
				echo "</td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>"; }
			if(isset($_REQUEST['print_asset_specific'])){
			echo "<tr class='w3-small'>
					<form>";
				echo "<td>".$r['serial_no']."</td>";
				echo "<td>".$r['description']."</td>";
				echo "<td align='center'>".$r['no_of_units']."</td>";
				echo "<td align='right'>".number_format($r['acquisition_cost'],2)."</td>";
				echo "<td align='right'>".number_format($r['no_of_units']*$r['acquisition_cost'],2)."</td>";
				echo "<td align='right'>".date('F d, Y',strtotime($r['acquisition_date']))."</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td></td>";
			echo "</tr>"; }
		
		}while($r=mysql_fetch_assoc($q));
		echo "</table>";
	    echo "</td>
	   </tr>";
 echo "<tr>
			<td><br/>
				<span class='w3-small'>I hereby authorize ALC PRINTING HOUSE to deduct from my salary the above amount of materials in case of lost/damage due to my negligence.</span><br/><br/><br/>";
	  echo "</td>";
 echo "<tr>
			<td width='700'>Issued by:<br/><br/>
			<u>";
			$userx=$_SESSION['username'];
			$xx="select a.*, b.pos_description
					from users a 
					join user_positions b on a.position=b.position
				where a.username='$userx'";
			$yy=mysql_query($xx) or die(mysql_error());
			$zz=mysql_fetch_assoc($yy);
			
			echo $zz['first_name']." ".$zz['middle_name']." ".$zz['last_name'];
	  echo "</u>
		
			<br/>
			<span class='w3-small'>";
	  echo $zz['pos_description'];
	  echo "</span>
			</td>
			
			<td>CONFORME:<br/><br/><u>$name</u><br/><span class='w3-small'>Signature Over Printer Name</span></td>
	   </tr>
	   </table>";
?>