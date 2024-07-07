<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$current_user=$_SESSION['username'];
$spas="select * from user_access where username='$current_user'";
$qpas=mysql_query($spas) or die(mysql_error());
$access=mysql_fetch_assoc($qpas);

if(isset($_REQUEST['jo_no']))
{ 
	$sx=mysql_query("select b_id from sales_jo where jo_no='".$_REQUEST['jo_no']."'"); 
	$rx=mysql_fetch_assoc($sx);
	
	$jo_no=$_REQUEST['jo_no'];
	$b_id=$rx['b_id'];
	echo "<br/>";
}
else
{
	$sx=mysql_query("select jo_no from sales_jo where b_id='".$_REQUEST['b_id']."'"); 
	$rx=mysql_fetch_assoc($sx);
	
	$b_id=$_REQUEST['b_id'];
	$jo_no=$rx['jo_no'];
	echo "<br/>";
}



echo "&nbsp;&nbsp;<b>b_id = <span class='w3-text-red'>$b_id</span></b>&nbsp;&nbsp;&nbsp;&nbsp;";
echo "&nbsp;&nbsp;<b>jo_no = <span class='w3-text-red'>$jo_no</span></b>&nbsp;&nbsp;&nbsp;&nbsp;<a class='fa fa-refresh' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."'></a><br/>";


echo "<hr>";




