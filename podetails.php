<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");
include("current_user.php");

if(isset($_REQUEST['set_supplier']))
{
	$supplier=$_REQUEST['set_supplier'];
	$po_no=$_REQUEST['po_no'];
	mysql_query("update proc_po set supplier='$supplier' where po_no='$po_no'") or die(mysql_error());
	header('Location: podetails.php?po_no='.$_REQUEST['po_no']);
}

if(isset($_REQUEST['set_cargo']))
{
	$cargo=$_REQUEST['set_cargo'];
	$po_no=$_REQUEST['po_no'];
	mysql_query("update proc_po set cargo='$cargo' where po_no='$po_no'") or die(mysql_error());
	header('Location: podetails.php?po_no='.$_REQUEST['po_no']);
}

if(isset($_REQUEST['set_term']))
{
	$term=$_REQUEST['set_term'];
	$po_no=$_REQUEST['po_no'];
	mysql_query("update proc_po set terms='$term' where po_no='$po_no'") or die(mysql_error());
	header('Location: podetails.php?po_no='.$_REQUEST['po_no']);
}

if(isset($_REQUEST['pr_no']))
{
	$pr_no=$_REQUEST['pr_no'];
	$po_no=$_REQUEST['po_no'];
	mysql_query("update proc_po set pr_no='$pr_no' where po_no='$po_no'") or die(mysql_error());
	header('Location: podetails.php?po_no='.$_REQUEST['po_no']);
}
$po_no=$_REQUEST['po_no'];
?>

<script>
function showHint1(str)
{
var s=document.getElementById("search1").value;
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
    document.getElementById("view_result1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","result1.php?item_add=1&po_no=<?php echo $po_no; ?>&s="+s,true);
xmlhttp.send();
}
</script>

<br>
<div class='container'>

