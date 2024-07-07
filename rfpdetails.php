<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");

$rfp_no=$_REQUEST['rfp_no'];

if(isset($_REQUEST['set_term'])){
$rfp_no=$_REQUEST['rfp_no'];
$term=$_REQUEST['set_term'];
mysql_query("update proc_rfp set rfp_terms='$term' where rfp_no='$rfp_no'") or die(mysql_error());
header('Location: rfpdetails.php?rfp_no='.$_REQUEST['rfp_no']);
}

if(isset($_REQUEST['request_type'])){
$rfp_no=$_REQUEST['rfp_no'];
$term=$_REQUEST['request_type'];
mysql_query("update proc_rfp set request_type='$term' where rfp_no='$rfp_no'") or die(mysql_error());
header('Location: rfpdetails.php?rfp_no='.$_REQUEST['rfp_no']);
}

if(isset($_REQUEST['date_needed'])){
$rfp_no=$_REQUEST['rfp_no'];
$date_needed=$_REQUEST['date_needed'];
mysql_query("update proc_rfp set date_needed='$date_needed' where rfp_no='$rfp_no'") or die(mysql_error());
header('Location: rfpdetails.php?rfp_no='.$_REQUEST['rfp_no']);
}

if(isset($_REQUEST['rr'])){
$rfp_no=$_REQUEST['rfp_no'];
$rr=$_REQUEST['rr'];
$rr_date=$_REQUEST['rr_date'];
mysql_query("update proc_rfp set RR='$rr', RR_date='$rr_date' where rfp_no='$rfp_no'") or die(mysql_error());
header('Location: rfpdetails.php?rfp_no='.$_REQUEST['rfp_no']);
}

if(isset($_REQUEST['si'])){
$rfp_no=$_REQUEST['rfp_no'];
$si=$_REQUEST['si'];
$si_date=$_REQUEST['si_date'];
mysql_query("update proc_rfp set SI='$si', SI_date='$si_date' where rfp_no='$rfp_no'") or die(mysql_error());
header('Location: rfpdetails.php?rfp_no='.$_REQUEST['rfp_no']);
}
?>

<script>
function showHint2(str)
{
var s=document.getElementById("search2").value;
var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("view_result2").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","result2.php?rfp_no=<?php echo $rfp_no; ?>&s="+s,true);
xmlhttp.send();
}
</script>

<br>
<div class='container'>

