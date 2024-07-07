<?php 
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/leaves.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>


<div class='container col-xs-6'>
<?php
if(isset($_REQUEST['add_leave_details']))
  {
	$e_no=$_REQUEST['e_no'];
	$type=$_REQUEST['type'];
	$pay_status=$_REQUEST['pay_status'];
	$days=$_REQUEST['days'];
	$remarks=$_REQUEST['remarks'];
	$sdate=$_REQUEST['sdate'];
	$edate=$_REQUEST['edate'];
	$deduct_to = $_REQUEST['deduct_to'];
	mysql_query("insert into employee_leaves (e_no,type,days,remarks,sdate,edate,apply_date,pay_status) values ('$e_no','$type','$days','$remarks','$sdate','$edate',now(),'$pay_status')") or die(mysql_error());
    
	$username=$_SESSION['username'];
	$trans="add leave to $e_no sdate $sdate edate $edate";
    $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
    $log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('Location: script_leaves.php?e_no='.$_REQUEST['e_no'].'&create_leave=CREATE+LEAVE&success=1&'.$_REQUEST['name']);
  }
  
  
if(isset($_REQUEST['edit_leave_details']))
  {
	$id=$_REQUEST['id'];  
	$e_no=$_REQUEST['e_no'];
	$type=$_REQUEST['type'];
	$days=$_REQUEST['days'];
	$remarks=$_REQUEST['remarks'];
	$sdate=$_REQUEST['sdate'];
	$edate=$_REQUEST['edate'];
	$s="update employee_leaves set type='$type', days='$days', remarks='$remarks' ,sdate='$sdate', edate='$edate' where e_no='$e_no' and id='$id'";
	echo $s;
	mysql_query($s) or die(mysql_error());
    
	$username=$_SESSION['username'];
	$trans="edit leave to $e_no sdate $sdate edate $edate";
    $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
    $log_query=mysql_query($log_sql) or die(mysql_error());
	
	header('Location: script_leaves.php?e_no='.$_REQUEST['e_no'].'&leave_history=CREATE+LEAVE&success=1');
  }  

//ADD NEW LEAVE PER EMPLOYEE
if(isset($_REQUEST['create_leave']))
  { 
	echo "<br>";
	$e_no=$_REQUEST['e_no'];
	
	$sl=5; $vl=5; $spl=7;
	$year=date('Y')."-01-01";
	
	$select_vl = mysql_query("SELECT sum(days) AS days_total FROM employee_leaves WHERE e_no='$e_no' AND pay_status='withpay' AND sdate>='$year' AND type = 'Vacation Leave'");
	$result_vl = mysql_fetch_assoc($select_vl);
	$select_sl = mysql_query("SELECT sum(days) AS days_total FROM employee_leaves WHERE e_no='$e_no' AND pay_status='withpay' AND sdate>='$year' AND type = 'Sick Leave'");
	$result_sl = mysql_fetch_assoc($select_sl);

	
	if(isset($_REQUEST['success'])){ echo "<b class='w3-text-green w3-xxlarge'>Add Leave Success!!!</b>"; }
	echo "<table class='table' border='1'>";
	echo "<tr class='w3-dark-gray'><td colspan='2'>ADD LEAVE DETAILS<br>".$_REQUEST['name']."</td></tr>";
	echo "<tr><td>VL REMAINING: <b class='w3-text-red'>".($vl-$result_vl['days_total'])."</b></td><td>SL REMAINING: <b class='w3-text-red'>".($sl-$result_sl['days_total'])."</b></td></tr>";
	echo "<tr>
			<td>Leave Type</td>
			<form method='get'>
			<input name='e_no' type='hidden' value='".$_REQUEST['e_no']."'>
			<td>
			   <select class='form-control' required name='type'>
					<option></option>
					<option>Vacation Leave</option>
					<option>Sick Leave</option>
					<option>Solo Parent Leave</option>
					<option>Maternity Leave</option>
					<option>Paternity Leave</option>
					<option>Emergency Leave</option>
					<option>Others</option>
				</select>
			</td>
		  </tr>";
	echo "<tr>
			<td>Pay Status</td>
			<td>
				<select class='form-control' required name='pay_status'>
					<option></option>
					<option value='nopay'>No Pay</option>
					<option  value='withpay'>With Pay</option>
				</select>
			</td>
			</tr>";	  
	echo "<tr>
			<td>No. of Days</td>
			<td><input class='form-control' required name='days' type='number' step='any'></td>
		  </tr>";
	echo "<tr>
			<td>Reason / Remarks</td>
			<td><input class='form-control' required name='remarks' type='text'></td>
		  </tr>";
    echo "<tr>
			<td>Leave Start Date</td>
			<td><input class='form-control' required name='sdate' type='date'></td>
		  </tr>";		  
    echo "<tr>
			<td>Leave End Date</td>
			<td><input class='form-control' required name='edate' type='date'></td>
		  </tr>";
    echo "<tr align='center'>
			<td colspan='2'>"; ?>
				<input name='add_leave_details' class='btn-info form-control' type='submit' value='SUBMIT' onclick='return confirm("Add Leave Now?")'>
			</form>	
<?php echo "</td>
		  </tr>";		  
    echo "</table>"; ?>
	<div align='center'>
		<a class='w3-xxlarge' href="javascript:window.open('','_self').close();">X</a>
	</div>

<?php 
   } 


