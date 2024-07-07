<?php
include('connection/conn.php');
session_start();
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
date_default_timezone_set("Asia/Manila");
$s="select * from company";
$q=mysql_query($s) or die(mysql_error());
$r=mysql_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<title><?php echo $r['company_name']; ?></title>

<?php include("css.php"); ?>


<?php
if(isset($_REQUEST['po_no']))
{
	$user=$_SESSION['username'];
	$po_no=$_REQUEST['po_no'];
	mysql_query("insert into proc_po (po_no,add_by,add_date) value ('$po_no','$user',now())") or die(mysql_error());
	header('Location: admin_proc.php?procurement=1&po_list=1');
}

if(isset($_REQUEST['rfp_no']))
{
	$user=$_SESSION['username'];
	$rfp_no=$_REQUEST['rfp_no'];
	mysql_query("insert into proc_rfp (rfp_no,add_by,add_date) value ('$rfp_no','$user',now())") or die(mysql_error());
	header('Location: admin_proc.php?procurement=1&rfp_list=1');
}

if(isset($_REQUEST['new_main']))
{
$id=$_REQUEST['id'];
$new_main=$_REQUEST['new_main'];
mysql_query("update proc_category_main set category='$new_main' where id='$id'");
header('Location: admin_proc.php?procurement=1&category=1');
}

if(isset($_REQUEST['new_sub']))
{
$id=$_REQUEST['id'];
$new_sub=$_REQUEST['new_sub'];
mysql_query("update proc_category_sub set category='$new_sub' where id='$id'");
header('Location: admin_proc.php?procurement=1&category=1');
}

if(isset($_REQUEST['new_unique']))
{
$id=$_REQUEST['id'];
$new_unique=$_REQUEST['new_unique'];
mysql_query("update proc_category_unique set category='$new_unique' where id='$id'");
header('Location: admin_proc.php?procurement=1&category=1');
}
?>

<body class="w3-light-grey">

<!-- Top container ----->
<div class="w3-container w3-top w3-green w3-large w3-padding" style="z-index:4">
  <button class="w3-button w3-hide-large w3-padding-0 w3-green w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-right"><?php echo $r['company_name']; ?></span>
</div>
<!-- Top container ----->

<!-- Sidenav/menu -->

<?php include("current_user.php"); ?>

<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav">
  <br/>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
	<img src="img/id/<?php echo $r91['e_no']; ?>.jpg" class="w3-circle" style="width:80%">
	</div>
    <div class="w3-col s8 w3-bar">
	<span class="text-primary">Current User:</span><br>
   <span class="text-primary"><strong><?php echo $r9['first_name']." ".$r9['last_name'];?></strong><br>
   <?php echo $r8['pos_description'];?></span>
     </div>
	</div>
<hr>

<?php include("menu.php"); ?>

</nav>

<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="mySidenav"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:35px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px"></header>
  <div class="w3-row-padding w3-margin-bottom">

