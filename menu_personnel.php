<!--Personnel Start-->
<?php if (isset($_REQUEST['personnel'])) { ?>
	<div class="w3-col">
		<div class="w3-container w3-blue w3-padding-15">
			<div class="w3-left w3-xlarge"><i class="fa fa-user w3-xlarge"></i> Personnel<?php if (isset($_REQUEST['add_employee_success'])) {
																								echo ">Add Employee Success! > " . $_REQUEST['name'];
																							} ?></div>
		</div>
		<br>
		<!-- Container Start -->
		<div class="container">
			<!-- Trigger the modal with a button -->
			<table>
				<tr valign='top'>
					<td>
						<?php if ($access['b2'] == 1) { ?><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add New Employee</button><?php } ?>
					</td>
					<td width='10'>&nbsp;</td>
					<td>
						<form method="get" action="script_employee_reports.php" target="_blank">
							<?php if ($access['b3']) { ?><input class="form-control btn-primary w3-tiny" type="submit" value="HR Summary Reports"><?php } ?>
						</form>
					</td>
					<td width='10'>&nbsp;</td>
					<td>
						<form method="get" action="script_employee_lates.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Lates Ranking Reports">
							<?php } ?>
						</form>

						<form method="get" action="script_employee_absents.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Absents Ranking Reports">
							<?php } ?>
						</form>
					</td>
					<td width='10'>&nbsp;</td>
					<td>
						<form method="get" action="script_employee_undertime.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Undertime Ranking Reports">
							<?php } ?>
						</form>

						<form method="get" action="script_leaves.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input name='leave_report' type='hidden' value='1'>
								<input name='leave_report' class="form-control btn-primary w3-tiny" type="submit" value="Leaves Reports">
							<?php } ?>
						</form>
					</td>
					<td width='10'>&nbsp;</td>
					<td>
						<form method="get" action="script_birthdays.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input type='hidden' name='month' value='<?php echo date('m'); ?>'>
								<input name='birthdays' type='hidden' value='1'>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Birthdays">
							<?php } ?>
						</form>

						<form method="post" action="script_loan_all.php?active=1" target="_blank">
							<?php if ($access['b3'] || ($access['f2'])) { ?>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Loans">
							<?php } ?>
						</form>
					</td>
					<td width='10'>&nbsp;</td>
					<td>
						<form method="get" action="script_subsidiary_ledger.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input name='subsidiary' type='hidden' value='1'>
								<input name='payroll_period' type='hidden' value='1'>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Subsidiary Ledger">
							<?php } ?>
						</form>

						<form method="get" action="script_employee_batch_edit.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Employee Batch Edit">
							<?php } ?>
						</form>
					</td>
					<td width='10'>&nbsp;</td>
					<td>
						<form method="get" action="script_alphalist.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input name='alphalist' type='hidden' value='1'>
								<input name='payroll_period' type='hidden' value='1'>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Alphalist">
							<?php } ?>
						</form>

						<form method="get" action="script_rice_allowance.php" target="_blank">
							<?php if ($access['b3']) { ?>
								<input class="form-control btn-primary w3-tiny" type="submit" value="Rice Allowance">
							<?php } ?>
						</form>
					</td>
				</tr>
			</table>

			<!-- Modal Start -->
			<div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content Start-->
					<div class="modal-content">
						<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Add New Employee</h4>
						</div>
						<!-- Modal Body Start-->
						<div class="modal-body">
							<form method="get" action="script_employee_add.php">
								<input required class="form-control" placeholder="Employee Number" name="e_no" type="text" /><br />
								<span class="text-muted">Select Title:</span>
								<select required class="form-control" name="e_title">
									<option></option>
									<option>Mr</option>
									<option>Ms</option>
									<option>Dr</option>
									<option>Atty</option>
									<option>Engr</option>
								</select><br />
								<input required class="form-control" placeholder="First Name" name="e_fname" type="text" /><br />
								<input required class="form-control" placeholder="Middle Name" name="e_mname" type="text" /><br />
								<input required class="form-control" placeholder="Last Name" name="e_lname" type="text" /><br />
								<span class="text-muted">Select Gender:</span>
								<select required class="form-control" name="e_gender">
									<option></option>
									<option>Male</option>
									<option>Female</option>
								</select><br />
								<span class="text-muted">Select Civil Status:</span>
								<select required class="form-control" name="e_civil_status">
									<option></option>
									<option>Single</option>
									<option>Married</option>
									<option>Legally Separated</option>
									<option>Widow</option>
								</select><br />
								<span class="text-muted">Input Birthday:</span>
								<input required class="form-control" name="e_bday" type="date" /><br />
								<input required class="form-control" placeholder="Birth Place" name="e_bplace" type="text" /><br />
								<input required class="form-control" placeholder="Height" name="e_height" type="text" /><br />
								<input required class="form-control" placeholder="Weight" name="e_weight" type="text" /><br />
								<input required class="form-control" placeholder="Religion" name="e_religion" type="text" /><br />
								<span class="text-muted">Select Blood Type:</span>
								<select required class="form-control" name="e_blood_type">
									<option></option>
									<option>O</option>
									<option>A-</option>
									<option>A+</option>
									<option>B-</option>
									<option>B+</option>
									<option>AB</option>
								</select><br />
								<input required class="form-control" placeholder="Present Address" name="e_address" type="text" /><br />
								<input required class="form-control" placeholder="Permanent Address" name="e_address_permanent" type="text" /><br />
								<input required class="form-control" placeholder="Mobile Number" name="e_mobile" type="number" /><br />
								<input required class="form-control" placeholder="Email Address" name="e_email" type="text" /><br />
								<input required class="form-control" placeholder="SSS Number" name="e_sss" type="text" /><br />
								<input required class="form-control" placeholder="TIN" name="e_tin" type="text" /><br />
								<input required class="form-control" placeholder="PhilHealth Number" name="e_philhealth" type="text" /><br />
								<input required class="form-control" placeholder="Pag-Ibig Number" name="e_pagibig" type="text" /><br />
								<input required class="form-control" placeholder="Drivers License Number" name="e_drivers_lic" type="text" /><br />
								<input required class="form-control" placeholder="Passport Number" name="e_passport_id" type="text" /><br />
								<span class="text-muted">Input Date Hired:</span>
								<input required class="form-control" name="e_entry_date" type="date" /><br />
								<input required class="form-control" placeholder="Job Title / Designation" name="e_job_title" type="text" /><br />
								<span class="text-muted">Select Employment Status:</span>
								<select required class="form-control" name="e_employment_status">
									<option></option>
									<option>OnCall</option>
									<option>Contractual</option>
									<option>Probationary</option>
									<option>Regular</option>
									<option>Resigned</option>
									<option>NotConnected</option>
									<option>Agency</option>
									<option>Others</option>
								</select><br />
								<input name="add_employee" type="submit" class="btn btn-primary" value="Submit New Employee Now!" onclick="return confirm('Are you sure?')">
							</form>
						</div>
						<!-- Modal Body End-->
						<div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div>
					</div>
					<!-- Modal content End-->
				</div>
			</div>
			<!-- Modal End -->
		</div>
		<!-- Container End -->

		<br>
		<table class="table">
			<tr>
				<td>
					<form method="get">
						<div class="col-xs-3"><strong>Employee Search</strong>
							<input name='personnel' type='hidden' value='1'>
							<input name="search_employee" type="text" class="form-control" placeholder="Input Employee Lastname or ID No." /></div>
						<br>
						<input type="submit" class="btn btn-danger" value="Search Now!"><br><br>
					</form>
				</td>
			</tr>
		</table>

		<?php
		//Employee Search Start-----
		if (isset($_REQUEST['search_employee'])) {
			$search_employee = $_REQUEST['search_employee'];
			if ($search_employee == "") {
				$s1 = "select * from employee where e_employment_status='Regular' or e_employment_status='Probationary' or e_employment_status='OnCall' order by e_lname asc";
			} else {
				$s1 = "select * from employee where e_lname like '%$search_employee%' or e_no like '%$search_employee%' order by e_lname asc";
			}
			$q1 = mysql_query($s1) or die(mysql_error());
			$r1 = mysql_fetch_assoc($q1);
			$count = mysql_num_rows($q1);
			echo "<small class='bg-danger'>&nbsp; records found: $count &nbsp;</small>";
			?>

			<table class="table table-hover">
				<tr>
					<td><strong>Employee No.</strong></td>
					<td><strong>Name</strong></td>
					<td><strong>Image</strong></td>
				</tr>
				<?php do {
					echo "<tr>
								<td>" . $r1['e_no'] . "</td>
								<td><a href='admin.php?personnel=1&e_details=1&details_menu=personal&e_no=" . $r1['e_no'] . "'>" . $r1['e_lname'] . ", " . $r1['e_fname'] . " " . substr($r1['e_mname'], 0, 1) . ".</a></td>
							    <td><div class='w3-col s4'><img src='img/id/" . $r1['e_no'] . ".jpg' class='w3-circle' style='width:40%'></div></td>
							  </tr>";
				} while ($r1 = mysql_fetch_assoc($q1));
				echo "</table>";
			}
			//Employee Search End----- 
			?>


			<?php
			if (isset($_REQUEST['e_details'])) {
				$e_no = $_REQUEST['e_no'];
				$s2 = "select * from employee where e_no='$e_no'";
				$q2 = mysql_query($s2) or die(mysql_error());
				$r2 = mysql_fetch_assoc($q2);
				echo "<table class='table-hover' border='1'>"; ?>

				<div class="w3-col s1">
					<img src="img/id/<?php echo $e_no; ?>.jpg" class="w3-circle" style="width:80%">
				</div>

				<div class="container">
					<ul class="nav nav-tabs">
						<?php if ($access['b4'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "personal") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=personal">Employee Details</a></li>
						<?php } ?>

						<?php if ($access['b5'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "family") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=family">Family Details</a></li>
						<?php } ?>

						<?php if ($access['b6'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "academic") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=academic">Academic History</a></li>
						<?php } ?>

						<?php if ($access['b7'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "employment") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=employment">Employment History</a></li>
						<?php } ?>

						<?php if ($access['b8'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "trainings") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=trainings">Trainings</a></li>
						<?php } ?>

						<?php if ($access['b17'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "movement") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=movement">Personnel Movement</a></li>
						<?php } ?>

						<?php if ($access['b18'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "organizations") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=organizations">Organizations</a></li>
						<?php } ?>

						<?php if ($access['b9'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "payroll") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=payroll">Payroll Details</a></li>
						<?php } ?>

						<?php if ($access['b10'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "upload") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=upload">Upload ID Picture</a></li>
						<?php } ?>

						<?php if ($access['b22'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "leaves") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=leaves">Leaves</a></li>
						<?php } ?>

						<?php if ($access['b24'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "offense") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=offense">Offense</a></li>
						<?php } ?>

						<?php if ($access['b23'] == 1) { ?>
							<?php if ($_REQUEST['details_menu'] == "loans") {
								echo "<li class='active'>";
							} else {
								echo "<li class='inactive'>";
							} ?>
							<a href="admin.php?personnel=1<?php echo "&e_no=" . $_REQUEST['e_no']; ?>&e_details=1&details_menu=loans">Loans</a></li>
						<?php } ?>
					</ul>
				</div>

				<tr>
					<td class='bg-primary' colspan='2' align='left'><?php echo "&nbsp;<small>ID No: " . $r2['e_no'] . " :: " . $r2['e_title'] . " " . $r2['e_fname'] . " " . $r2['e_mname'] . " " . $r2['e_lname'] . "</small>"; ?></td>
				</tr>

				<?php
				//Personal Info Start----
				if ($_REQUEST['details_menu'] == "personal") {
					echo "<tr><td width='200'>&nbsp;Title</td><td width='200'>&nbsp;" . $r2['e_title'] . "</td><td valign='top' rowspan='9' width='200'><img src='img/id/" . $r2['e_no'] . ".jpg' /></td></tr>";
					echo "<tr><td>&nbsp;First Name</td><td>&nbsp;" . $r2['e_fname'] . "</td></tr>";
					echo "<tr><td>&nbsp;Middle Name</td><td>&nbsp;" . $r2['e_mname'] . "</td></tr>";
					echo "<tr><td>&nbsp;Last Name</td><td>&nbsp;" . $r2['e_lname'] . "</td></tr>";
					echo "<tr><td>&nbsp;Gender</td><td>&nbsp;" . $r2['e_gender'] . "</td></tr>";
					echo "<tr><td>&nbsp;Civil Status</td><td>&nbsp;" . $r2['e_civil_status'] . "</td></tr>";
					$age_base = $r2['e_bday'];
					$aa = "SELECT TIMESTAMPDIFF(YEAR, '$age_base', CURDATE()) AS age";
					$aq = mysql_query($aa);
					$ar = mysql_fetch_assoc($aq);
					echo "<tr><td>&nbsp;Age</td><td>&nbsp;" . $ar['age'] . "</td></tr>";
					echo "<tr><td>&nbsp;Birthday</td><td>&nbsp;" . date('m-d-Y', strtotime($r2['e_bday'])) . "</td></tr>";
					echo "<tr><td>&nbsp;Birth Place</td><td>&nbsp;" . $r2['e_bplace'] . "</td></tr>";
					echo "<tr><td>&nbsp;Height</td><td colspan='2'>&nbsp;" . $r2['e_height'] . "</td></tr>";
					echo "<tr><td>&nbsp;Weight</td><td colspan='2'>&nbsp;" . $r2['e_weight'] . "</td></tr>";
					echo "<tr><td>&nbsp;Religion</td><td colspan='2'>&nbsp;" . $r2['e_religion'] . "</td></tr>";
					echo "<tr><td>&nbsp;Blood Type</td><td colspan='2'>&nbsp;" . $r2['e_blood_type'] . "</td></tr>";
					echo "<tr><td>&nbsp;Mobile No.</td><td colspan='2'>&nbsp;" . $r2['e_mobile'] . "</td></tr>";
					echo "<tr><td>&nbsp;Email</td><td colspan='2'>&nbsp;" . $r2['e_email'] . "</td></tr>";
					echo "<tr><td>&nbsp;SSS No.</td><td colspan='2'>&nbsp;" . $r2['e_sss'] . "</td></tr>";
					echo "<tr><td>&nbsp;TIN</td><td colspan='2'>&nbsp;" . $r2['e_tin'] . "</td></tr>";
					echo "<tr><td>&nbsp;PhilHealth</td><td colspan='2'>&nbsp;" . $r2['e_philhealth'] . "</td></tr>";
					echo "<tr><td>&nbsp;Pag-Ibig</td><td colspan='2'>&nbsp;" . $r2['e_pagibig'] . "</td></tr>";
					echo "<tr><td>&nbsp;Driver's License</td><td colspan='2'>&nbsp;" . $r2['e_drivers_lic'] . "</td></tr>";
					echo "<tr><td>&nbsp;Passport No.</td><td colspan='2'>&nbsp;" . $r2['e_passport_id'] . "</td></tr>";
					echo "<tr><td>&nbsp;Present Address</td><td colspan='2'>&nbsp;" . wordwrap($r2['e_address'], 55, "<br>\n&nbsp;", TRUE) . "</td></tr>";
					echo "<tr><td>&nbsp;Permanent Address</td><td colspan='2'>&nbsp;" . wordwrap($r2['e_address_permanent'], 55, "<br>\n&nbsp;", TRUE) . "</td></tr>";
					if ($access['b11'] == 1) {
						echo "<tr><td colspan='3' align='left'><a href='script_employee_add.php?e_no=" . $r2['e_no'] . "&edit_employee_details=1'>&nbsp;<i class='fa fa-pencil w3-large'></i> edit employee details</a></td></tr>";
					}
				}
				//Personal Info End----


				//FAMILY DETAILS Start----
				if ($_REQUEST['details_menu'] == "family") {
					echo "<tr><td align='center' colspan='3' class='bg-danger'><small>&nbsp;&nbsp;ADD FAMILY DETAILS AREA&nbsp;&nbsp;</small></td></tr>";
					echo "<tr class='bg-danger'><td align='center'><small>Name</small></td><td align='center'><small>Relationship</small></td><td align='center'><small>Birthday</small></td></tr>";
					echo "<tr><td width='200'><form method='get' action='script_employee_add.php'><input required class='form-control' name='e_f_name' type='txt'></td>
			                <td width='200'>
							            <input name='e_no' type='hidden' value='" . $_REQUEST['e_no'] . "'>
							             <select required class='form-control' name='e_f_relationship'>
							                 <option></option>
											 <option>Spouse</option>
											 <option>Father</option>
											 <option>Mother</option>
											 <option>Brother</option>
											 <option>Sister</option>
											 <option>Dependents</option>
											 <option>Child</option>
							             </select>
							</td>
			       		<td width='200'><input required class='form-control' name='e_f_bday' type='date'></td>
						<td width='50'>"; ?>
					<?php if ($access['b12'] == 1) { ?><input class="form-control btn-success" name="add_family" type="submit" onclick="return confirm('Are you sure?')"><?php } ?></form>
					</td>
					<?php echo "</tr>";
					echo "<tr><td align='center' colspan='3'><small>x x x</small></td></tr>";
					echo "<tr class='bg-info' align='center'><td><small>Name</small></td><td><small>Relationship</small></td><td colspan='1'><small>Birhday / Age</small></td></tr>";

					$sa = "select * from employee_family where e_no='$e_no'";
					$qa = mysql_query($sa) or die(mysql_error());
					$ra = mysql_fetch_assoc($qa);

					do {
						$age_base = $ra['e_f_bday'];
						$aa = "SELECT TIMESTAMPDIFF(YEAR, '$age_base', CURDATE()) AS age";
						$aq = mysql_query($aa);
						$ar = mysql_fetch_assoc($aq);
						$age = date('Y-m-d') - $ra['e_f_bday'];
						echo "<tr><td align='center'>" . $ra['e_f_name'] . "</td><td align='center'>" . $ra['e_f_relationship'] . "</td><td align='center'>" . date('m-d-Y', strtotime($ra['e_f_bday'])) . " / " . $ar['age'] . "</td>
					      <td align='center'>"; ?>
						<form method="get" action="script_employee_add.php">
							<input name="e_no" type="hidden" value="<?php echo $ra['e_no']; ?>">
							<input name="e_f_name" type="hidden" value="<?php echo $ra['e_f_name']; ?>">
							<?php if ($access['b12'] == 1) { ?><input class="form-control btn-danger" name="delete_family" type="submit" value="delete" onclick="return confirm('Are you sure to delete <?php echo $ra['e_f_name']; ?>?')"><?php } ?>
						</form>
						<?php "</td></tr>";
					} while ($ra = mysql_fetch_assoc($qa));
				}
				//Family Details End----


				//ACADEMIC HISTORY Start----
				if ($_REQUEST['details_menu'] == "academic") {
					echo "<tr><td align='center' colspan='4' class='bg-danger'><small>&nbsp;&nbsp;ADD ACADEMIC HISTORY AREA&nbsp;&nbsp;</small></td></tr>";
					echo "<tr class='bg-danger'><td align='center'><small>School Name</small></td><td align='center'><small>School Address</small></td><td align='center'><small>Year Attended</small></td><td align='center'><small>Degree</small></td></tr>";
					echo "<tr><td width='200'>
				                     <form method='get' action='script_employee_add.php'>
									    <input name='e_no' type='hidden' value='" . $_REQUEST['e_no'] . "'>
							            
										<input required class='form-control' name='e_school' type='text'>
							</td>
							<td><input required class='form-control' name='e_school_address' type='text'></td>
			                <td width='200'>
							            <input required class='form-control' name='e_school_year' type='text'>
							</td>
			       		<td width='200'><input required class='form-control' name='e_degree' type='text'></td>
						<td width='50'>"; ?>
					<?php if ($access['b13'] == 1) { ?><input class="form-control btn-success" name="add_academic" type="submit" onclick="return confirm('Are you sure?')"><?php } ?></form>
					</td>
					<?php echo "</tr>";
					echo "<tr><td align='center' colspan='4'><small>x x x</small></td></tr>";
					echo "<tr class='bg-info' align='center'><td><small>School Name</small></td><td><small>School Address</small></td><td><small>Year Attended</small></td><td><small>Degree</small></td></tr>";

					$sa = "select * from employee_school where e_no='$e_no'";
					$qa = mysql_query($sa) or die(mysql_error());
					$ra = mysql_fetch_assoc($qa);

					do {
						echo "<tr><td align='center'><small>" . $ra['e_school'] . "</small></td><td align='center'><small>" . wordwrap($ra['e_school_address'], 50, "<br>\n", TRUE) . "</small></td><td align='center'><small>" . $ra['e_school_year'] . "</small></td><td align='center'><small>" . $ra['e_degree'] . "</small></td>
					      <td align='center'>"; ?>
						<form method="get" action="script_employee_add.php">
							<input name="e_no" type="hidden" value="<?php echo $ra['e_no']; ?>">
							<input name="e_school" type="hidden" value="<?php echo $ra['e_school']; ?>">
							<?php if ($access['b13'] == 1) { ?><input class="form-control btn-danger" name="delete_school" type="submit" value="delete" onclick="return confirm('Are you sure to delete <?php echo $ra['e_school']; ?>?')"><?php } ?>
						</form>
						<?php "</td></tr>";
					} while ($ra = mysql_fetch_assoc($qa));
				}
				//Academic History End-----


				//EMPLOYMENT HISTORY Start-----
				if ($_REQUEST['details_menu'] == "employment") {
					echo "<tr><td align='center' colspan='6' class='bg-danger'><small>&nbsp;&nbsp;ADD EMPLOYMENT HISTORY AREA&nbsp;&nbsp;</small></td></tr>";
					echo "<tr class='bg-danger'><td align='center'><small>Company</small></td>
				                              <td align='center'><small>Company Address</small></td>
											  <td align='center'><small>Position</small></td>
											  <td align='center'><small>Employment Status</small></td>
											  <td align='center'><small>Date Entry</small></td>
											  <td align='center'><small>Date Exit</small></td>
											  </tr>";
					echo "<tr><td width='200'>
				                <form method='get' action='script_employee_add.php'>
							    <input name='e_no' type='hidden' value='" . $_REQUEST['e_no'] . "'>
								<input required class='form-control' name='e_company' type='text'></td>
							<td><input required class='form-control' name='e_company_address' type='text'></td>
			                <td><input required class='form-control' name='e_w_position' type='text'></td>
			       		    <td><select required class='form-control' name='e_w_status'>
							      <option></option>
							      <option>Regular</option>
								  <option>Contractual</option>
								  <option>OnCall</option>
								  <option>None</option>
								</select>
							</td>
						    <td><input required name='e_w_date_in' type='date'></td>
						    <td><input required name='e_w_date_out' type='date'></td>
						    <td width='50'>"; ?>
					<?php if ($access['b14'] == 1) { ?><input class="form-control btn-success" name="add_work" type="submit" onclick="return confirm('Are you sure?')"><?php } ?></form>
					</td>
					<?php echo "</tr>";
					echo "<tr><td align='center' colspan='6'><small>x x x</small></td></tr>";
					echo "<tr class='bg-info' align='center'>
				                             <td><small>Company</small></td>
											 <td><small>Company Address</small></td>
											 <td><small>Position</small></td>
											 <td><small>Employement Status</small></td>
											 <td><small>Date Entry</small></td>
											 <td><small>Date Exit</small></td>
											 </tr>";

					$sa = "select * from employee_work_history where e_no='$e_no' order by count desc";
					$qa = mysql_query($sa) or die(mysql_error());
					$ra = mysql_fetch_assoc($qa);

					do {
						echo "<tr><td align='center'><small>" . $ra['e_w_agency'] . "</small></td>
					          <td align='center'><small>" . wordwrap($ra['e_w_agency_address'], 50, "<br>\n", TRUE) . "</small></td>
							  <td align='center'><small>" . $ra['e_w_position'] . "</small></td>
							  <td align='center'><small>" . $ra['e_w_status'] . "</small></td>
							  <td align='center'><small>" . date('m/d/Y', strtotime($ra['e_w_date_in'])) . "</small></td>
							  <td align='center'><small>" . date('m/d/Y', strtotime($ra['e_w_date_out'])) . "</small></td>
					      <td align='center'>"; ?>
						<form method="get" action="script_employee_add.php">
							<input name="e_no" type="hidden" value="<?php echo $ra['e_no']; ?>">
							<input name="e_count" type="hidden" value="<?php echo $ra['count']; ?>">
							<?php if ($access['b14'] == 1) { ?><input class="form-control btn-danger" name="delete_work" type="submit" value="delete" onclick="return confirm('Are you sure to delete <?php echo $ra['e_school']; ?>?')"><?php } ?>
						</form>
						<?php "</td></tr>";
					} while ($ra = mysql_fetch_assoc($qa));
				}
				//Employment History End-----


				//PERSONNEL MOVEMENT Start-----
				if ($_REQUEST['details_menu'] == "movement") {
					echo "<tr>
							<td align='center' colspan='4' class='bg-danger'><small>&nbsp;&nbsp;PERSONNEL MOVEMENT&nbsp;&nbsp;</small></td>
						</tr>";
					echo "<tr class='bg-danger'>
							<td align='center'><small>JOB TITLE</small></td>
							<td align='center'><small>MOVEMENT DATE</small></td>
							<td align='center'><small>SALARY</small></td>
							<td align='center'><small>SALARY STEP / REMARKS</small></td>
						</tr>";
					echo "<tr>
							<td width='200'>
				                <form method='get' action='script_employee_add.php'>
								<input name='e_no' type='hidden' value='" . $_REQUEST['e_no'] . "'>
								<input required class='form-control' name='e_j_title' type='text'>
							</td>
							<td>
								<input required class='form-control' name='e_j_date' type='date'>
							</td>
			                <td width='200'>
							    <input required class='form-control' name='e_j_salary' type='number' step='any'>
							</td>
							<td width='200'>
							    <input required class='form-control' name='e_j_step' type='text'>
							</td>
			       		    <td width='50'>"; ?>
					<?php if ($access['b20'] == 1) { ?><input class="form-control btn-success" name="add_movement" type="submit" onclick="return confirm('Are you sure?')"><?php } ?>
					</form>
					</td>
					<?php echo "</tr>";
					echo "<tr>
							<td align='center' colspan='3'><small>x x x</small></td>
						</tr>";
					echo "<tr class='bg-info' align='center'>
							<td align='center'><small>JOB TITLE</small></td>
							<td align='center'><small>MOVEMENT DATE</small></td>
							<td align='center'><small>SALARY</small></td>
							<td align='center'><small>SALARY STEP / REMARKS</small></td>
						</tr>";

					$sa = "select * from employee_movement where e_no='$e_no' order by count desc";
					$qa = mysql_query($sa) or die(mysql_error());
					$ra = mysql_fetch_assoc($qa);

					do {
						echo "<tr>
							<td align='center'><small>" . $ra['new_title'] . "</small></td>
							<td align='center'><small>" . $ra['move_date'] . "</small></td>
							<td align='center'><small>" . number_format($ra['salary'], 2) . "</small></td>
							<td align='center'><small>" . $ra['step'] . "</small></td>
					        <td align='center'>"; ?>
						<form method="get" action="script_employee_add.php">
							<input name="e_no" type="hidden" value="<?php echo $ra['e_no']; ?>">
							<input name="count" type="hidden" value="<?php echo $ra['count']; ?>">
							<input name="new_title" type="hidden" value="<?php echo $ra['new_title']; ?>">
							<?php if ($access['b20'] == 1) { ?><input class="form-control btn-danger" name="delete_movement" type="submit" value="delete" onclick="return confirm('Are you sure to delete <?php echo $ra['new_title']; ?>?')"><?php } ?>
						</form>
						<?php "</td>
						 </tr>";
					} while ($ra = mysql_fetch_assoc($qa));
				}
				//PERSONNEL MOVEMENT End-----


				//ORGANIZATION Start-----
				if ($_REQUEST['details_menu'] == "organizations") {
					echo "<tr>
							<td align='center' colspan='3' class='bg-danger'><small>&nbsp;&nbsp;ORGANIZATIONS / CLUB&nbsp;&nbsp;</small></td>
						</tr>";
					echo "<tr class='bg-danger'>
							<td align='center'><small>ORG / CLUB NAME</small></td>
							<td align='center'><small>DATE JOINED</small></td>
							<td align='center'><small>STATUS</small></td>
						</tr>";
					echo "<tr>
							<td width='200'>
				                <form method='get' action='script_employee_add.php'>
								<input name='e_no' type='hidden' value='" . $_REQUEST['e_no'] . "'>
								<input required class='form-control' name='org_name' type='text'>
							</td>
							<td>
								<input required class='form-control' name='org_date' type='date'>
							</td>
			                <td width='200'>
							    <input required class='form-control' name='org_status' type='text'>
							</td>
							<td width='50'>"; ?>
					<?php if ($access['b21'] == 1) { ?><input class="form-control btn-success" name="add_org" type="submit" onclick="return confirm('Are you sure?')"><?php } ?>
					</form>
					</td>
					<?php echo "</tr>";
					echo "<tr>
							<td align='center' colspan='3'><small>x x x</small></td>
						</tr>";
					echo "<tr class='bg-info' align='center'>
							<td align='center'><small>ORG / CLUB NAME</small></td>
							<td align='center'><small>DATE JOINED</small></td>
							<td align='center'><small>STATUS</small></td>
						</tr>";

					$sa = "select * from employee_org where e_no='$e_no' order by count desc";
					$qa = mysql_query($sa) or die(mysql_error());
					$ra = mysql_fetch_assoc($qa);

					do {
						echo "<tr>
							<td align='center'><small>" . $ra['org_name'] . "</small></td>
							<td align='center'><small>" . $ra['date_joined'] . "</small></td>
							<td align='center'><small>" . $ra['status'] . "</small></td>
							<td align='center'>"; ?>
						<form method="get" action="script_employee_add.php">
							<input name="e_no" type="hidden" value="<?php echo $ra['e_no']; ?>">
							<input name="count" type="hidden" value="<?php echo $ra['count']; ?>">
							<input name="org_name" type="hidden" value="<?php echo $ra['new_title']; ?>">
							<?php if ($access['b21'] == 1) { ?><input class="form-control btn-danger" name="delete_org" type="submit" value="delete" onclick="return confirm('Are you sure to delete <?php echo $ra['org_name']; ?>?')"><?php } ?>
						</form>
						<?php "</td>
						 </tr>";
					} while ($ra = mysql_fetch_assoc($qa));
				}
				//ORGANIZATION End-----


				//TRAININGS AND SEMINARS Start-----
				if ($_REQUEST['details_menu'] == "trainings") {
					echo "<tr><td align='center' colspan='3' class='bg-danger'><small>&nbsp;&nbsp;ADD EMPLOYEE TRAININGS AND SEMINARS&nbsp;&nbsp;</small></td></tr>";
					echo "<tr class='bg-danger'><td align='center'><small>Training / Seminar Title</small></td><td align='center'><small>Venue</small></td><td align='center'><small>Date Attended</small></td></tr>";
					echo "<tr><td width='200'>
				                     <form method='get' action='script_employee_add.php'>
									    <input name='e_no' type='hidden' value='" . $_REQUEST['e_no'] . "'>
							            
										<input required class='form-control' name='e_t_name' type='text'>
							</td>
							<td><input required class='form-control' name='e_t_venue' type='text'></td>
			                <td width='200'>
							            <input required class='form-control' name='e_t_date' type='text'>
							</td>
			       		<td width='50'>"; ?>
					<?php if ($access['b15'] == 1) { ?><input class="form-control btn-success" name="add_training" type="submit" onclick="return confirm('Are you sure?')"><?php } ?></form>
					</td>
					<?php echo "</tr>";
					echo "<tr><td align='center' colspan='3'><small>x x x</small></td></tr>";
					echo "<tr class='bg-info' align='center'><td><small>Training / Seminar Title</small></td><td><small>Venue</small></td><td><small>Date Attended</small></td></tr>";

					$sa = "select * from employee_trainings where e_no='$e_no'";
					$qa = mysql_query($sa) or die(mysql_error());
					$ra = mysql_fetch_assoc($qa);

					do {
						echo "<tr><td align='center'><small>" . $ra['e_t_name'] . "</small></td><td align='center'><small>" . wordwrap($ra['e_t_venue'], 50, "<br>\n", TRUE) . "</small></td><td align='center'><small>" . $ra['e_t_date'] . "</small></td>
					      <td align='center'>"; ?>
						<form method="get" action="script_employee_add.php">
							<input name="e_no" type="hidden" value="<?php echo $ra['e_no']; ?>">
							<input name="e_t_name" type="hidden" value="<?php echo $ra['e_t_name']; ?>">
							<?php if ($access['b15'] == 1) { ?><input class="form-control btn-danger" name="delete_training" type="submit" value="delete" onclick="return confirm('Are you sure to delete <?php echo $ra['e_t_name']; ?>?')"><?php } ?>
						</form>
						<?php "</td></tr>";
					} while ($ra = mysql_fetch_assoc($qa));
				}
				//Trainings and Seminars End-----


				//PAYROLL DETAILS Start-----
				if ($_REQUEST['details_menu'] == "payroll") {
					echo "<tr><td width='200'>&nbsp;Job Title</td><td width='200'>&nbsp;" . $r2['e_job_title'] . "</td></tr>";
					echo "<tr><td>&nbsp;Company</td><td>&nbsp;" . $r2['e_company'] . "</td></tr>";
					echo "<tr><td>&nbsp;Department</td><td>&nbsp;" . $r2['e_department'] . "</td></tr>";
					echo "<tr><td>&nbsp;Employment Status</td><td>&nbsp;" . $r2['e_employment_status'] . "</td></tr>";
					echo "<tr><td>&nbsp;Date Hired</td><td>&nbsp;" . date('m-d-Y', strtotime($r2['e_entry_date'])) . "</td></tr>";
					
					if($r2['e_employment_status']=="Probationary"){
					echo "<tr class='w3-text-pink'><td>&nbsp;Regularization Target</td><td>&nbsp;" . date('m-d-Y', strtotime($r2['e_entry_date'].' + '.(180).'days')) . " (180 days)</td></tr>";
					}else{}
					
					echo "<tr><td>&nbsp;Date of Regularization</td><td>&nbsp;" . date('m-d-Y', strtotime($r2['e_permanent_status_date'])) . "</td></tr>";
					echo "<tr><td>&nbsp;Date of Separation</td><td>&nbsp;" . date('m-d-Y', strtotime($r2['e_exit_date'])) . "</td></tr>";
					echo "<tr><td>&nbsp;Basic Pay</td><td>&nbsp;" . number_format($r2['e_basic_pay'], 2) . "</td></tr>";
					echo "<tr><td>&nbsp;Witholding Tax</td><td>&nbsp;" . number_format($r2['e_tax'], 2) . "</td></tr>";
					echo "<tr><td>&nbsp;Allowance 15th</td><td>&nbsp;" . number_format($r2['e_allowance15'], 2) . "</td></tr>";
					echo "<tr><td>&nbsp;Allowance 30th</td><td>&nbsp;" . number_format($r2['e_allowance30'], 2) . "</td></tr>";
					echo "<tr><td>&nbsp;Salary Schedule</td><td>&nbsp;" . $r2['e_salary_sched'] . "</td></tr>";
					echo "<tr><td>&nbsp;ALC Group Employee</td><td>&nbsp;";
					if ($r2['e_alcgroup'] == 1) {
						echo "Yes";
					} else {
						echo "No";
					}
					echo "</td></tr>";
					echo "<tr><td>&nbsp;Time Class</td><td>&nbsp;";
					$time = $r2['e_timeclass'];
					$qt = mysql_query("select timeclass from employee_timeclass where id=$time") or die(mysql_error());
					$rt = mysql_fetch_assoc($qt);
					echo $rt['timeclass'];
					echo "</td></tr>";
					echo "<tr><td>&nbsp;Rice Allowance</td><td>&nbsp;" . number_format($r2['e_rice'], 2) . "</td></tr>";
					echo "<tr><td>&nbsp;Payroll ATM Account No</td><td>&nbsp;" . $r2['e_atm_account'] . "</td></tr>";
					if ($access['b16'] == 1) {
						echo "<tr><td colspan='3' align='left'><a href='script_employee_add.php?e_no=" . $r2['e_no'] . "&edit_payroll_details=1'>&nbsp;<i class='fa fa-pencil w3-large'></i> edit payroll details &nbsp;</a></td></tr>";
					}
				}
				//Pyroll Details End-----


				//LEAVES Start-----
				if ($_REQUEST['details_menu'] == "leaves") {
					echo "<tr align='center'>
						<form action='script_leaves_batch_entry.php' target='_blank'>					
						<td width='300'>
						    <br>
							<input name='create_leave' type='submit' class='btn btn-info' value='CREATE LEAVE'>
							<br><br>
						</td>
						</form>
						<form method='get' action='script_leaves.php' target='_blank'>
						    <input name=e_no type='hidden' value='" . $_REQUEST['e_no'] . "'>
							<input name=name type='hidden' value='" . $r2['e_no'] . " :: " . $r2['e_title'] . " " . $r2['e_fname'] . " " . $r2['e_mname'] . " " . $r2['e_lname'] . "'>
							<input name=gender type='hidden' value='" . $r2['e_gender'] . "'>
							<input name=hired type='hidden' value='" .$r2['e_entry_date'] . "'>
						<td width='300'>
						    <br>
							<input name='leave_history' type='submit' class='btn btn-info' value='VIEW LEAVE HISTORY'>
						    <br><br>
						</td>
					      </form>
					  </tr>";
				}
				//LEAVES End-----


				//OFFENSE Start-----
				if ($_REQUEST['details_menu'] == "offense") {
					echo "<tr align='center'>
						  <form method='get' action='script_offense.php' target='_blank'>
						    <input name=e_no type='hidden' value='" . $_REQUEST['e_no'] . "'>
							<input name=name type='hidden' value='" . $r2['e_no'] . " :: " . $r2['e_title'] . " " . $r2['e_fname'] . " " . $r2['e_mname'] . " " . $r2['e_lname'] . "'>						
						<td width='300'>
						    <br>
							<input name='add_offense' type='submit' class='btn btn-danger' value='ADD OFFENSE'>
							<br><br>
						</td>
						<td width='300'>
						    <br>
							<input name='offense_history' type='submit' class='btn btn-danger' value='OFFENSE HISTORY'>
						    <br><br>
						</td>
					      </form>
					  </tr>";
				}
				//OFFENSE End-----


				//LOANS Start-----
				if ($_REQUEST['details_menu'] == "loans") {
					echo "<tr align='center'>
						  <form method='get' action='script_loan.php' target='_blank'>
						    <input name=e_no type='hidden' value='" . $_REQUEST['e_no'] . "'>
							<input name=name type='hidden' value='" . $r2['e_no'] . " :: " . $r2['e_title'] . " " . $r2['e_fname'] . " " . $r2['e_mname'] . " " . $r2['e_lname'] . "'>						
						<td width='300'>
						    <br>
							<input name='add_loans' type='submit' class='btn btn-success' value='ADD LOANS'>
							<br><br>
						</td>
						<td width='300'>
						    <br>
							<input name='loan_histories' type='submit' class='btn btn-success' value='LOANS HISTORY'>
						    <br><br>
						</td>
					      </form>
					  </tr>";
				}
				//LOANS End-----


				//ID Upload Start-------
				if ($_REQUEST['details_menu'] == "upload") { ?>
					<tr>
						<td width="500" align="center"><br>
							<form target="_blank" action="script_upload_id.php" method="post" enctype="multipart/form-data">
								<strong>2X2 ID PICTURE</strong><br>.jpg with 200x200 pixels size<br><br>
								SELECT IMAGE TO UPLOAD:
								<input type="file" name="fileToUpload" id="fileToUpload"><br><br>
								<input class="form-control btn-danger" type="submit" value="Upload Image" name="submit" onclick="return confirm('Sure Upload???')">
							</form>
						</td>
						<td valign='top'><?php echo "<img src='img/id/" . $r2['e_no'] . ".jpg'/>"; ?></td>
					</tr>
				<?php }
			?>

			</table>

		<?php }
} ?>
	<!--Personnel End-------------->