if(isset($_REQUEST['edit_leave']))
  { 
	$id=$_REQUEST['id'];
	$e_no=$_REQUEST['e_no'];
	$q=mysql_query("select * from employee_leaves where e_no='$e_no' and id=$id") or die(mysql_error());
	$r=mysql_fetch_assoc($q);
	echo "<br>";
	if(isset($_REQUEST['success'])){ echo "<b class='w3-text-green w3-xxlarge'>Add Leave Success!!!</b>"; }
	echo "<table class='table' border='1'>";
	echo "<tr class='w3-dark-gray'><td colspan='2'>EDIT LEAVE DETAILS<br>".$_REQUEST['name']."</td></tr>";
	echo "<tr>
			<td>Leave Type</td>
			<form method='get'>
			<input name='e_no' type='hidden' value='".$_REQUEST['e_no']."'>
			<input name='id' type='hidden' value='".$_REQUEST['id']."'>
			<td>
			   <select class='form-control' required name='type'>
					<option>".$r['type']."</option>
					<option></option>
					<option>Vacation Leave</option>
					<option>Sick Leave</option>
					<option>Solo Parent Leave</option>
					<option>Maternity Leave</option>
					<option>Paternity Leave</option>
					<option>Emergency Leave</option>
					<option>Others</option>
				</select>
			</td>
		  </tr>";
	echo "<tr>
			<td>No. of Days</td>
			<td><input class='form-control' required name='days' type='number' step='any' value='".$r['days']."'></td>
		  </tr>";
	echo "<tr>
			<td>Reason / Remarks</td>
			<td><input class='form-control' required name='remarks' type='text' value='".$r['remarks']."'></td>
		  </tr>";
    echo "<tr>
			<td>Leave Start Date</td>
			<td><input class='form-control' required name='sdate' type='date' value='".$r['sdate']."'></td>
		  </tr>";		  
    echo "<tr>
			<td>Leave End Date</td>
			<td><input class='form-control' required name='edate' type='date' value='".$r['edate']."'></td>
		  </tr>";
    echo "<tr align='center'>
			<td colspan='2'>"; ?>
				<input name='edit_leave_details' class='btn-info form-control' type='submit' value='SUBMIT' onclick='return confirm("Edit Leave Now?")'>
			</form>	
<?php echo "</td>
		  </tr>";		  
    echo "</table>"; ?>
	<div align='center'><a class='w3-xxlarge' href="javascript:window.open('','_self').close();">X</a></div>

<?php 
   } 
?>