<table class='table' border='1'>
	<tr>
		<td colspan='2'>
			<?php
			$xx=mysql_query("select * from proc_rfp where rfp_no='$rfp_no'");
			$yy=mysql_fetch_assoc($xx);
			?>
			<span class='w3-tiny'>RFP NO:</span>&nbsp;<b class='w3-xlarge w3-text-blue'><?php echo $rfp_no; ?></b>&nbsp;&nbsp;&nbsp;
			<span class='w3-tiny'>RFP DATE:</span>&nbsp;<span class='w3-tiny w3-text-deep-orange'><?php echo date('m/d/Y',strtotime($yy['add_date'])); ?></span>
		</td>
	</tr>
	
	<tr>
		<td>
		
				<table class='table'>
				<tr>
					<td>&nbsp;&nbsp;<br/>
						<input class='btn w3-pale-blue w3-tiny' type="text" placeholder='SEARCH PO' id="search2" name="search2" onkeyup="showHint2('x')"/>
						<div id="view_result2"></div>
					<td>
					<td>
						<span class='w3-tiny'>TERM/S:</span>
						<?php 
						$gs2=mysql_query("select b.terms_desc as terms_desc 
										from proc_rfp as a 
										inner join proc_terms as b 
										on a.rfp_terms=b.id 
										where a.rfp_no='$rfp_no'") or die(mysql_error());
						$gr2=mysql_fetch_assoc($gs2);
						echo "<b class='w3-text-red w3-tiny'>".$gr2['terms_desc']."</b>";
						
						$sd=mysql_query("select id,terms_desc from proc_terms order by terms asc") or die(mysql_error());
						$rd=mysql_fetch_assoc($sd);
						echo "<form>
								<select required name='set_term' class='btn w3-light-gray w3-tiny'><option></option>";
						do{ echo "<option value='".$rd['id']."'>".$rd['terms_desc']."</option>";
						}while($rd=mysql_fetch_assoc($sd));
						  echo "</select>"; ?>
						<input name='rfp_no' type='hidden' value='<?php echo $_REQUEST['rfp_no']; ?>'>
						<input class='btn w3-tiny w3-blue' type='submit' value='SET'>
						</form>
					</td>
					<td>
						<span class='w3-tiny'>TYPE OF REQUEST:</span>&nbsp;&nbsp;<b class='w3-text-red w3-tiny'><?php echo $yy['request_type']; ?></b>
						<form>
						<select required name='request_type' class='btn w3-light-gray w3-tiny'>
							<option></option>
							<option>PAYMENT</option>
							<option>CASH ADVANCE</option>
							<option>REIMBURSEMENT</option>
						</select>
						<input name='rfp_no' type='hidden' value='<?php echo $_REQUEST['rfp_no']; ?>'>
						<input class='btn w3-tiny w3-blue' type='submit' value='SET'>
						</form>
					</td>
					<td>
						<span class='w3-tiny'>DATE NEEDED:</span>&nbsp;&nbsp;<b class='w3-text-red w3-tiny'><?php echo date('m/d/Y',strtotime($yy['date_needed'])); ?></b>
						<form>
						<input required name='date_needed' type='date' class='btn w3-light-gray w3-tiny'>
						<input name='rfp_no' type='hidden' value='<?php echo $_REQUEST['rfp_no']; ?>'>
						<input class='btn w3-tiny w3-blue' type='submit' value='SET'>
						</form>
					</td>
					
					
					<td>
						<span class='w3-tiny'>RR:</span>&nbsp;&nbsp;<b class='w3-text-red w3-tiny'><?php echo $yy['RR']; ?></b>
						<span class='w3-tiny'>RR Date:</span>&nbsp;&nbsp;<b class='w3-text-red w3-tiny'><?php echo date('m/d/Y',strtotime($yy['RR_date'])); ?></b>
						<form>
						<input required name='rr' type='text' class='btn w3-light-gray w3-tiny'>
						<input required name='rr_date' type='date' class='btn w3-light-gray w3-tiny'>
						<input name='rfp_no' type='hidden' value='<?php echo $_REQUEST['rfp_no']; ?>'>
						<input class='btn w3-tiny w3-blue' type='submit' value='SET'>
						</form>
					</td>
					
					
					<td>
						<span class='w3-tiny'>SI:</span>&nbsp;&nbsp;<b class='w3-text-red w3-tiny'><?php echo $yy['SI']; ?></b>
						<span class='w3-tiny'>SI Date:</span>&nbsp;&nbsp;<b class='w3-text-red w3-tiny'><?php echo date('m/d/Y',strtotime($yy['SI_date'])); ?></b>
						<form>
						<input required name='si' type='text' class='btn w3-light-gray w3-tiny'>
						<input required name='si_date' type='date' class='btn w3-light-gray w3-tiny'>
						<input name='rfp_no' type='hidden' value='<?php echo $_REQUEST['rfp_no']; ?>'>
						<input class='btn w3-tiny w3-blue' type='submit' value='SET'>
						</form>
					</td>
				</tr>
				</table>
		
		
		</td>
		<td align='center'>
			<form method='get' action='proc_print_rfp.php' target='_blank'>
				<input name='rfp_no' type='hidden' value='<?php echo $_REQUEST['rfp_no']; ?>'>
				<input name='po_no' type='hidden' value='<?php echo $_REQUEST['po_no']; ?>'>
				<input class='btn w3-amber w3-tiny' name='print_rfp' type='submit' value='PRINT RFP'>
			</form>
		</td>
	</tr>
	
	<tr class='w3-green w3-tiny'> 
		<td>PO NO</td>
		<td align='right'>AMOUNT</td>
	</tr>
	
	<?php
		$po_no=$_REQUEST['po_no'];
		$sm1="select po_no,po_amount from proc_po where rfp_no='$rfp_no'";
		$qm1=mysql_query($sm1) or die(mysql_error());
		$rm1=mysql_fetch_assoc($qm1);
		
		do{
			echo "<tr>
					<td><b>".$rm1['po_no']."</b></td>
					<td align='right'><b>".number_format($rm1['po_amount'],2)."</b></td>
				</tr>";
		}while($rm1=mysql_fetch_assoc($qm1));
	
		$sm2="select rfp_amount from proc_rfp where rfp_no='$rfp_no'";
		$qm2=mysql_query($sm2) or die(mysql_error());
		$rm2=mysql_fetch_assoc($qm2);
		
		echo "<tr><td colspan='2' align='right'>TOTAL:&nbsp;&nbsp;&nbsp;<b class='w3-text-red'>".number_format($rm2['rfp_amount'],2)."</b></td></tr>";
	?>
</table>
</div>