<!--Procurement Start-------->
<?php if(isset($_REQUEST['procurement'])) { ?>   
	<div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
        <div class="w3-left w3-xlarge"><i class="fa fa-cart-plus w3-xlarge"></i>  Procurement</div>
      </div>
	  <br>
	  <div class="container">
         <ul class="nav nav-tabs">
		 
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['po_list'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&po_list=1">PO Monitor</a></li>
		  <?php //} ?>
		  
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['rfp_list'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&rfp_list=1">RFP Monitor</a></li>
		  <?php //} ?>
		  
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['items'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&items=1">Items</a></li>
		  <?php //} ?>
		  
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['units'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&units=1">Units</a></li>
		  <?php //} ?>
		  
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['category'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&category=1">Category</a></li>
		  <?php //} ?>
		  
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['suppliers'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&suppliers=1">Suppliers</a></li>
		  <?php //} ?>
		  
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['cargo'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&cargo=1">Cargo Forwarder</a></li>
		  <?php //} ?>
		  
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['terms'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&terms=1">Terms Maintenance</a></li>
		  <?php //} ?>
		  
		  <?php //if($access['d2']==1){ ?>
		       <?php if(isset($_REQUEST['reports'])) { echo "<li class='active'>"; } else { echo "<li class='inactive'>"; } ?>
				<a href="admin_proc.php?procurement=1&reports=1">Reports</a></li>
		  <?php //} ?>
          
		  </ul>
      </div>

	  
<?php 
//PO List Start-----
if(isset($_REQUEST['po_list']))
{ ?>
<br>
<form method='get'>
	<input name='procurement' type='hidden' value='1'>
	<input name='po_list' type='hidden' value='1'>
	<input required class='btn' name='po_no' type='text' placeholder='PO Number'>
	<input class='btn btn-danger' type='submit' value='CREATE PO' onclick='return confirm("Create PO Now?")'>
</form>

	<br>
	<table class='table'>
	  <tr class='w3-dark-gray w3-tiny'>
		<td>PO NO.</td>
		<td>PO AMOUNT</td>
		<td>SUPPLIER</td>
		<td>CREATED INFO</td>
		<td>RECEIVED INFO</td>
		<td>CENCELLED INFO</td>
		<td>STATUS</td>
	 </tr>
	  
    <?php
	$www="SELECT * FROM proc_po ORDER BY add_date DESC";
	$s9=mysql_query($www) or die(mysql_error());
	$r9=mysql_fetch_assoc($s9);
	do{
		echo "<tr>";
		echo "<td><a href='podetails.php?po_no=".$r9['po_no']."' target='_blank'>".$r9['po_no']."</a></td>";
		echo "<td class='w3-text-red'>".number_format($r9['po_amount'],2)."</td>";
		
		
		echo "<td>";
		
		$sup=$r9['supplier'];
		$sup_s="SELECT supplier FROM proc_suppliers WHERE id=$sup";
		$sup_q=mysql_query($sup_s) or die(mysql_error());
		$sup_r=mysql_fetch_assoc($sup_q);
		
		echo $sup_r['supplier'];
		
		echo "</td>";		
		
		
		echo "<td>".$r9['add_date']."</td>";
		echo "<td>".$r9['recieved_date']."</td>";
		echo "<td>".$r9['cancelled_date']."</td>";
		echo "<td>";
		
		if($r9['status']==0){ echo "<span class='w3-text-red'>Pending</span>"; }
		else{ echo "<span class='w3-text-green'>PO received</span>";}
		
		echo "</td>";
		echo "</tr>";
	}while($r9=mysql_fetch_assoc($s9));
	?>
	  
	</table>

<?php 
}
//PO List End-----
?>


<?php 
//RFP List Start-----
if(isset($_REQUEST['rfp_list']))
{ ?>
<br>
<form method='get'>
	<input name='procurement' type='hidden' value='1'>
	<input name='rfp_list' type='hidden' value='1'>
	<input required class='btn' name='rfp_no' type='text' placeholder='RFP Number'>
	<input class='btn btn-danger' type='submit' value='CREATE RFP' onclick='return confirm("Create RFP Now?")'>
</form>

	<br>
	<table class='table'>
	  <tr class='w3-dark-gray w3-tiny'>
		<td>RFP NO.</td>
		<td>RFP AMOUNT</td>
		<td>CREATED INFO</td>
		<td>RECEIVED INFO</td>
		<td>CENCELLED INFO</td>
		<td>STATUS</td>
	 </tr>
	  
    <?php
	$s9=mysql_query("select * from proc_rfp") or die(mysql_error());
	$r9=mysql_fetch_assoc($s9);
	do{
		echo "<tr>";
		echo "<td><a href='rfpdetails.php?rfp_no=".$r9['rfp_no']."' target='_blank'>".$r9['rfp_no']."</a></td>";
		echo "<td class='w3-text-red'>".number_format($r9['rfp_amount'],2)."</td>";
		echo "<td>".$r9['add_date']."</td>";
		echo "<td>".$r9['recieved_date']."</td>";
		echo "<td>".$r9['cancelled_date']."</td>";
		echo "<td>".$r9['status']."</td>";
		echo "</tr>";
	}while($r9=mysql_fetch_assoc($s9));
	?>
	  
	</table>

<?php 
}
//RFP List End-----
?>


<?php 
//Add Item Start-----
if(isset($_REQUEST['items']))
{ ?>
<br>
	<table class='table'>
		<tr class='w3-tiny w3-indigo w3-text-white'> 
			<td colspan='8'>ADD ITEMS</td>
		</tr>
		<?php if(isset($_REQUEST['success'])){ ?>
			<tr><td class='w3-text-green'>Add Success!</td></tr>
	    <?php } ?>
		<tr>
			<form method='get' action='script_proc.php'>
			<td><span class='w3-tiny'>Item Name</span><input required class='form-control w3-tiny' name='item' type='text' placeholder='Item Name'></td>
			
			<td>
				<span class='w3-tiny'>Unit</span>
				<select required class='form-control w3-tiny' name='unit'>
				<?php
					$q=mysql_query("SELECT * FROM proc_units ORDER BY unit asc");
					$r=mysql_fetch_assoc($q);
						echo "<option value='' disabled selected>none</option>";
					do{
						echo "<option value='".$r['id']."'>".$r['unit_long']."</option>";
					}while($r=mysql_fetch_assoc($q));
				echo "</select>";	
				?>
			</td>
			
			<td><span class='w3-tiny'>Price</span><input required class='form-control' name='price' type='number' step='any'></td>
			
			<td>
				<span class='w3-tiny'>Supplier</span>
				<select required class='form-control w3-tiny' name='supplier'>
				<?php
					$q=mysql_query("SELECT * FROM proc_suppliers ORDER BY supplier asc");
					$r=mysql_fetch_assoc($q);
						echo "<option value='' disabled selected>none</option>";
					do{
						echo "<option value='".$r['id']."'>".$r['supplier']."</option>";
					}while($r=mysql_fetch_assoc($q));
				echo "</select>";	
				?>
			</td>
			
			<td>
				<span class='w3-tiny'>Main Category</span>
				<select required class='form-control w3-tiny' name='cat_main'>
				<?php
					$q=mysql_query("SELECT * FROM proc_category_main ORDER BY category asc");
					$r=mysql_fetch_assoc($q);
						echo "<option value='' disabled selected>none</option>";
					do{
						echo "<option value='".$r['id']."'>".$r['category']."</option>";
					}while($r=mysql_fetch_assoc($q));
				echo "</select>";	
				?>
			</td>
			
			<td>
				<span class='w3-tiny'>Sub Category</span>
				<select required class='form-control w3-tiny' name='cat_sub'>
				<?php
					$q=mysql_query("SELECT * FROM proc_category_sub ORDER BY category asc");
					$r=mysql_fetch_assoc($q);
						echo "<option value='' disabled selected>none</option>";
					do{
						echo "<option value='".$r['id']."'>".$r['category']."</option>";
					}while($r=mysql_fetch_assoc($q));
				echo "</select>";	
				?>
			</td>
			
			<td>
				<span class='w3-tiny'>Unique Category</span>
				<select required class='form-control w3-tiny' name='cat_unique'>
				<?php
					$q=mysql_query("SELECT * FROM proc_category_unique ORDER BY category asc");
					$r=mysql_fetch_assoc($q);
						echo "<option value='' disabled selected>none</option>";
					do{
						echo "<option value='".$r['id']."'>".$r['category']."</option>";
					}while($r=mysql_fetch_assoc($q));
				echo "</select>";	
				?>
			</td>
			
			<td><span class='w3-tiny'><br></span><input class='btn btn-success w3-tiny' name='add_item' type='submit' value='ADD ITEM' onclick='return confirm("ADD ITEM?")'></td>
			</form>
		</tr>
		<tr><td><td></tr>
		<tr class='w3-tiny w3-dark-gray w3-text-white'> 
			<td colspan='8'>ITEM LIST</td>
		</tr>
		<tr>
			<td colspan='8'>
			<?php
				$q=mysql_query("SELECT p.*, u.unit_long AS unit, s.supplier AS supplier, m.category AS category_main, b.category AS category_sub, o.category AS category_unique
								FROM proc_items AS p
								INNER JOIN proc_units AS u ON u.id=p.unit
								INNER JOIN proc_suppliers AS s ON s.id=p.supplier
								INNER JOIN proc_category_main AS m ON m.id=p.category_main
								INNER JOIN proc_category_sub AS b ON b.id=p.category_sub
								INNER JOIN proc_category_unique AS o ON o.id=p.category_unique
								ORDER BY p.item ASC");
				$r=mysql_fetch_assoc($q);
				echo "<table class='table'>
						<tr class='w3-khaki w3-tiny'>
							<td>#</td>
							<td>ID</td>
							<td>ITEM NAME</td>
							<td>UNIT</td>
							<td>PRICE</td>
							<td>SUPPLIER</td>
							<td>MAIN CATEGORY</td>
							<td>SUB CATEGORY</td>
							<td>UNIQUE CATEGORY</td>
							<td>ADD BY</td>
							<td>ADD DATE</td>
						</tr>";
						$x=1;
				do{
					echo "<tr class='w3-tiny'>
							  <td class='w3-text-orange'>".$x++."</td>
							  <td>".$r['id']."</td>
							  <td>".$r['item']."</td>
							  <td>".$r['unit']."</td>
							  <td>".number_format($r['price'],2)."</td>
							  <td>".$r['supplier']."</td>
							  <td>".$r['category_main']."</td>
							  <td>".$r['category_sub']."</td>
							  <td>".$r['category_unique']."</td>
							  <td>".$r['add_by']."</td>
							  <td>".$r['add_date']."</td>
						  </tr>";
				}while($r=mysql_fetch_assoc($q));
			    echo "</table>";
			?>
			</td>
		</tr>
	</table>
<?php 
}
//Add Item End-----
?>


<?php 
//Add Units Start-----
if(isset($_REQUEST['units']))
{ ?>
<br>
	<table class='table'>
		<tr class='w3-tiny w3-deep-purple w3-text-white'> 
			<td colspan='3'>UNIT OF MEASURE</td>
		</tr>
		<?php if(isset($_REQUEST['success'])){ ?>
			<tr><td class='w3-text-green'>Add Success!</td></tr>
	    <?php } ?>
		<tr>
			<form method='get' action='script_proc.php'>
			<td><input required class='form-control w3-tiny' name='units_long' type='text' placeholder='Add Unit Long Name. Ex. Bottle'></td>
			<td><input required class='form-control w3-tiny' name='units' type='text' placeholder='Add Unit Short Name Ex. Bot'></td>
			<td><input class='btn btn-success w3-tiny' name='add_units' type='submit' value='ADD NEW UNIT' onclick='return confirm("ADD UNIT NOW?")'></td>
			</form>
		</tr>
		<tr><td><td></tr>
		<tr class='w3-tiny w3-dark-gray w3-text-white'> 
			<td>UNIT OF MEASURE</td>
		</tr>
		<tr>
			<td>
			<?php
				$q=mysql_query("SELECT * FROM proc_units ORDER BY unit asc");
				$r=mysql_fetch_assoc($q);
				echo "<table class='table'><tr class='w3-khaki w3-tiny'><td>ID</td><td>UNIT SHORT</td><td>UNIT LONG</td><td>ADD BY</td><td>ADD DATE</td></tr>";
				do{
					echo "<tr class='w3-tiny'><td>".$r['id']."</td><td>".$r['unit']."</td><td>".$r['unit_long']."</td><td>".$r['add_by']."</td><td>".$r['add_date']."</td></tr>";
				}while($r=mysql_fetch_assoc($q));
			    echo "</table>";
			?>
			</td>
		</tr>
	</table>
<?php 
}
//Add Units End-----
?>



<?php 
//Add Category Start-----
if(isset($_REQUEST['category']))
{ ?>
<br>
	<table class='table'>
		<tr class='w3-tiny w3-brown w3-text-white'> 
			<td colspan='3'>CATEGORY NAME</td>
		</tr>
		<?php if(isset($_REQUEST['success'])){ ?>
			<tr><td class='w3-text-green'>Add Success!</td></tr>
	    <?php } ?>
		<tr>
			<form method='get' action='script_proc.php'>
			<td><input required class='form-control w3-tiny' name='cat_main' type='text' placeholder='Main Category Name'></td>
			<td><input class='btn btn-success w3-tiny' name='add_cat_main' type='submit' value='ADD MAIN CATEGORY' onclick='return confirm("ADD MAIN CATEGORY?")'></td>
			</form>
		</tr>
		<tr>
			<form method='get' action='script_proc.php'>
			<td><input required class='form-control w3-tiny' name='cat_sub' type='text' placeholder='Sub Category Name'></td>
			<td><input class='btn btn-success w3-tiny' name='add_cat_sub' type='submit' value='ADD SUB CATEGORY' onclick='return confirm("ADD SUB CATEGORY?")'></td>
			</form>
		</tr>
		<tr>
			<form method='get' action='script_proc.php'>
			<td><input required class='form-control w3-tiny' name='cat_unique' type='text' placeholder='Unique Category Name'></td>
			<td><input class='btn btn-success w3-tiny' name='add_cat_unique' type='submit' value='ADD UNIQUE CATEGORY' onclick='return confirm("ADD UNIQUE CATEGORY?")'></td>
			</form>
		</tr>
		<tr><td><td></tr>
		<tr>
			<td>
			<?php
				$q=mysql_query("SELECT * FROM proc_category_main ORDER BY category asc");
				$r=mysql_fetch_assoc($q);
				echo "<table class='table'><tr class='w3-dark-gray w3-tiny'><td colspan='5'>MAIN CATEGORY</td></tr>
										   <tr class='w3-khaki w3-tiny'><td>ID</td><td>CATEGORY NAME</td><td>ADD BY</td><td colspan='2'>ADD DATE</td></tr>";
				do{
					echo "<tr class='w3-tiny'>
							<td>".$r['id']."</td>
							<td>";
							if(isset($_REQUEST['edit_main']) and $_REQUEST['id']==$r['id'])
							{ ?>
							<form>
							<input name='procurement' type='hidden' value='1'>
							<input name='category' type='hidden' value='1'>
							<input name='id' type='hidden' value='<?php echo $_REQUEST['id']; ?>'>
							<input name='new_main' type='text' value='<?php echo $r['category']; ?>' placeholder='<?php echo $r['category']; ?>'>
							<input class='w3-tiny' type='submit' value='SET'>
							</form>
					  <?php }
					    else{ echo $r['category']; }
					  echo "</td>
							<td>".$r['add_by']."</td>
							<td>".$r['add_date']."</td>
							<td><a class='fa fa-pencil' href='admin_proc.php?procurement=1&category=1&edit_main=1&id=".$r['id']."'></a></td>
						  </tr>";
				}while($r=mysql_fetch_assoc($q));
			    echo "</table>";
			?>
			</td>
			
			<td>
			<?php
				$q=mysql_query("SELECT * FROM proc_category_sub ORDER BY category asc");
				$r=mysql_fetch_assoc($q);
				echo "<table class='table'><tr class='w3-dark-gray w3-tiny'><td colspan='5'>SUB CATEGORY</td></tr>
										   <tr class='w3-khaki w3-tiny'><td>ID</td><td>CATEGORY NAME</td><td>ADD BY</td><td colspan='2'>ADD DATE</td></tr>";
				do{
					echo "<tr class='w3-tiny'>
							<td>".$r['id']."</td>
							<td>";
							if(isset($_REQUEST['edit_sub']) and $_REQUEST['id']==$r['id'])
							{ ?>
							<form>
							<input name='procurement' type='hidden' value='1'>
							<input name='category' type='hidden' value='1'>
							<input name='id' type='hidden' value='<?php echo $_REQUEST['id']; ?>'>
							<input name='new_sub' type='text' value='<?php echo $r['category']; ?>' placeholder='<?php echo $r['category']; ?>'>
							<input class='w3-tiny' type='submit' value='SET'>
							</form>
					  <?php }
					    else{ echo $r['category']; }
					  echo "</td>
							<td>".$r['add_by']."</td>
							<td>".$r['add_date']."</td>
							<td><a class='fa fa-pencil' href='admin_proc.php?procurement=1&category=1&edit_sub=1&id=".$r['id']."'></a></td>
						  </tr>";
				}while($r=mysql_fetch_assoc($q));
			    echo "</table>";
			?>
			</td>
			
			<td>
			<?php
				$q=mysql_query("SELECT * FROM proc_category_unique ORDER BY category asc");
				$r=mysql_fetch_assoc($q);
				echo "<table class='table'><tr class='w3-dark-gray w3-tiny'><td colspan='5'>UNIQUE CATEGORY</td></tr>
										   <tr class='w3-khaki w3-tiny'><td>ID</td><td>CATEGORY NAME</td><td>ADD BY</td><td colspan='2'>ADD DATE</td></tr>";
				do{
					echo "<tr class='w3-tiny'>
							<td>".$r['id']."</td>
							<td>";
							if(isset($_REQUEST['edit_unique']) and $_REQUEST['id']==$r['id'])
							{ ?>
							<form>
							<input name='procurement' type='hidden' value='1'>
							<input name='category' type='hidden' value='1'>
							<input name='id' type='hidden' value='<?php echo $_REQUEST['id']; ?>'>
							<input name='new_unique' type='text' value='<?php echo $r['category']; ?>' placeholder='<?php echo $r['category']; ?>'>
							<input class='w3-tiny' type='submit' value='SET'>
							</form>
					  <?php }
					    else{ echo $r['category']; }
					  echo "</td>
							<td>".$r['add_by']."</td>
							<td>".$r['add_date']."</td>
							<td><a class='fa fa-pencil' href='admin_proc.php?procurement=1&category=1&edit_unique=1&id=".$r['id']."'></a></td>
						 </tr>";
				}while($r=mysql_fetch_assoc($q));
			    echo "</table>";
			?>
			</td>
		</tr>
	</table>
<?php 
}
//Add Category End-----
?>


<?php 
//Add Suppliers Start-----
if(isset($_REQUEST['suppliers']))
{ ?>
<br>
	<table class='table'>
		<tr class='w3-tiny w3-teal w3-text-white'> 
			<td colspan='5'>SUPPLIERS</td>
		</tr>
		<?php if(isset($_REQUEST['success'])){ ?>
			<tr><td class='w3-text-green'>Add Success!</td></tr>
	    <?php } ?>
		<tr>
			<form method='get' action='script_proc.php'>
			<td><input required class='form-control w3-tiny' name='supplier' type='text' placeholder='Supplier Name'></td>
			<td><input required class='form-control w3-tiny' name='address' type='text' placeholder='Address'></td>
			<td><input required class='form-control w3-tiny' name='contact' type='text' placeholder='Contacts'></td>
			<td><input required class='form-control w3-tiny' name='email' type='text' placeholder='Email'></td>
			<td><input class='btn btn-success w3-tiny' name='add_supplier' type='submit' value='ADD SUPPLIER' onclick='return confirm("ADD SUPPLIER?")'></td>
			</form>
		</tr>
		<tr><td><td></tr>
		<tr class='w3-tiny w3-dark-gray w3-text-white'> 
			<td colspan='7'>SUPPLIERS LIST</td>
		</tr>
		<tr>
			<td colspan='7'>
			<?php
				$q=mysql_query("SELECT * FROM proc_suppliers ORDER BY supplier asc");
				$r=mysql_fetch_assoc($q);
				echo "<table class='table'><tr class='w3-khaki w3-tiny'><td>ID</td><td>SUPPLIER NAME</td><td>ADDRESS</td><td>CONTACT</td><td>EMAIL</td><td>ADD BY</td><td>ADD DATE</td></tr>";
				do{
					echo "<tr class='w3-tiny'><td>".$r['id']."</td>
							  <td>".$r['supplier']."</td>
							  <td>".$r['address']."</td>
							  <td>".$r['contact']."</td>
							  <td>".$r['email']."</td>
							  <td>".$r['add_by']."</td>
							  <td>".$r['add_date']."</td>
						  </tr>";
				}while($r=mysql_fetch_assoc($q));
			    echo "</table>";
			?>
			</td>
		</tr>
	</table>
<?php 
}
//Add Suppliers End-----
?>

<?php 
//Add Cargo Forwarder Start-----
if(isset($_REQUEST['cargo']))
{ ?>
<br>
	<table class='table'>
		<tr class='w3-tiny w3-teal w3-text-white'> 
			<td colspan='5'>CARGO FORWARDER</td>
		</tr>
		<?php if(isset($_REQUEST['success'])){ ?>
			<tr><td class='w3-text-green'>Add Success!</td></tr>
	    <?php } ?>
		<tr>
			<form method='get' action='script_proc.php'>
			<td><input required class='form-control w3-tiny' name='cargo' type='text' placeholder='Cargo Forwarder Name'></td>
			<td><input required class='form-control w3-tiny' name='address' type='text' placeholder='Address'></td>
			<td><input required class='form-control w3-tiny' name='contact' type='text' placeholder='Contacts'></td>
			<td><input required class='form-control w3-tiny' name='email' type='text' placeholder='Email'></td>
			<td><input class='btn btn-success w3-tiny' name='add_cargo' type='submit' value='ADD CARGO FORWARDER' onclick='return confirm("ADD CARGO FORWARDER?")'></td>
			</form>
		</tr>
		<tr><td><td></tr>
		<tr class='w3-tiny w3-dark-gray w3-text-white'> 
			<td colspan='7'>CARGO FORWARDER LIST</td>
		</tr>
		<tr>
			<td colspan='7'>
			<?php
				$q=mysql_query("SELECT * FROM proc_cargo ORDER BY cargo asc");
				$r=mysql_fetch_assoc($q);
				echo "<table class='table'><tr class='w3-khaki w3-tiny'><td>ID</td><td>CARGO FORWARDER NAME</td><td>ADDRESS</td><td>CONTACT</td><td>EMAIL</td><td>ADD BY</td><td>ADD DATE</td></tr>";
				do{
					echo "<tr class='w3-tiny'><td>".$r['id']."</td>
							  <td>".$r['cargo']."</td>
							  <td>".$r['address']."</td>
							  <td>".$r['contact']."</td>
							  <td>".$r['email']."</td>
							  <td>".$r['add_by']."</td>
							  <td>".$r['add_date']."</td>
						  </tr>";
				}while($r=mysql_fetch_assoc($q));
			    echo "</table>";
			?>
			</td>
		</tr>
	</table>
<?php 
}
//Add Cargo Forwarder End-----
?>

<?php 
//Add Terms Start-----
if(isset($_REQUEST['terms']))
{ ?>
<br>
	<table class='table'>
		<tr class='w3-tiny w3-deep-purple w3-text-white'> 
			<td colspan='3'>UNIT OF MEASURE</td>
		</tr>
		<?php if(isset($_REQUEST['success'])){ ?>
			<tr><td class='w3-text-green'>Add Success!</td></tr>
	    <?php } ?>
		<tr>
			<form method='get' action='script_proc.php'>
			<td><input required class='form-control w3-tiny' name='terms_desc' type='text' placeholder='Add Term Long Name'></td>
			<td><input required class='form-control w3-tiny' name='terms' type='number'></td>
			<td><input class='btn btn-success w3-tiny' name='add_terms' type='submit' value='ADD NEW UNIT' onclick='return confirm("ADD TERM NOW?")'></td>
			</form>
		</tr>
		<tr><td><td></tr>
		<tr class='w3-tiny w3-dark-gray w3-text-white'> 
			<td>TERMS</td>
		</tr>
		<tr>
			<td>
			<?php
				$q=mysql_query("SELECT * FROM proc_terms ORDER BY terms asc");
				$r=mysql_fetch_assoc($q);
				echo "<table class='table'>
						<tr class='w3-khaki w3-tiny'>
							<td>ID</td>
							<td>TERMS</td>
							<td>DESCRIPTION</td>
							<td>ADD BY</td>
							<td>ADD DATE</td>
						</tr>";
				do{
					echo "<tr class='w3-tiny'><td>".$r['id']."</td><td>".$r['terms']."</td><td>".$r['terms_desc']."</td><td>".$r['add_by']."</td><td>".$r['add_date']."</td></tr>";
				}while($r=mysql_fetch_assoc($q));
			    echo "</table>";
			?>
			</td>
		</tr>
	</table>
<?php 
}
//Add Terms End-----
?>


<?php
//Reports Start
if(isset($_REQUEST['reports']))
{
	$s="select count(a.item) as item_count, b.item 
	from proc_po_details a 
	join proc_items b
		on a.item=b.id
	group by b.item
	order by item_count desc
	limit 20";
	$q=mysql_query($s) or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	
	echo "<table border='1'>
			<tr><td colspan='2'>TOP 20 Most Purchased Items</td></tr>
			<tr>
				<td>COUNT</td>
				<td>ITEM DESCRIPTION</td>
			</tr>";
	
	do{	
	echo "<tr><td>".$r['item_count']."</td><td>".$r['item']."</td></tr>";
	
	}while($r=mysql_fetch_assoc($q));
	
	echo "</table>";
}


//Reports End
?>



<?php } ?>
<!--Procurement End-------->

 </div>

</div>
</body>
</html>

<script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}
</script>  