</div>
	 <!-- LEAVE HISTORY -->
		<div class='container'>
				<?php if(isset($_REQUEST['leave_history'])): ?>
					<br />
					
					<?php 
						//LEAVE EDIT SUCCESS STATUS
							if(isset($_REQUEST['success'])){ echo "<b class='w3-text-green w3-xxlarge'>Edit Leave Success!!!</b>"; }

						$e_no=$_REQUEST['e_no'];
						$q=mysql_query("select * from employee_leaves where e_no='$e_no' order by apply_date desc") or die(mysql_error());
						$r=mysql_fetch_assoc($q);
					?>
					<table class='table' border='1'>
						<tr class='w3-dark-gray'>
							<td colspan='6'>LEAVE HISTORY<br />
								<?php echo $_REQUEST['name']?>
							</td>
						</tr>
						<tr>
								<td>Leave Type</td>
								<td>No. of Days</td>
								<td>Reason / Remarks</td>
								<td>Leave Start Date</td>
								<td>Leave End Date</td>
								<td>APPLICATION DATE</td>
							</tr>
						
						<?php do{	?>
						<tr>
							<td>
								<a href='script_leaves.php?e_no=<?php echo $_REQUEST['e_no']."&id=".$r['id']."&name=".$_REQUEST['name']?>&edit_leave=1'><i class='fa fa-pencil w3-large'> </i></a>&nbsp;<?php echo $r['type']; ?>
							</td>
							<td><?php echo $r['days'] ?></td>
							<td><?php echo $r['remarks'] ?></td>
							<td><?php echo date('m/d/Y',strtotime($r['sdate'])) ?></td>
							<td><?php echo date('m/d/Y',strtotime($r['edate'])) ?></td>
							<td><?php echo date('h:i:s A m/d/Y',strtotime($r['apply_date'])) ?></td>
						</tr>
						<?php	}while($r=mysql_fetch_assoc($q)); ?>
					</table>
					<div align='center'><a class='w3-xxlarge' href="javascript:window.open('','_self').close();">X</a></div>
					
					<!-- LEAVE TRACKER -->
					<?php 
						$leave_year = 2019;
						$entry = $_REQUEST['hired'];
						$entry_year = date('Y',strtotime($entry));
						$number_years = ((int)date('Y')) - $entry_year;
						$year_of_service = strtotime(date("Y-m-d")) - strtotime($entry);
						$leaves = array();

						$prev_year_vl = 0;
						$prev_year_sl = 0;
						if($number_years > 4)
						{
							$loyalty = floor($number_years/5);
						}
						else
						{
							$loyalty = 0;
						}

						if(($year_of_service/31536000) < 1) {
							$rem_vl = 0;
							$rem_sl = 0;
						} else {
							$rem_vl = 5;
							$rem_sl = 5;
						}
						
						for($leave_year; $leave_year <= 2020; $leave_year++)
						{
							
							$date_leave_start = $leave_year . "-01-01";
							$date_leave_end = $leave_year . "-12-31";

							//VACATION LEAVE
								//VL WITH PAY
									$select_vl_wp = mysql_query("SELECT sum(days) as days_vl_wp FROM employee_leaves 
																						WHERE sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND pay_status='withpay' AND e_no='$e_no' AND type='Vacation Leave'");
									$result_vl_wp = mysql_fetch_assoc($select_vl_wp);
								//VL WITHOUT PAY
									$select_vl_np = mysql_query("SELECT sum(days) as days_vl_np FROM employee_leaves 
																						WHERE sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND pay_status='nopay' AND e_no='$e_no' AND type='Vacation Leave'");
									$result_vl_np = mysql_fetch_assoc($select_vl_np);

							//SICK LEAVE
								//SL WITH PAY
									$select_sl_wp = mysql_query("SELECT sum(days) as days_sl_wp FROM employee_leaves 
																						WHERE sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND pay_status='withpay' AND e_no='$e_no' AND type='Sick Leave'");
									$result_sl_wp = mysql_fetch_assoc($select_sl_wp);
								//SL WITHOUT PAY
									$select_sl_np = mysql_query("SELECT sum(days) as days_sl_np FROM employee_leaves 
																						WHERE sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND pay_status='nopay' AND e_no='$e_no' AND type='Sick Leave'");
									$result_sl_np = mysql_fetch_assoc($select_sl_np);

							//SOLO PARENT LEAVE
								//SLP WITH PAY
									$select_slp_wp = mysql_query("SELECT sum(days) as days_slp_wp FROM employee_leaves 
																						WHERE sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND pay_status='withpay' AND e_no='$e_no' AND type='Solo Parent Leave'");
									$result_slp_wp = mysql_fetch_assoc($select_slp_wp);
								//SLP WITHOUT PAY
									$select_slp_np = mysql_query("SELECT sum(days) as days_slp_np FROM employee_leaves 
																						WHERE sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND pay_status='nopay' AND e_no='$e_no' AND type='Solo Parent Leave'");
									$result_slp_np = mysql_fetch_assoc($select_slp_np);
							//MATERNITY/PATERNITY LEAVE
								//PATERNITY LEAVE
									if($_REQUEST['gender']=='Male')
									{
										$mpl_title = 'Paternity Leave';
										$mpl_rem = 7;
										$select_mpl = mysql_query("SELECT sum(days) as days_mpl FROM employee_leaves
																	WHERE sdate>='$date_leave_start' AND sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND e_no='$e_no' AND pay_status='withpay' AND type='Paternity Leave'");
										$result_mpl = mysql_fetch_assoc($select_mpl);
									}
								//MATERNITY LEAVE
									elseif($_REQUEST['gender']=='Female')
									{
										$mpl_title = 'Maternity Leave';
										$mpl_rem = 105;
										$select_mpl = mysql_query("SELECT sum(days) as days_mpl FROM employee_leaves
																	WHERE sdate>='$date_leave_start' AND sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND e_no='$e_no' AND pay_status='withpay' AND type='Maternity Leave'");
										$result_mpl = mysql_fetch_assoc($select_mpl);
									}
	
							//EMERGENCY LEAVE
								//EL WITHOUT PAY
									$select_el_np = mysql_query("SELECT sum(days) as days_el_np FROM employee_leaves 
																						WHERE sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND pay_status='nopay' AND e_no='$e_no' AND type='Emergency Leave'");
									$result_el_np = mysql_fetch_assoc($select_el_np);

							//OTHERS
								//OL WITHOUT PAY
									$select_ol_np = mysql_query("SELECT sum(days) as days_ol_np FROM employee_leaves 
																						WHERE sdate>='$date_leave_start' AND sdate<='$date_leave_end' AND pay_status='nopay' AND e_no='$e_no' AND type='Others'");
									$result_ol_np = mysql_fetch_assoc($select_ol_np);

							$vlwp = $result_vl_wp['days_vl_wp'];
							$vlnp = $result_vl_np['days_vl_np'];
							$slwp = $result_sl_wp['days_sl_wp'];
							$slnp = $result_sl_np['days_sl_np'];
							$slpwp = $result_slp_wp['days_slp_wp'];
							$slpnp = $result_slp_np['days_slp_np'];
							$mpl = $result_mpl['days_mpl'];
							$elnp = $result_el_np['days_el_np'];
							$olnp = $result_ol_np['days_ol_np'];
							
							$vlrem = (($rem_vl+$loyalty)-$vlwp);
							$slrem = ($rem_sl-$slwp);
							if($_REQUEST['gender']=='Female') {
								$slprem = (7-$slpwp);
							} else {
								$slprem = 0;
							}
							
							$mpl_ttl_rem = ($mpl_rem-$mpl);

							$leaves[$leave_year] = array(
								"vlwp" => $vlwp,
								"vlnp" => $vlnp,
								"slwp" => $slwp,
								"slnp" => $slnp,
								"slpwp" => $slpwp,
								"slpnp" => $slpnp,
								"mpl" => $mpl,
								"elnp" => $elnp,
								"olnp" => $olnp,
								"vlrem" => $vlrem + $leaves[$leave_year-1]["vlrem"],
								"slrem" => $slrem,
								"slprem" => $slprem,
								"mpt_ttl_rem" => $mpl_ttl_rem,
							);
						}
						krsort($leaves);
						?>
						<?php foreach($leaves as $key => $value): 
							$vlwp = $value['vlwp'];
							$vlnp = $value['vlnp'];
							$slwp = $value['slwp'];
							$slnp = $value['slnp'];
							$slpwp = $value['slpwp'];
							$slpnp = $value['slpnp'];
							$mpl = $value['mpl'];
							$elnp = $value['elnp'];
							$olnp = $value['olnp'];
							
							$vlrem = $value['vlrem'];
							$slrem = $value['slrem'];
							$slprem = $value['slprem'];
							
							$mpl_ttl_rem = $value['mpt_ttl_rem'];
							
							?>
						<table class="leave-tracker-table">
								<thead>
									<tr>
										<th colspan="5"><?php echo $key; ?></th>
									</tr>
									<tr class="header">
										<td>Leave Type</td>
										<td>With Pay</td>
										<td>Without Pay</td>
										<td>Total</td>
										<td>Remaining</td>
									</tr>
								</thead>
								<tbody>
							
									<tr class="vlrow">
										<td class='title'>Vacation Leave</td>
										<td class="wp"><?php if($vlwp == null){echo '0';}else{echo $vlwp;} ?></td>
										<td class="np"><?php if($vlnp == null){echo '0';}else{echo $vlnp;} ?></td>
										<td class="total"><?php echo $vlwp + $vlnp ?></td>
										<td class="rem"><?php echo $vlrem; ?></td>
									</tr>
									<tr class="slrow">
										<td class='title'>Sick Leave</td>
										<td class="wp"><?php if($slwp == null){echo '0';}else{echo $slwp;} ?></td>
										<td class="np"><?php if($slnp == null){echo '0';}else{echo $slnp;} ?></td>
										<td class="total"><?php echo $slwp + $slnp ?></td>
										<td class="rem"><?php echo $slrem; ?></td>
									</tr>
									<?php if($_REQUEST['gender']=='Female'): ?>
									<tr class="slprow">
										<td class='title'>Solo Parent Leave</td>
										<td class="wp"><?php if($slpwp == null){echo '0';}else{echo $slpwp;} ?></td>
										<td class="np"><?php if($slpnp == null){echo '0';}else{echo $slpnp;} ?></td>
										<td class="total"><?php echo $slpwp + $slpnp ?></td>
										<td class="rem"><?php echo $slprem = (7-$slpwp); ?></td>
									</tr>
									<?php endif; ?>
									<tr class="mplrow">
										<td class='title'><?php echo $mpl_title; ?></td>
										<td class="wp"><?php echo '-'; ?></td>
										<td class="np"><?php if($mpl == null){echo '0';}else{echo $mpl;} ?></td>
										<td class="total"><?php if($mpl == null){echo '0';}else{echo $mpl;} ?></td>
										<td class="rem"><?php echo $mpl_ttl_rem; ?></td>
									</tr>
									<tr class="elrow">
										<td class='title'>Emergency Leave</td>
										<td class="wp"><?php echo '-'; ?></td>
										<td class="np"><?php if($elnp == null){echo '0';}else{echo $elnp;} ?></td>
										<td class="total"><?php if($elnp == null){echo '0';}else{echo $elnp;} ?></td>
										<td class="rem"><?php echo "-" ?></td>
									</tr>
									<tr class="olrow">
										<td class='title'>Others</td>
										<td class="wp"><?php echo '-'; ?></td>
										<td class="np"><?php if($olnp == null){echo '0';}else{echo $olnp;} ?></td>
										<td class="total"><?php if($olnp == null){echo '0';}else{echo $olnp;} ?></td>
										<td class="rem"><?php echo "-" ?></td>
									</tr>
								<tfoot>
									<tr class="ttlrow">
										<td class='title'>TOTAL</td>
										<td><?php echo $wptotal = ($vlwp + $slwp + $slpwp + $mpl); ?></td>
										<td><?php echo $nptotal = ($vlnp + $slnp + $slpnp + $elnp + $olnp); ?></td>
										<td><?php echo $wptotal + $nptotal; ?></td>
										<td><?php echo $vlrem + $slrem + $slprem + $mpl_ttl_rem; ?></td>
									</tr>
								</tfoot>
								</tbody>
						</table>
									<?php endforeach; ?>
				<?php endif; ?>
				</div>
		</div>
</div>

<!-- LEAVE REPORT -->
	<?php
	if(isset($_REQUEST['leave_report']))
		{
			$current_year = date('Y') . "-12-31";
			$start_date = "el.sdate >= '2018-01-01'";
			$end_date = "el.sdate <= '$current_year'";
			$filter_employee = "";
			$filter_company = "";
			$filter_leave_type = "";

			//LEAVE FILTER ALGORITHM
				if(isset($_REQUEST['filter-leave']))
				{
						if(isset($_REQUEST['filter-smonth']))
						{
							if($_REQUEST['filter-smonth'] == '')
							{
								$start_date = "el.sdate >= '2018-01-01'";
							}
							else
							{
								$filter_smonth = $_REQUEST['filter-smonth'];
								$start_date = "el.sdate >= " . "'$filter_smonth'";
							}
						}
						if(isset($_REQUEST['filter-emonth']))
						{
							if($_REQUEST['filter-emonth'] == '')
							{
								$end_date = "el.sdate <= '$current_year'";
							}
							else
							{
								$filter_emonth = $_REQUEST['filter-emonth'];
								$end_date = "el.sdate <= " . "'$filter_emonth'";
							}
						}
						if(isset($_REQUEST['filter-year']))
						{
							if($_REQUEST['filter-emonth'] == '' && $_REQUEST['filter-smonth'] == '')
							{
								$year = $_REQUEST['filter-year'];
								if($year === "ALL" || $year === "" || $year === "Filter: Year")
									{
									}
								else
									{
										$start_date = "el.sdate >= '" . $year . "-01-01'";
										$end_date = "el.sdate <='" . $year . "-12-31'";
									}
							}
						}
						if(isset($_REQUEST['filter-employee']))
						{
							$e_no = $_REQUEST['filter-employee'];
							if($e_no === 'ALL' || $e_no === '' || $e_no === 'Filter: Employee')
							{
								$filter_employee = "";
							}
							else
							{
								$filter_employee = "emp.e_no = '$e_no' AND";
							}
						}
						if(isset($_REQUEST['filter-company']))
						{
							$company = $_REQUEST['filter-company'];
							if($company === 'ALL' || $company === '' || $company === 'Filter: Company' )
							{
								$filter_company = "";
							}
							else
							{
								$filter_company = "emp.e_company = '$company' AND";
							}
						}
						if(isset($_REQUEST['filter-leave-type']))
						{
							$leave_type = $_REQUEST['filter-leave-type'];
							if($leave_type === 'ALL' || $leave_type === '' || $leave_type === 'Filter: Leave Type' )
							{
								$filter_leave_type = "";
							}
							else
							{
								$filter_leave_type = "el.type = '$leave_type' AND";
							}
						}
				}
			
			//COMPANY SELECT QUERY
				$select_company = mysql_query( "SELECT * FROM company");

			//EMPLOYEE SELECT QUERY
				$select_employee = mysql_query( "SELECT * FROM employee WHERE e_employment_status != 'NotConnected' AND e_employment_status != 'Resigned' AND e_employment_status != 'Agency' ORDER BY e_lname ASC");
			
				//ALL LEAVE QUERY
				$select_all=mysql_query("SELECT emp.e_no,emp.e_lname,emp.e_fname,emp.e_mname,el.* FROM employee_leaves AS el INNER JOIN employee AS emp ON el.e_no = emp.e_no WHERE $filter_employee $filter_company $filter_leave_type $start_date AND $end_date ORDER BY el.sdate DESC") or die(mysql_error());
				$result_all=mysql_fetch_assoc($select_all);
		?>

	<!-- LEAVE FILTER -->
	<div class="leave-filter">
			<form method="POST">
				
				<br />
				<label>Filter Date: Start </label> <input  name="filter-smonth" type="date" />
				<label>Filter Date: End </label><input  name="filter-emonth" type="date" />

				<select name="filter-year">
							<option selected>Filter: Year</option>
							<option></option>
							<option>ALL</option>
					<?php for($year = 2018; $year<=date('Y'); $year++): ?>
							<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
					<?php endfor;	?>
				</select>

				<select name="filter-employee">
				<option selected>Filter: Employee</option>
							<option></option>
							<option>ALL</option>
					<?php while($result_employee = mysql_fetch_assoc($select_employee)): ?>
						<option value="<?php echo $result_employee['e_no']; ?>"><?php echo $result_employee['e_lname'].", ".$result_employee['e_fname'] ?></option>
					<?php endwhile;	?>
				</select>

				<select name="filter-company">
							<option selected value="">Filter: Company</option>
							<option></option>
							<option>ALL</option>
					<?php while($result_company = mysql_fetch_assoc($select_company)): ?>
							<option value="<?php echo $result_company['company']; ?>"><?php echo $result_company['company_name']; ?></option>
					<?php endwhile;	?>
				</select>

				<select name="filter-leave-type">
					<option selected value="">Filter: Leave Type</option>
					<option></option>
					<option>ALL</option>
					<option>Vacation Leave</option>
					<option>Sick Leave</option>
					<option>Solo Parent Leave</option>
					<option>Maternity Leave</option>
					<option>Paternity Leave</option>
					<option>Emergency Leave</option>
					<option>Others</option>
				</select>

				<input type="submit" value="Filter" name="filter-leave" />
			</form>
		</div>

		

	<table class='table w3-small' border='1'>
	<tr class='w3-dark-gray'><td colspan='9'>LEAVE HISTORY  <div align='right' class='w3-small'><b class='w3-green'>NOTE: LEAVE COMPLETE(GREEN) <br /></b></div></td></tr>
	<tr class='w3-light-grey'>
	    <td>ID</td>
			<td>NAME</td>
			<td>Leave Type</td>
			<td>Pay Details</td>
			<td>No. of Days</td>
			<td>Reason / Remarks</td>
			<td>Leave Start Date</td>
			<td>Leave End Date</td>
			<td>APPLICATION DATE</td>
		  </tr>
	<?php
		do{	
			echo $start_date = '';
			
		$e_no=$result_all['e_no'];
	
		if($result_all['edate']<=date('Y-m-d'))
		{
			echo "<tr class='w3-pale-green w3-hover-pale-red'>";
		}
		else
		{
			echo "<tr class='w3-hover-pale-red'>";
		}	
			
			echo "<td>$e_no</td>
				<td>".$result_all['e_lname'].", ".$result_all['e_fname']." ".$result_all['e_mname']."</td>
				<td>".$result_all['type']."</td>
				<td>".$result_all['pay_status']."</td>
				<td>".$result_all['days']."</td>
				<td>".$result_all['remarks']."</td>
				<td>".date('m/d/Y',strtotime($result_all['sdate']))."</td>
				<td>".date('m/d/Y',strtotime($result_all['edate']))."</td>
				<td>".date('h:i:s A m/d/Y',strtotime($result_all['apply_date']))."</td>
				</tr>";
		}while($result_all=mysql_fetch_assoc($select_all));
	?>
  </table>
	<div align='center'><a class='w3-xxlarge' href="javascript:window.open('','_self').close();">X</a></div>
	
<?php
  }
?>
