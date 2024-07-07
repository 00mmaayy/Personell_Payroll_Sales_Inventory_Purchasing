<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
include("css.php");


if(isset($_REQUEST['print_id']))
{
	$id=$_REQUEST['print_id'];
	mysql_query("update inv_mr set print_specific=1 where id='$id'") or die(mysql_error());
	header('Location: inv_mr.php?e_no='.$_REQUEST['e_no'].'&e_lname='.$_REQUEST['e_lname'].'&e_fname='.$_REQUEST['e_fname'].'&view_asset=SHOW+ASSIGNED+ASSET');
}
if(isset($_REQUEST['remove_print_id']))
{
	$id=$_REQUEST['remove_print_id'];
	mysql_query("update inv_mr set print_specific=0 where id='$id'") or die(mysql_error());
	header('Location: inv_mr.php?e_no='.$_REQUEST['e_no'].'&e_lname='.$_REQUEST['e_lname'].'&e_fname='.$_REQUEST['e_fname'].'&view_asset=SHOW+ASSIGNED+ASSET');
}


if(isset($_REQUEST['update_asset']))
{
	$id=$_REQUEST['id'];
	if(isset($_REQUEST['desc']))
	{
		$desc=$_REQUEST['desc'];
		mysql_query("update inv_mr set description='$desc' where id=$id") or die(mysql_error());
	}

	if(isset($_REQUEST['remarks']))
	{
		$remarks=$_REQUEST['remarks'];
		mysql_query("update inv_mr set remarks='$remarks' where id=$id") or die(mysql_error());
	}
	
	if(isset($_REQUEST['acquisition']))
	{
		$acquisition=$_REQUEST['acquisition'];
		mysql_query("update inv_mr set acquisition_cost='$acquisition' where id=$id") or die(mysql_error());
	}
		
	header('Location: inv_mr.php?view_all_asset=SHOW+LIST+OF+ALL+ASSET');
}


if(isset($_REQUEST['assign_mr']))
{	
	$serial_no=$_REQUEST['serial_no'];
	$asset_type=$_REQUEST['asset_type'];
	$branch=$_REQUEST['branch'];
	$machine=$_REQUEST['machine'];
	$description=$_REQUEST['description'];
	$department=$_REQUEST['department'];
	$no_of_units=$_REQUEST['no_of_units'];
	$acquisition_cost=$_REQUEST['acquisition_cost'];
	$acquisition_date=$_REQUEST['acquisition_date'];
	$remarks=$_REQUEST['remarks'];
	$e_no=$_REQUEST['e_no'];

	$s="insert into inv_mr (e_no,serial_no,asset_type,description,machine,branch,department,no_of_units,acquisition_date,acquisition_cost,remarks,add_date,add_time) 
		values ('$e_no','$serial_no','$asset_type','$description','$machine','$branch','$department','$no_of_units','$acquisition_date','$acquisition_cost','$remarks',curdate(),curtime())";
	$q=mysql_query($s) or die(mysql_error());

	header('Location: inv_mr.php?success=1&add_asset=1&e_no='.$_REQUEST['e_no'].'&e_lname='.$_REQUEST['e_lname'].'&e_fname='.$_REQUEST['e_fname']);
}
?>