//BOOKINGS
if($access['d27']==1)
{
$s5="select a.*, b.name from sales_bookings a left join sales_clients b on a.client_id=b.client_id where a.b_id='$b_id'";
$q5=mysql_query($s5) or die(mysql_error());
$r5=mysql_fetch_assoc($q5);
echo "<span class='w3-text-red'>".$s5."</span><br/>";
echo "<table class='w3-tiny table' border='1'>
		<tr class='w3-light-gray'>
			<td>b_id</td>
			<td class='w3-text-blue'><b>client_id</b></td>
			<td class='w3-text-blue'>CLIENT NAME</td>
			<td>q_id</td>
			<td>b_jo</td>
			<td>trans_type</td>
			<td>created_datetime</td>
			<td>created_by</td>
			<td>approved_datetime</td>
			<td>approved_by</td>
			<td>cancelled_datetime</td>
			<td>cancelled_by</td>
			<td>bch</td>
		</tr>";
do{	
  echo "<tr class='w3-hover-pale-red'>
			<td>".$r5['b_id']."</td>";
	
	echo "<td align='right'>";
				if(isset($_REQUEST['change_client']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='client_old' type='hidden' value='".$r5['client_id']."'>
							<input name='change_client' type='number' value='".$r5['client_id']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-blue'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&change_client=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r5['client_id']."</b>";
				}
	  echo "</td>
			
			<td class='w3-text-blue'>".$r5['name']."</td>
			<td>".$r5['q_id']."</td>
			<td>".$r5['b_jo']."</td>
			<td>".$r5['trans_type']."</td>
			<td>".$r5['created_datetime']."</td>
			<td>".$r5['created_by']."</td>
			<td>".$r5['approved_datetime']."</td>
			<td>".$r5['approved_by']."</td>
			<td>".$r5['cancelled_datetime']."</td>
			<td>".$r5['cancelled_by']."</td>
			<td>".$r5['bch']."</td>
	    </tr>";
}while($r5=mysql_fetch_assoc($q5));	  
echo "</table>";
}


//SALES BOOKINGS WITH DETAILS
if($access['d27']==1)
{
$s="select * from sales_bookings_details where b_id='$b_id'";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);

$s1="select sum(b_qty*b_amount) as jo_amount, sum(dr_qty*b_amount) as dr_amount from sales_bookings_details where b_id='$b_id'";
$q1=mysql_query($s1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);

echo "<span class='w3-text-red'>".$s."</span><br/>";
echo "<table class='w3-tiny table' border='1'>
		<tr class='w3-light-gray'>
			<td>b_count</td>
			<td>b_id</td>
			<td>b_qty</td>
			<td>dr_qty</td>
			<td>code_set</td>
			<td>b_unit</td>
			<td>b_size</td>
			<td>b_desc</td>
			<td>b_amount</td>
			<td align='right' class='w3-text-indigo'><b>unit totals</b></td>
			<td>dr totals</td>
			<td>b_date</td>
			<td>created_by</td>
			<td>created_date</td>
			<td>status</td>
			<td>dr_no</td>
			<td>dr_date</td>
			<td>dr_partial</td>
			<td>dr_posted_by</td>
			<td>dr_posted_date</td>
		</tr>";
do {
  echo "<tr class='w3-hover-pale-red'>
			<td>".$r['b_count']."</td>
			<td>".$r['b_id']."</td>
			
			<td align='right'>";
				if((isset($_REQUEST['edit_b_qty'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='b_qty_old' type='hidden' value='".$r['b_qty']."'>
							<input name='update_b_qty' type='number' value='".$r['b_qty']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_b_qty=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r['b_qty']."</b>";
					
				}
	  echo "</td>
			
			<td align='right'>";
				if((isset($_REQUEST['edit_dr_qty'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='dr_qty_old' type='hidden' value='".$r['dr_qty']."'>
							<input name='update_dr_qty' type='number' value='".$r['dr_qty']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_dr_qty=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r['dr_qty']."</b>";					
				}
	  echo "</td>
	  
			<td>";
			if((isset($_REQUEST['edit_code_set'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='code_set_old' type='hidden' value='".$r['code_set']."'>
							<input name='update_code_set' type='text' value='".$r['code_set']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_code_set=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r['code_set']."</b>";
					
				}
	  echo "</td>
			
			<td>";
			if((isset($_REQUEST['edit_b_unit'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='b_unit_old' type='hidden' value='".$r['b_unit']."'>
							<input name='update_b_unit' type='text' value='".$r['b_unit']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_b_unit=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r['b_unit']."</b>";
					
				}
	  echo "</td>
			
			<td>";
			if((isset($_REQUEST['edit_b_size'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='b_size_old' type='hidden' value='".$r['b_size']."'>
							<input name='update_b_size' type='text' value='".$r['b_size']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_b_size=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r['b_size']."</b>";
					
				}
	  echo "</td>";
			
	  echo "<td>";
	          if((isset($_REQUEST['edit_b_desc'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='b_desc_old' type='hidden' value='".$r['b_desc']."'>
							<input name='update_b_desc' type='text' value='".$r['b_desc']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_b_desc=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r['b_desc']."</b>";
					
				}
	  echo "</td>";
			
	  echo "<td align='right'>";
				if((isset($_REQUEST['edit_b_amount'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='b_amount_old' type='hidden' value='".$r['b_amount']."'>
							<input name='update_b_amount' type='number' step='any' value='".$r['b_amount']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_b_amount=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".number_format($r['b_amount'],2)."</b>";
					
				}
	  echo "</td>
			
			<td align='right' class='w3-text-indigo'>".number_format($r['b_qty']*$r['b_amount'],2)."</td>
			<td align='right'>".number_format($r['dr_qty']*$r['b_amount'],2)."</td>
			<td>".$r['b_date']."</td>
			<td>".$r['created_by']."</td>
			<td>".$r['created_date']."</td>
			<td>".$r['status']."</td>
			
			<td align='right'>";
				if((isset($_REQUEST['edit_dr_no'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='dr_no_old' type='hidden' value='".$r['dr_no']."'>
							<input name='update_dr_no' type='number' value='".$r['dr_no']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_dr_no=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r['dr_no']."</b>";					
				}
	  echo "</td>
	  
			
			<td align='right'>";
				if((isset($_REQUEST['edit_dr_date'])) and ($_REQUEST['b_count']==$r['b_count']))
				{
					  echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='b_count' type='hidden' value='".$r['b_count']."'>
							<input name='dr_date_old' type='hidden' value='".$r['dr_date']."'>
							<input name='update_dr_date' type='date' value='".$r['dr_date']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php   echo "</form>";
				}
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_dr_date=1&b_count=".$r['b_count']."'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r['dr_date']."</b>";					
				}
	  echo "</td>
	  
			
			<td>".$r['dr_partial']."</td>
			<td>".$r['dr_posted_by']."</td>
			<td>".$r['dr_posted_date']."</td>
		</tr>";
	
} while($r=mysql_fetch_assoc($q));

  echo "<tr>
			<td colspan='9'></td>
			<td align='right' class='w3-text-indigo'>
			<b>";
			
				$jo_amount1=$r1['jo_amount'];
				echo number_format($jo_amount1,2);
				mysql_query("update sales_jo set jo_amount='$jo_amount1' where jo_no='$jo_no'") or die(mysql_error());
				mysql_query("update sales_jo_payments set jo_amount='$jo_amount1' where jo_no='$jo_no'") or die(mysql_error());
			
	  echo "</b>
			</td>
			<td align='right'>".number_format($r1['dr_amount'],2)."</td>
			<td colspan='10'></td>
	    </tr>
    </table>";
}
	
	
	
	

//JO DETAILS
if($access['d26']==1 or $access['d27']==1)
{
$s2="select * from sales_jo where b_id='$b_id' and jo_no='$jo_no'";
$q2=mysql_query($s2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);
echo "<span class='w3-text-red'>".$s2."</span><br/>";
echo "<table class='w3-tiny table' border='1'>
		<tr class='w3-light-gray'>
			<td>jo_no</td>
			<td>jo_actual</td>
			<td>jo_actual_date</td>
			<td>bo_no</td>
			<td>bo_no_date</td>
			<td>po_no</td>
			<td>po_date</td>
			<td>b_id</td>
			<td align='right' class='w3-text-indigo'><b>jo_amount</b></td>
			<td align='right' class='w3-text-green'><b>jo_payment_amount</b></td>
			<td class='w3-text-blue'><b>client_id</b></td>
			<td>created</td>
			<td>validation</td>
			<td>completed</td>
			<td>production</td>
			<td>paid</td>
			<td>delivered</td>
		</tr>";
do{	
  echo "<tr class='w3-hover-pale-red'>
			<td>".$r2['jo_no']."</td>
			<td align='right' class='w3-text-indigo'>";
				if(isset($_REQUEST['edit_jo_actual']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='jo_actual_old' type='hidden' value='".$r2['jo_actual']."'>
							<input name='update_jo_actual' type='text' value='".$r2['jo_actual']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_jo_actual=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r2['jo_actual']."</b>";
					
				}
	  echo "</td>			
			<td align='right' class='w3-text-indigo'>";
				if(isset($_REQUEST['edit_jo_actual_date']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='jo_actual_date_old' type='hidden' value='".$r2['jo_actual_date']."'>
							<input name='update_jo_actual_date' type='date' value='".$r2['jo_actual_date']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_jo_actual_date=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".date('d/m/Y',strtotime($r2['jo_actual_date']))."</b>";
					
				}
	  echo "</td>
			<td align='right' class='w3-text-indigo'>";
				if(isset($_REQUEST['edit_bo_no']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='bo_no_old' type='hidden' value='".$r2['bo_no']."'>
							<input name='update_bo_no' type='text' value='".$r2['bo_no']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_bo_no=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r2['bo_no']."</b>";
					
				}
	  echo "</td>			
			<td align='right' class='w3-text-indigo'>";
				if(isset($_REQUEST['edit_bo_no_date']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='bo_no_date_old' type='hidden' value='".$r2['bo_no_date']."'>
							<input name='update_bo_no_date' type='date' value='".$r2['bo_no_date']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_bo_no_date=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".date('d/m/Y',strtotime($r2['bo_no_date']))."</b>";
					
				}
	  echo "</td>
			<td align='right'>";
				if(isset($_REQUEST['edit_po_no']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='po_no_old' type='hidden' value='".$r2['po_no']."'>
							<input name='update_po_no' type='text' value='".$r2['po_no']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_po_no=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r2['po_no']."</b>";
					
				}
	  echo "</td>
			<td align='right'>";
				if(isset($_REQUEST['edit_po_date']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='po_date_old' type='hidden' value='".$r2['po_date']."'>
							<input name='update_po_date' type='date' value='".$r2['po_date']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_po_date=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".date('d/m/Y',strtotime($r2['po_date']))."</b>";
				}
	  echo "</td>
			<td>".$r2['b_id']."</td>
			<td align='right' class='w3-text-indigo'><b>".number_format($r2['jo_amount'],2)."</b></td>
			
			
			
			
			
			<td align='right' class='w3-text-green'>
				
				<b>";
					
					$sb="update sales_jo set jo_payment_amount=(select sum(payment) from sales_jo_payments where jo_no='$jo_no') where jo_no='$jo_no'";
					$qb=mysql_query($sb) or die(mysql_error());
					echo number_format($r2['jo_payment_amount'],2);
				
		  echo "</b>
			
			</td>
		
			
			<td class='w3-text-blue'><b>".$r2['client_id']."</b></td>
			<td>".$r2['created_by']."<br/>".$r2['created_datetime']."</td>
			
			<td>";
			
			if(isset($_REQUEST['edit_validation']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='old_validation' type='hidden' value='".$r2['validation']."'>
							<input name='update_validation' type='number' value='".$r2['validation']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_validation=1'></a></b>";
					echo "&nbsp;&nbsp;&nbsp;".$r2['validation']."<br/>".$r2['validation_date']."<br/>".$r2['2nd_validation'];
				}
			
	  echo "</td>
			
			
			<td>".$r2['completed_by']."<br/>".$r2['completed_datetime']."</td>
			
			
			<td>";
			
			if(isset($_REQUEST['edit_production_status']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='old_production_status' type='hidden' value='".$r2['production_status']."'>
							<input name='update_production_status' type='number' value='".$r2['production_status']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_production_status=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r2['production_status']."</b><br/>".$r2['production_date'];
				}
			
	  echo "</td>
			
			
			<td>";
			
			if(isset($_REQUEST['edit_paid_status']))
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='old_paid_status' type='hidden' value='".$r2['paid']."'>
							<input name='update_paid_status' type='number' value='".$r2['paid']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?b_id=".$b_id."&jo_no=".$jo_no."&edit_paid_status=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r2['paid']."</b>";
				}
			
	  echo "</td>
	  
			<td>"; ?>
			
			<?php echo $r2['delivered']; ?> 
			
			<?php if($r2['delivered']==0){ ?>
			&nbsp;&nbsp;&nbsp;<a title='Cancel JO' class='fa fa-ban' href='<?php echo "script_sales_tools2.php?b_id=".$b_id."&jo_no=".$jo_no."&cancel_jo=1'"; ?>' onclick='return confirm("Are you sure? Action is Permanent!")'></a>
			<?php } else { ?>
			&nbsp;&nbsp;&nbsp;<a title='Revive JO' class='fa fa-check' href='<?php echo "script_sales_tools2.php?b_id=".$b_id."&jo_no=".$jo_no."&revive_jo=1'"; ?>' onclick='return confirm("Are you sure? Action is Permanent!")'></a>
			<?php } ?>
	<?php  echo "</td>
	    </tr>";
}while($r2=mysql_fetch_assoc($q2));	  
echo "</table>";
}






//JO PAYMENTS
if($access['d26']==1)
{
$s3="select * from sales_jo_payments where jo_no='$jo_no'";
$q3=mysql_query($s3) or die(mysql_error());
$r3=mysql_fetch_assoc($q3);
echo "<span class='w3-text-red'>".$s3."</span><br/>";
echo "<table class='w3-tiny table' border='1'>
		<tr class='w3-light-gray'>
			<td>id</td>
			<td class='w3-text-blue'><b>client_id</b>	</td>
			<td>q_id</td>
			<td>b_id</td>
			<td>jo_no</td>
			<td align='right' class='w3-text-indigo'><b>jo_amount</b></td>
			<td align='right' class='w3-text-green'><b>payment</b></td>
			<td>pay_mode</td>
			<td>or_no</td>
			<td>or_date</td>
			<td>remarks</td>
			<td>payment_by</td>
			<td>payment_datetime</td>
			<td>pay_type</td>
		</tr>";
do{	
  echo "<tr class='w3-hover-pale-red'>
			<td>"; 
			
			$p_id=$r3['id'];
			$p_client_id=$r3['client_id'];
			$p_payment=$r3['payment'];
			$p_pay_mode=$r3['pay_mode'];
			$p_or_no=$r3['or_no'];
			$p_or_date=$r3['or_date'];
			?>
			
			<!--
			<a href='<?php // echo "script_sales_tools2.php?b_id=$b_id&jo_no=$jo_no&delete_payment_no=$p_id&p_client_id=$p_client_id&p_payment=$p_payment&p_pay_mode=$p_pay_mode&p_or_no=$p_or_no&p_or_date=$p_or_date"; ?>' class='fa fa-trash' onclick='return confirm("Are you sure? Action is Permanent!")'></a> <?php  echo "&nbsp;&nbsp;".$r3['id']; ?>
			-->
	  
<?php echo "</td>
			<td class='w3-text-blue'><b>".$r3['client_id']."</b></td>
			<td>".$r3['q_id']."</td>
			<td>".$r3['b_id']."</td>
			<td>".$r3['jo_no']."</td>
			<td align='right' class='w3-text-indigo'><b>".number_format($r3['jo_amount'],2)."</b></td>
			
			
			<td align='right' class='w3-text-green'>";
				if(isset($_REQUEST['edit_payment']) and $r3['id']==$_REQUEST['id'])
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='id' type='hidden' value='".$r3['id']."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='payment_old' type='hidden' value='".$r3['payment']."'>
							<input name='update_payment' type='number' step='any' value='".$r3['payment']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-green'><a class='fa fa-pencil' href='script_sales_tools.php?id=".$r3['id']."&b_id=".$b_id."&jo_no=".$jo_no."&edit_payment=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".number_format($r3['payment'],2)."</b>";
				}
	  echo "</td>";
	  
			
	  echo "<td>";
	  
			if(isset($_REQUEST['edit_pay_mode']) and $r3['id']==$_REQUEST['id'])
				{
					echo "<form action='script_sales_tools2.php'>
					
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='id' type='hidden' value='".$r3['id']."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='pay_mode_old' type='hidden' value='".$r3['pay_mode']."'>
							
							
							<select required name='update_pay_mode'>
								<option selected value=".$r3['pay_mode'].">".$r3['pay_mode']."</option>
								<option value='Cash'>Cash</option>
								<option value='Cheque'>Cheque</option>
								<option value='CreditMemo'>Credit Memo</option>
								<option value='Discount'>Discount</option>
								<option value='Sponsor'>Sponsor</option>
								<option value='Exdeal'>Ex Deal</option>
								<option value='VatExempt'>Vat Exempt</option>
								<option value='2306'>2306 Witheld</option>
								<option value='2307'>2307 Witheld</option>
							</select><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
							
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?id=".$r3['id']."&b_id=".$b_id."&jo_no=".$jo_no."&edit_pay_mode=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r3['pay_mode']."</b>";
				}
	  
	  echo "</td>
			
			
			<td align='right'>";
				if(isset($_REQUEST['edit_or_no']) and $r3['id']==$_REQUEST['id'])
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='id' type='hidden' value='".$r3['id']."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='or_no_old' type='hidden' value='".$r3['or_no']."'>
							<input name='update_or_no' type='number' value='".$r3['or_no']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?id=".$r3['id']."&b_id=".$b_id."&jo_no=".$jo_no."&edit_or_no=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r3['or_no']."</b>";
				}
	  echo "</td>	
			
			
			
			
			
			<td align='right'>";
				if(isset($_REQUEST['edit_or_date']) and $r3['id']==$_REQUEST['id'])
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='id' type='hidden' value='".$r3['id']."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='or_date_old' type='hidden' value='".$r3['or_date']."'>
							<input name='update_or_date' type='date' value='".$r3['or_date']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?id=".$r3['id']."&b_id=".$b_id."&jo_no=".$jo_no."&edit_or_date=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r3['or_date']."</b>";
				}
	  echo "</td>
			
			
			<td align='right'>";
				if(isset($_REQUEST['edit_or_remarks']) and $r3['id']==$_REQUEST['id'])
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='id' type='hidden' value='".$r3['id']."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='or_remarks_old' type='hidden' value='".$r3['remarks']."'>
							<input name='update_or_remarks' type='text' value='".$r3['remarks']."'><br/>"; ?>
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?id=".$r3['id']."&b_id=".$b_id."&jo_no=".$jo_no."&edit_or_remarks=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r3['remarks']."</b>";
				}
	  echo "</td>
			
			<td>".$r3['payment_by']."</td>
			<td>".$r3['payment_datetime']."</td>
			
			
			
			<td align='right'>";
				if(isset($_REQUEST['edit_or_pay_type']) and $r3['id']==$_REQUEST['id'])
				{
					echo "<form action='script_sales_tools2.php'>
							<input name='b_id' type='hidden' value='".$b_id."'>
							<input name='id' type='hidden' value='".$r3['id']."'>
							<input name='jo_no' type='hidden' value='".$jo_no."'>
							<input name='or_pay_type_old' type='hidden' value='".$r3['pay_type']."'>
							<select name='update_or_pay_type'>
							     <option selected>".$r3['pay_type']."</option>
								 <option>Full</option>
								 <option>Partial</option> 
							</select><br/>"; ?>
							
							
							<input type='submit' value='update' onclick='return confirm("Action is Final! Do you wish to Continue?")'>
			  <?php echo "</form>";
				}
				
				else
				{
					echo "<b class='w3-text-indigo'><a class='fa fa-pencil' href='script_sales_tools.php?id=".$r3['id']."&b_id=".$b_id."&jo_no=".$jo_no."&edit_or_pay_type=1'></a>";
					echo "&nbsp;&nbsp;&nbsp;".$r3['pay_type']."</b>";
				}
	  echo "</td>
	  
	    </tr>";
  }while($r3=mysql_fetch_assoc($q3));	  
echo "</table>";
}






//JO PROGRESS--------------------------------------------------------------------------
if($access['d26']==1)
{
$s4="select * from sales_jo_progress where jo_no='$jo_no'";
$q4=mysql_query($s4) or die(mysql_error());
$r4=mysql_fetch_assoc($q4);
echo "<span class='w3-text-red'>".$s4."</span><br/>";
echo "<table class='w3-tiny table' border='1'>
		<tr class='w3-light-gray'>
			<td>count</td>
			<td>jo_no</td>
			<td>jo_msg</td>
			<td>jo_msg_by</td>
			<td>date</td>
			<td>time</td>
			<td>status</td>
			<td>dr_set</td>
		</tr>";
do{	
  echo "<tr class='w3-hover-pale-red'>
			<td>"; ?>
			
			<a href='script_sales_tools2.php?b_id=<?php echo $b_id."&jo_no=$jo_no&delete_progress_no=".$r4['count']."&jo_msg=".$r4['jo_msg']."&jo_msg_by=".$r4['jo_msg_by']."&msg_date=".$r4['date']; ?>' class='fa fa-trash' onclick='return confirm("Are you sure? Action is Permanent!")'></a>&nbsp;
	  
	  <?php echo $r4['count']."</td>
			<td>".$r4['jo_no']."</td>
			<td>".$r4['jo_msg']."</td>
			<td>".$r4['jo_msg_by']."</td>
			<td>".$r4['date']."</td>
			<td>".$r4['time']."</td>
			<td>".$r4['status']."</td>
			<td>".$r4['dr_set']."</td>
	    </tr>";
}while($r4=mysql_fetch_assoc($q4));	  
echo "</table><br/>";
}
//------------------------------------------------------------------------------------
?>