<table class='table' border='1'>
	<tr>
		<td colspan='5'>
			<?php
			$xx=mysql_query("select pr_no,add_date from proc_po where po_no='$po_no'");
			$yy=mysql_fetch_assoc($xx);
			?>
			<span class='w3-tiny'>PO NO:</span>&nbsp;<b class='w3-xlarge w3-text-blue'><?php echo $po_no; ?></b>&nbsp;&nbsp;&nbsp;
			<span class='w3-tiny'>PO DATE:</span>&nbsp;<span class='w3-tiny w3-text-deep-orange'><?php echo date('m/d/Y',strtotime($yy['add_date'])); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<span class='w3-tiny'>SUPPLIER NAME:</span>
			
			<?php 
				$po_no=$_REQUEST['po_no'];
				$gs1=mysql_query("select b.supplier as supplier 
								from proc_po as a 
								inner join proc_suppliers as b 
								on a.supplier=b.id 
								where a.po_no='$po_no'") or die(mysql_error());
				$gr1=mysql_fetch_assoc($gs1);
				echo "<b class='w3-text-red'>".$gr1['supplier']."</b>";
			
			if($access['i1']==1){ echo "</br></br>";}else{	
				$sd=mysql_query("select id,supplier from proc_suppliers order by supplier asc") or die(mysql_error());
				$rd=mysql_fetch_assoc($sd);
				echo "<form>
						  <select name='set_supplier' class='btn w3-light-gray w3-tiny'><option></option>";
				do{ echo "<option value='".$rd['id']."'>".$rd['supplier']."</option>";
				}while($rd=mysql_fetch_assoc($sd));
					echo "</select>"; ?>
					<input name='po_no' type='hidden' value='<?php echo $_REQUEST['po_no']; ?>'>
					<input class='btn w3-tiny w3-green' type='submit' value='SET'>
		        </form>
			<?php } ?>
			<span class='w3-tiny'>SHIPPING INSTRUCTION:</span>
			<?php 
			
				$po_no=$_REQUEST['po_no'];
				$gs2=mysql_query("select b.cargo as cargo 
								from proc_po as a 
								inner join proc_cargo as b 
								on a.cargo=b.id 
								where a.po_no='$po_no'") or die(mysql_error());
				$gr2=mysql_fetch_assoc($gs2);
				echo "<b class='w3-text-red'>".$gr2['cargo']."</b>";
			
			if($access['i1']==1){ echo "</br></br>";}else{	
				$sd=mysql_query("select id,cargo from proc_cargo order by cargo asc") or die(mysql_error());
				$rd=mysql_fetch_assoc($sd);
				echo "<form>
						<select name='set_cargo' class='btn w3-light-gray w3-tiny'><option></option>";
				do{ echo "<option value='".$rd['id']."'>".$rd['cargo']."</option>";
				}while($rd=mysql_fetch_assoc($sd));
				  echo "</select>"; ?>
				<input name='po_no' type='hidden' value='<?php echo $_REQUEST['po_no']; ?>'>
				<input class='btn w3-tiny w3-green' type='submit' value='SET'>
		        </form>
			<?php } ?>	
		</td>
		<td colspan='3'>
			<span class='w3-tiny'>PR NO:</span>
				<b class='w3-text-red'>
				<?php echo $yy['pr_no']; ?>
				</b>
	<?php if($access['i1']==1){ echo "</br></br>";}else{ ?>
			<form>
				<input required name='pr_no' type='text' class='btn w3-light-gray w3-tiny' placeholder='Input PR Details'>
				<input name='po_no' type='hidden' value='<?php echo $po_no; ?>'>
				<input class='btn w3-tiny w3-green' type='submit' value='SET'>
			</form>
	<?php } ?>		
			
			
			<span class='w3-tiny'>TERM/S:</span>
			<?php 
			
				$po_no=$_REQUEST['po_no'];
				$gs2=mysql_query("select b.terms_desc as terms_desc 
								from proc_po as a 
								inner join proc_terms as b 
								on a.terms=b.id 
								where a.po_no='$po_no'") or die(mysql_error());
				$gr2=mysql_fetch_assoc($gs2);
				echo "<b class='w3-text-red'>".$gr2['terms_desc']."</b>";
			
			if($access['i1']==1){ echo "</br></br>";}else{	
				$sd=mysql_query("select id,terms_desc from proc_terms order by terms asc") or die(mysql_error());
				$rd=mysql_fetch_assoc($sd);
				echo "<form>
						<select name='set_term' class='btn w3-light-gray w3-tiny'><option></option>";
				do{ echo "<option value='".$rd['id']."'>".$rd['terms_desc']."</option>";
				}while($rd=mysql_fetch_assoc($sd));
				  echo "</select>"; ?>
				<input name='po_no' type='hidden' value='<?php echo $_REQUEST['po_no']; ?>'>
				<input class='btn w3-tiny w3-green' type='submit' value='SET'>
		        </form>
			<?php } ?>	
		</td>
		
		
		<td align='center'>
			<form method='get' action='proc_print_po.php' target='_blank'>
				<input name='po_no' type='hidden' value='<?php echo $_REQUEST['po_no']; ?>'>
				<input class='btn w3-amber w3-tiny' name='print_po' type='submit' value='PRINT PO'>
			</form>
			
		</td>
	</tr>	
	<tr>
		<td colspan='4'>
		
		<?php if($access['i1']==1){}else{ ?>		
			<input class='btn w3-pale-blue w3-tiny' type="text" placeholder='SEARCH ITEM' id="search1" name="search1" onkeyup="showHint1('x')"/>
			<div id="view_result1"></div>
		<?php } ?>
		<td>
	</tr>
	<tr class='w3-green w3-tiny'> 
		<td>ITEM</td>
		<td>QTY</td>
		<td>UNIT</td>
		<td>UNIT PRICE</td>
		<td>TOTAL</td>
	</tr>
	<?php
		$po_no=$_REQUEST['po_no'];
		$sm1="select b.item as item,
					c.unit as unit,
					 a.id as id,
					 a.qty as qty,
					 b.price as price
			    from proc_po_details as a
				inner join proc_items as b
				on b.id=a.item
				inner join proc_units as c
				on c.id=b.unit
				where po_no='$po_no' 
				order by a.add_date desc";
		$qm1=mysql_query($sm1) or die(mysql_error());
		$rm1=mysql_fetch_assoc($qm1);
		
		do{
			echo "<tr>
					<td class='w3-tiny'>".$rm1['item']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if($access['i1']==1){}else{
					?>
					<a href="script_po_delete_item_on_list.php?id=<?php echo $rm1['id']; ?>&po_no=<?php echo $_REQUEST['po_no']; ?>" class="w3-large fa fa-trash" onclick="return confirm('Delete Item?')"></a>
					<?php }
					
			  echo "</td>
					<td class='w3-tiny'>".$rm1['qty']."</td>
					<td class='w3-tiny'>".$rm1['unit']."</td>
					<td class='w3-tiny'>".number_format($rm1['price'],2)."</td>
					<td class='w3-tiny'>".number_format($rm1['qty']*$rm1['price'],2)."</td>
				</tr>";
		}while($rm1=mysql_fetch_assoc($qm1));
	
	
		$sm2="select SUM(a.qty*b.price) as sum
			    from proc_po_details as a
				inner join proc_items as b
				on b.id=a.item
				where po_no='$po_no'";
		$qm2=mysql_query($sm2) or die(mysql_error());
		$rm2=mysql_fetch_assoc($qm2);
		
		$vat=$rm2['sum']*.12;
		$total1=$rm2['sum']+$vat;
		
		echo "<tr><td colspan='5' align='right'>Input Tax:&nbsp;&nbsp;&nbsp;".number_format($rm2['sum']*.12,2)."</td></tr>";
		echo "<tr><td colspan='5' align='right'>TOTAL:&nbsp;&nbsp;&nbsp;<b class='w3-text-red'>".number_format($rm2['sum']+$vat,2)."</b></td></tr>";
		
		mysql_query("update proc_po set po_amount='$total1' where po_no='$po_no'") or die(mysql_error());
	
	?>
</table>

</div>