<div class='container'>

	<br/>
		<table>
			<tr valign='top'>
				<td>
					<input class='btn w3-pale-blue' type="text" placeholder='Search Name' id="search" name="search"  onkeyup="showHint('x')"/>
					<div id="view_result"></div>
				</td>
				<td width='20'></td>
				<td>
					<form>
						<input name='view_all_asset' type='submit' class='btn w3-blue' value='SHOW LIST OF ALL ASSET'> 
					</form>
				</td>
				<td width='20'></td>
				<td>
					<form>
						<input name='e_no' type='hidden' value='Damaged'>
						<input type='submit' class='btn w3-blue' value='SHOW LIST OF ALL DAMAGED ASSETS'> 
					</form>
				</td>
			</tr>
		</table>	
			
		<hr/>
		<?php if(isset($_REQUEST['e_no']))
		        { 
					if($_REQUEST['e_no']!='Damaged')
					{ echo "Assign to:<br><b class='w3-xlarge w3-text-blue'>".$_REQUEST['e_lname'].", ".$_REQUEST['e_fname']."</b>"; }
					else { echo "Items with Status:<br><b class='w3-xlarge w3-text-red'>Damaged</b>"; } 
					echo "<hr/>"; ?>
					
					<table>
					 <tr>
					  <td>
					  
						<?php if($_REQUEST['e_no']!='Damaged'){ ?>
						<form>
							<input name='e_no' type='hidden' value='<?php echo $_REQUEST['e_no']; ?>'>
							<input name='e_lname' type='hidden' value='<?php echo $_REQUEST['e_lname']; ?>'>
							<input name='e_fname' type='hidden' value='<?php echo $_REQUEST['e_fname']; ?>'>
							<input name='add_asset' type='submit' class='btn w3-blue w3-tiny' value='ASSIGN ASSET'> 
						</form>
						<?php } else {} ?>

					 </td>
					  <td>&nbsp;&nbsp;</td>
					  <td>		
						<form>
							<input name='e_no' type='hidden' value='<?php echo $_REQUEST['e_no']; ?>'>
							<input name='e_lname' type='hidden' value='<?php echo $_REQUEST['e_lname']; ?>'>
							<input name='e_fname' type='hidden' value='<?php echo $_REQUEST['e_fname']; ?>'>
							<input name='view_asset' type='submit' class='btn w3-blue w3-tiny' value='SHOW ASSIGNED ASSET'> 
						</form>
					  </td>
					  <td>&nbsp;&nbsp;</td>
					  <td>		
						<form method='get' action='inv_print_asset.php' target='_blank'>
							<input name='e_no' type='hidden' value='<?php echo $_REQUEST['e_no']; ?>'>
							<input name='e_lname' type='hidden' value='<?php echo $_REQUEST['e_lname']; ?>'>
							<input name='e_fname' type='hidden' value='<?php echo $_REQUEST['e_fname']; ?>'>
							<input name='print_asset_all' type='submit' class='btn w3-blue w3-tiny' value='PRINT ALL ASSIGNED ASSET'> 
							<input name='print_asset_specific' type='submit' class='btn w3-blue w3-tiny' value='PRINT SPECIFIC ASSIGNED ASSET'> 
						</form>
					  </td>
					 </tr>
					</table>		
						
				<?php if(isset($_REQUEST['success']))
					  { echo "&nbsp;&nbsp;&nbsp;<b class='w3-xlarge w3-text-green'><i>Asset Assignment Success!</i></b>"; }
				
				} ?>
		
	<?php //ADD ASSET FIELD START 
	if(isset($_REQUEST['add_asset'])){ ?>	
	<hr/>
	<form>
		<table>
			<tr>
				<td><input required class='btn w3-light-gray' name='serial_no' type='text'>&nbsp;&nbsp;&nbsp;Serial No<br><br></td>
				<td width='20'></td>
				<td><input required class='btn w3-light-gray' name='asset_type' type='text'>&nbsp;&nbsp;&nbsp;Asset Type<br><br></td>
				<td width='20'></td>
				<td>
					<?php $sx32=mysql_query("select company from company order by company asc") or die(mysql_error()); 
						  $rx32=mysql_fetch_assoc($sx32);
						  
						  echo "<select required class='btn w3-light-gray' name='branch'>
									<option></option>";
						  do{
							echo "<option>".$rx32['company']."</option>";
						  }while($rx32=mysql_fetch_assoc($sx32));
						  echo "</select>";
					?> &nbsp;&nbsp;&nbsp;Branch<br><br>
				</td>
			</tr>
			<tr>
				<td><input required class='btn w3-light-gray' name='machine' type='text'>&nbsp;&nbsp;&nbsp;Machine<br><br></td>
				<td width='20'></td>
				<td>
					<input required class='btn w3-light-gray' name='description' type='text'>&nbsp;&nbsp;&nbsp;Description<br><br>
				</td>
				<td width='20'></td>
				<td>
					<?php $sx32=mysql_query("select dept_name from departments order by dept_name asc") or die(mysql_error()); 
						  $rx32=mysql_fetch_assoc($sx32);
						  
						  echo "<select required class='btn w3-light-gray' name='department'>
									<option></option>";
						  do{
							echo "<option>".$rx32['dept_name']."</option>";
						  }while($rx32=mysql_fetch_assoc($sx32));
						  echo "</select>";
					?> &nbsp;&nbsp;&nbsp;Department<br><br>
				</td>
			</tr>
			<tr>
				<td><input required class='btn w3-light-gray' name='no_of_units' type='number'>&nbsp;&nbsp;&nbsp;No of Units<br><br></td>
				<td width='20'></td>
				<td><input required class='btn w3-light-gray' name='acquisition_cost' type='number' step='any'>&nbsp;&nbsp;&nbsp;Acquisition Cost<br><br></td>
				<td width='20'></td>
				<td><input required class='btn w3-light-gray' name='acquisition_date' type='date'>&nbsp;&nbsp;&nbsp;Acquisition Date<br><br></td>
			</tr>
			<tr>
				<td colspan='5'>
					<textarea placeholder='Remarks' required rows='4' cols='300' name='remarks' class='form-control'></textarea><br>
				</td>
				<td width='20'></td>
			</tr>
			<tr>
				<input name='e_no' type='hidden' value='<?php echo $_REQUEST['e_no']; ?>'>
				<input name='e_lname' type='hidden' value='<?php echo $_REQUEST['e_lname']; ?>'>
				<input name='e_fname' type='hidden' value='<?php echo $_REQUEST['e_fname']; ?>'>
				<td colspan='5' align='center'><input name='assign_mr' class='btn w3-blue' type='submit' value='SUBMIT' onclick='return confirm("Sure Submit?")'><br><br></td>
			</tr>
		</table>	
	</form>
	<?php } // ADD ASSET FIELD END
	
	
	
	//VIEW ASSET FIELD PER EMPLOYEE START 
	if(isset($_REQUEST['view_asset']))
	{
		$e_no=$_REQUEST['e_no'];
		$sas=mysql_query("select * from inv_mr where e_no='$e_no'") or die(mysql_error());
		$rar=mysql_fetch_assoc($sas);
		
		echo "<table border='1' class='table'>
				<tr class='w3-tiny w3-green' align='center'>
					<td>SERIAL NO</td>
					<td>ASSET TYPE</td>
					<td>DESCRIPTION</td>
					<td>MACHINE</td>
					<td>BRANCH</td>
					<td>DEPARTMENT</td>
					<td>NO OF UNITS</td>
					<td>ACQUISITION COST</td>
					<td>ACQUISITION DATE</td>
					<td>REMARKS</td>
					<td>PRINT<br/>SPECIFIC</td>
					<td>TRANSFER<br/>ASSET</td>
					<td>TRANSFER<br/>History</td>
				</tr>";
		do{
			echo "<tr class='w3-tiny'>
					<td>".$rar['serial_no']."</td>
					<td>".$rar['asset_type']."</td>
					<td>".$rar['description']."</td>
					<td>".$rar['machine']."</td>
					<td>".$rar['branch']."</td>
					<td>".$rar['department']."</td>
					<td align='center'>".$rar['no_of_units']."</td>
					<td align='right'>".number_format($rar['acquisition_cost'],2)."</td>
					<td align='right'>".date('F d, Y',strtotime($rar['acquisition_date']))."</td>
					<td>".$rar['remarks']."</td>
					<td>";
						
						if($rar['print_specific']==0){
						echo "<a class='fa fa-plus fa-fw' href='inv_mr.php?e_no=".$_REQUEST['e_no']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']."&view_asset=1&print_id=".$rar['id']."'></a>&nbsp;";
						}
						else{
						echo "<a class='fa fa-check fa-fw w3-text-red' href='inv_mr.php?e_no=".$_REQUEST['e_no']."&e_lname=".$_REQUEST['e_lname']."&e_fname=".$_REQUEST['e_fname']."&view_asset=1&remove_print_id=".$rar['id']."'></a>&nbsp;";
						}
			  echo "</td>
					<td><i><a href='inv_transfer_asset.php?transfer=1&id=".$rar['id']."&e_no=".$_REQUEST['e_no']."&view_asset=SHOW+ASSIGNED+ASSET' target='_blank'>Transfer</a></i></td>
					<td><i><a href='inv_transfer_asset.php?transfer_log=1&id=".$rar['id']."&e_no=".$_REQUEST['e_no']."&view_asset=SHOW+ASSIGNED+ASSET' target='_blank'>View</a></i></td>";
			 echo "</tr>";
		} while($rar=mysql_fetch_assoc($sas));
		echo "</table>";
		
	} //VIEW ASSET FIELD PER EMPLOYEE END

	
	
	//VIEW ALL ASSET START
	if(isset($_REQUEST['view_all_asset']))
	{
	    $sas=mysql_query("select a.id as id,
								a.e_no as e_no,
								a.serial_no as serial_no, 
								a.asset_type as asset_type,
								a.description as description,
								a.machine as machine,
								a.branch as branch,
								a.department as department,
								a.no_of_units as no_of_units,
								a.acquisition_cost as acquisition_cost,
								a.acquisition_date as acquisition_date,
								a.remarks as remarks,
								b.e_lname as e_lname,
								b.e_fname as e_fname
								from inv_mr as a
								inner join employee as b
								on a.e_no=b.e_no
								order by e_lname asc
								") or die(mysql_error());
		$rar=mysql_fetch_assoc($sas);
		
		echo "<table border='1' class='table'>
				<tr class='w3-tiny w3-green' align='center'>
					<td>ASSIGNED TO</td>
					<td>SERIAL NO</td>
					<td>ASSET TYPE</td>
					<td>DESCRIPTION</td>
					<td>MACHINE</td>
					<td>BRANCH</td>
					<td>DEPARTMENT</td>
					<td>NO OF UNITS</td>
					<td>ACQUISITION COST</td>
					<td>ACQUISITION DATE</td>
					<td>REMARKS</td>
				</tr>";
		do{
			echo "<tr class='w3-tiny'>
				
					<td><b>".$rar['e_lname'].", ".$rar['e_fname']."</b></td>
			  	    <td>".$rar['serial_no']."</td>
					<td>".$rar['asset_type']."</td>
					<td align='right'>";
					if(isset($_REQUEST['desc']) and $rar['id']==$_REQUEST['id']){ ?>
					<form method='get'>
					<input name='view_all_asset' type='hidden' value='1'>
					<input name='id' type='hidden' value='<?php echo $rar['id']; ?>'>
					<input name='desc' type='text' value='<?php echo $rar['description']; ?>'><br>
					<input name='update_asset' type='submit' value='UPDATE' onclick='return confirm("Sure Update?")'>
					</form><?php }
					else{ echo $rar['description']." &nbsp;<a class='fa fa-pencil fa-fw' href='inv_mr.php?id=".$rar['id']."&view_all_asset=1&desc=1'></a>"; }
			  echo "</td>";
					
			  echo "<td>".$rar['machine']."</td>
					<td>".$rar['branch']."</td>
					<td>".$rar['department']."</td>
					<td align='center'>".$rar['no_of_units']."</td>";
				
			  echo "<td align='right'>";
					if(isset($_REQUEST['acquisition']) and $rar['id']==$_REQUEST['id']){ ?>
					<form method='get'>
					<input name='view_all_asset' type='hidden' value='1'>
					<input name='id' type='hidden' value='<?php echo $rar['id']; ?>'>
					<input name='acquisition' type='number' value='<?php echo $rar['acquisition_cost']; ?>' step='any'><br>
					<input name='update_asset' type='submit' value='UPDATE' onclick='return confirm("Sure Update?")'>
					</form><?php }
					else{ echo number_format($rar['acquisition_cost'],2)." &nbsp;<a class='fa fa-pencil fa-fw' href='inv_mr.php?id=".$rar['id']."&view_all_asset=1&acquisition=1'></a>"; }
			  echo "</td>";
					
					
			  echo "<td align='right'>".date('F d, Y',strtotime($rar['acquisition_date']))."</td>
			  
					<td align='right'>";
					if(isset($_REQUEST['remarks']) and $rar['id']==$_REQUEST['id']){ ?>
					<form method='get'>
					<input name='view_all_asset' type='hidden' value='1'>
					<input name='id' type='hidden' value='<?php echo $rar['id']; ?>'>
					<input name='remarks' type='text' value='<?php echo $rar['remarks']; ?>'><br>
					<input name='update_asset' type='submit' value='UPDATE' onclick='return confirm("Sure Update?")'>
					</form><?php }
					else{ echo $rar['remarks']." &nbsp;<a class='fa fa-pencil fa-fw' href='inv_mr.php?id=".$rar['id']."&view_all_asset=1&remarks=1'></a>"; }
			  echo "</td>";
					  
		  echo "</tr>";
		} while($rar=mysql_fetch_assoc($sas));
		echo "</table>";
		
	} //VIEW ASSET FIELD END ?>
	
</div>	
