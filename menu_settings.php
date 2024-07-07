<!---Settings Start---------------------------------------------------------------------------------------------->
 <?php if(isset($_REQUEST['settings'])) 
 { ?>   
 <div class="w3-col">
      <div class="w3-container w3-blue w3-padding-15">
        <div class="w3-left w3-xlarge"><i class="fa fa-gear w3-xlarge"></i>  Settings</div>
      </div>
     
      <br />
     <!--settings menu-->
	  <?php if($access['z2']==1){ ?><a href="admin.php?settings=1&createuser=1" class="w3-padding"><i class="fa fa-user fa-fw"></i> User Maintenance</a><?php } ?>
      <?php if($access['z5']==1){ ?><a href="admin.php?settings=1&createposition=1" class="w3-padding" ><i class="fa fa-cubes fa-fw"></i> User Position</a><?php } ?>
	  <?php if($access['z10']==1){ ?><a href="admin.php?settings=1&createdepartment=1" class="w3-padding" ><i class="fa fa-object-group fa-fw"></i> Department</a><?php } ?>
      <?php if($access['z7']==1){ ?><a href="script_access_level.php?user_access=" class="w3-padding" ><i class="fa fa-key fa-fw"></i> Create User Access Level</a><?php } ?>
	  <?php if($access['z6']==1){ ?><a href="admin.php?settings=1&updatecompany=1" class="w3-padding" ><i class="fa fa-address-card fa-fw"></i> Company Details</a><?php } ?>
	  <?php if($access['z8']==1){ ?><a href="admin.php?settings=1&backupdatabase=1" class="w3-padding" ><i class="fa fa-support fa-fw"></i> Backup Database</a><?php } ?>
	  <?php if($access['z9']==1){ ?><a href="admin.php?settings=1&logbook=1" class="w3-padding" ><i class="fa fa-book fa-fw"></i> Logbook Viewer</a><?php } ?>
	  <?php if($access['z2']==1){ ?><a href="admin.php?settings=1&signatories=1" class="w3-padding" ><i class="fa fa-pencil fa-fw"></i> Signatories</a><?php } ?>
	  
     <!--create user start for admin level-->
    <?php if(isset($_REQUEST['createuser'])) 
	 { ?> 
      <br><br>
	  <div class="col-xs-6">
	  <?php if(isset($_REQUEST['passwordupdated'])){ ?><div style="color:#0066FF" class="w3-left w3-large">Update Password Success!</div><br/><?php } ?>
	  <?php if(isset($_REQUEST['passworderror'])){ ?><div style="color:#FF0000" class="w3-left w3-large">Password Error! (input not equal)</div><br/><?php } ?>
	 
	 <?php if($access['z4']==1)
	  { //-------------------------USER ADD------------ ?>
	  <form method="get" action="script_adduser.php">
	   <div class="col-xs-8"><br/>
	   <?php if(isset($_REQUEST['success'])){ ?><div style="color:#0066FF" class="w3-left w3-large">User Successfully Created!</div><?php } ?>
	   <div class="w3-left w3-xlarge">Create New User</div><br/>
	   <br/>
	   <input name="settings" type="hidden" value="<?php echo $_REQUEST['settings'];?>">
	   <input name="createuser" type="hidden" value="<?php echo $_REQUEST['createuser'];?>">
	   <input name="password" type="hidden" value="e10adc3949ba59abbe56e057f20f883e">
       <input required class="form-control" id="ex1" placeholder="username" name="new_user" type="text" /><br/>
	   <input required class="form-control" id="ex1" placeholder="first name" name="f_name" type="text" /><br/>
	   <input required class="form-control" id="ex1" placeholder="middle name" name="m_name" type="text" /><br/>
	   <input required class="form-control" id="ex1" placeholder="last name" name="l_name" type="text" /><br/>
	   
	   <div class="form-group">
       <label for="sel1">Company (select one):</label>
       <select required name="company" class="form-control" id="sel1">
	   <option></option>
       <?php
           $sq4="select company from company order by company asc" ;
		   $rlt4= mysql_query($sq4) or die(mysql_error());
		   $rw4=mysql_fetch_assoc($rlt4);
		   do { echo "<option>".$rw4['company']."</option>"; } while ($rw4=mysql_fetch_assoc($rlt4));
        ?>
       </select>
       </div>
	   
	   <div class="form-group">
       <label for="sel1">Department (select one):</label>
       <select required name="department" class="form-control" id="sel1">
	   <option></option>
       <?php
           $sq3="select dept_name from departments order by dept_name asc";
		   $rlt3= mysql_query($sq3) or die(mysql_error());
		   $rw3=mysql_fetch_assoc($rlt3);
		   do { echo "<option>".$rw3['dept_name']."</option>"; } while ($rw3=mysql_fetch_assoc($rlt3));
        ?>
       </select>
       </div>
	   
	   <div class="form-group">
       <label for="sel1">Position (select one):</label>
       <select required name="position" class="form-control" id="sel1">
	   <option></option>
       <?php
           $sq2="select * from user_positions order by pos_description asc" ;
		   $rlt2= mysql_query($sq2) or die(mysql_error());
		   $rw2=mysql_fetch_assoc($rlt2);
		   do { echo "<option value='".$rw2['position']."'>".$rw2['pos_description']."</option>"; } while ($rw2=mysql_fetch_assoc($rlt2));
        ?>
       </select>
       </div>
	   
       <input type="submit" class="btn btn-primary" value="Create User Now" onclick="return confirm('Are you sure?')">
       </div>
	  </form>
<?php } //-------------------------USER ADD----------------- ?>

  
<?php if($access['z11']==1)
     { //----------------------USER LIST-------- ?>  
      <div class="col-xs-4"><br/>
	  <div class="w3-left w3-xlarge">User list</div><br/><br/>
	  
	  <?php if(isset($_REQUEST['resetpass'])){ ?><div style="color:#0066FF" class="w3-left w3-large">Password Reset to 123456 Successfully!</div><?php } ?>
	  <?php if(isset($_REQUEST['disable'])){ ?><div style="color:#0066FF" class="w3-left w3-large">User Successfully Disabled!</div><?php } ?>
	  <?php if(isset($_REQUEST['enable'])){ ?><div style="color:#0066FF" class="w3-left w3-large">User Successfully Enabled!</div><?php } ?>
	  
	<!--User Options for admin Only-->  
    <?php if(isset($_REQUEST['useroption']))
	     { ?>
	<span class="label w3-large label-primary">user options for "<?php echo $_REQUEST['useroption'];?>"</span>
	</br></br>
	<form method="get" action="script_user_resetanddisable_option.php">
	<input name="useroption" type="hidden" value="<?php echo $_REQUEST['useroption'];?>">
	<?php if($access['z4']==1) { ?>
	<input name="resetpass" type="submit" class="btn btn-success" value="Reset Password" onclick="return confirm('Reset Password to 123456 -Are you sure?')">
	<?php } ?>
	
	     <?php
            $useroption1=$_REQUEST['useroption'];		 
			$s12="select * from users where username='$useroption1' ";
	        $q12=mysql_query($s12) or die(mysql_error());
			$r12=mysql_fetch_assoc($q12);
          ?>	
		  
	<?php if($r12['user_disable']==0){ if($access['z4']==1) { ?><input name="disableuser" type="submit" class="btn btn-danger" value="Disable User" onclick="return confirm('Are you sure?')"><?php } } ?>
	<?php if($r12['user_disable']==1){ if($access['z4']==1) {?><input name="enableuser" type="submit" class="btn btn-info" value="Enable User" onclick="return confirm('Are you sure?')"><?php } } ?>
	<?php if($r12['user_status']==1){ ?><input name="clearuser" type="submit" class="btn btn-warning" value="Clear User" onclick="return confirm('Are you sure?')"><?php } ?>
	</form><br/>
	<?php } ?>
 
 <div class="container">
  <table class="table table-hover">
    <thead>
      <tr>
        <th width=200>Username</th>
        <th width=200>Position</th>
        <th>Fullname</th>
      </tr>
	</thead> 
    <tbody>	
	  <?php $s1="select * from users order by username asc"; 
	        $q1=mysql_query($s1) or die(mysql_error());
			$r1=mysql_fetch_assoc($q1);
			
			do{
			$position=$r1['position'];
			$s2="select * from user_positions where position=$position"; 
	        $q2=mysql_query($s2) or die(mysql_error());
			$r2=mysql_fetch_assoc($q2);
				
				echo "<tr>
			           <td><a href='admin.php?settings=1&createuser=1&useroption=".$r1['username']."'>".$r1['username']."</a>";
					     if($r1['user_status']==1) { echo "&nbsp;&nbsp;<span class='w3-tiny w3-text-red'>".$r1['user_status']."</span>"; }
				 echo "</td>
					   <td>";
				if($r1['user_disable']==1){ echo "<span style='color:#FF0000'>Disabled</span>"; }
		      	else{echo $r2['pos_description'];}
				echo "</td><td>".$r1['first_name']." ".$r1['middle_name']." ".$r1['last_name']."</td>
				</tr>";
			 }while($r1=mysql_fetch_assoc($q1));?>
	</tbody>
  </table>
 </div>
</div>
<?php } //------------------------USER LIST------------ ?>
	  
<?php } ?>
      <!--create user end-->	

	  <!---change password start--->
	  <?php if(isset($_REQUEST['createuser']))
	  {  
	  if($access['z3']==1){ ?>
	  <form method="get" action="script_user_resetanddisable_option.php">
	  <div class="col-xs-6">
	  <div class="w3-left w3-xlarge"><br>Change Password</div><br/><br/>
	   
	  <?php if(isset($_REQUEST['passwordupdated'])){ ?><div style="color:#0066FF" class="w3-left w3-large">Update Password Success!</div><br/><?php } ?>
	  <?php if(isset($_REQUEST['passworderror'])){ ?><div style="color:#FF0000" class="w3-left w3-large">Password Error! (input not equal)</div><br/><?php } ?>
	  
	   <input name="settings" type="hidden" value="<?php echo $_REQUEST['settings'];?>">
	   <input required class="form-control" id="ex1" placeholder="new password" name="new_password" type="password" /><br/>
	   <input required class="form-control" id="ex1" placeholder="repeat new password" name="password_repeat" type="password" /><br/>
	   <input name="update_password" type="submit" class="btn btn-primary" value="Change Password Now!" onclick="return confirm('Are you sure?')">
	  </form>
	  <?php } 
	  } ?>
      <!---change password end--->
	  
	  
      <!--create position start-->
	  <?php if(isset($_REQUEST['createposition'])) { ?>  
	  <form method="get" action="script_create_position.php">
	   <div class="col-xs-4"><br/><div class="w3-left w3-xlarge">Create New Position</div><br/>
	   <?php if(isset($_REQUEST['possuccess'])){ ?><div style="color:#0066FF" class="w3-left w3-large">Position Successfully Created!</div><?php } ?>
	   <br/>
	   <input name="settings" type="hidden" value="<?php echo $_REQUEST['settings'];?>">
       <input required class="form-control" id="ex1" placeholder="position" name="new_position" type="text" /><br/>
	   <input type="submit" class="btn btn-primary" value="Create Position Now" onclick="return confirm('Are you sure?')">
       </div>
	  </form>

		<div class="col-xs-4"><br/>
		<div class="w3-left w3-xlarge">Position List</div><br/><br/>	  
		<div class="container">
		  <table class="table table-hover">
			<thead>
			  <tr>
				<th width=200>Position Code</th>
				<th width=200>Description</th>
				<th></th>
			  </tr>
			</thead> 
			<tbody>	
			  <?php $s1="select * from user_positions"; 
					$q1=mysql_query($s1) or die(mysql_error());
					$r1=mysql_fetch_assoc($q1);
					do{ echo "<tr><td>".$r1['position']."</td><td>".$r1['pos_description']."</td></tr>";}while($r1=mysql_fetch_assoc($q1));?>
			</tbody>
		  </table>
		 </div>
		</div>

	  <?php } ?>
      <!--create position end-->

      <!--create department start-->
	  <?php if(isset($_REQUEST['createdepartment'])) { ?>  
	  <form method="get" action="script_create_department.php">
	   <div class="col-xs-4"><br/><div class="w3-left w3-xlarge">Create New Department</div><br/>
	   <?php if(isset($_REQUEST['possuccess'])){ ?><div style="color:#0066FF" class="w3-left w3-large">Department Successfully Created!</div><br><?php } ?>
	   <br/>
	   <input name="settings" type="hidden" value="<?php echo $_REQUEST['settings'];?>">
	   Choose Company
	   <select class="form-control" required name="company">
	      <option></option>
	      <?php $x1="select company from company";
  		        $y1=mysql_query($x1) or die(mysql_error());
				$z1=mysql_fetch_assoc($y1); 
				do{
				  echo "<option>".$z1['company']."</option>";
				}while($z1=mysql_fetch_assoc($y1));?>
	   </select>
	   <br>
	   Input New Department
       <input required class="form-control" id="ex1" placeholder="department" name="new_department" type="text" /><br/>
	   <input type="submit" class="btn btn-primary" value="Create Department Now" onclick="return confirm('Are you sure?')">
       </div>
	  </form>

		<div class="col-xs-4"><br/>
		<div class="w3-left w3-xlarge">Department List</div><br/><br/>	  
		<div class="container">
		  <table class="table table-hover">
			<thead>
			  <tr>
				<th width=200>Department Code</th>
				<th width=200>Company</th>
				<th width=200>Department</th>
				<th></th>
			  </tr>
			</thead> 
			<tbody>	
			  <?php $s1="select * from departments"; 
					$q1=mysql_query($s1) or die(mysql_error());
					$r1=mysql_fetch_assoc($q1);
					do{ echo "<tr><td>".$r1['dept_code']."</td><td>".$r1['dept_company']."</td><td>".$r1['dept_name']."</td></tr>";}while($r1=mysql_fetch_assoc($q1));
			  ?>
			</tbody>
		  </table>
		 </div>
		</div>

	  <?php } ?>
      <!--create department end-->
	  
	  <!--update company start-->
	  <?php if(isset($_REQUEST['updatecompany'])) {
	  $ss1="select * from company";
      $qq1=mysql_query($ss1) or die(mysql_error());
      $rr1=mysql_fetch_assoc($qq1);
 	  ?><br/><br/>
	  <div class="col-xs">
	  <table border="1" class="table table-hover">
	  <?php do{ ?>  
	  <tr align="center">
	   <td><img height="50" width="50" src="img/<?php echo $rr1['company']; ?>.jpg" /></td>
	   <td><?php echo $rr1['company_name']; ?></td>
	   <td><?php echo $rr1['company_address']; ?></td>
	   <td><?php echo $rr1['company_tin']; ?></td>
	   <td><?php echo $rr1['company_email']; ?></td>
	   <td><?php echo $rr1['company_tel']; ?></td>
	   <td><?php echo $rr1['company_mobile']; ?></td>
	  </tr> 
      <?php } while($rr1=mysql_fetch_assoc($qq1)); ?>	  
	  </table>
	   </div>
      <?php } ?>
      <!--update company end-->	  
	  
	  <!--backup database start-->
	  <?php if(isset($_REQUEST['backupdatabase'])) { ?><br/><br/>
	  <form method="get" action="script_database_backup.php">
	  <div class="col-xs-8">
	  <div class="w3-left w3-xlarge">Backup Database</div><br/><br/>
	  <input name="settings" type="hidden" value="<?php echo $_REQUEST['settings'];?>">
	  <input name="backupdatabase" type="submit" class="btn btn-primary" value="Create Backup Now!" onclick="return confirm('Are you sure?')">
	  </form>
	  <?php } ?>
      <!--backup database end-->	  
	  
	  <!--logbook viewer start-->
	  <?php if(isset($_REQUEST['logbook'])) { ?><br/><br/>
	  <form method="get" action="script_logbook.php" target="_blank">
	  <div class="col-xs-8">
	  <div class="w3-left w3-xlarge">Logbook Viewer</div><br/><br/><br/>
	  <input name="settings" type="hidden" value="<?php echo $_REQUEST['settings'];?>">
	  Start Date<input required name="sdate" class="form-control" type="date"><br>
      End Date<input required name="edate" class="form-control" type="date"><br>
	  Keyword<input name="keyword" type="text" class="form-control"><br>
	  
	  <input name="logbook" type="submit" class="btn btn-danger" value="View Logbook Now!" onclick="return confirm('Are you sure?')">
	  </form>
	  <?php } ?>
      <!--lobook viewer end-->
	  
	  
	   <!--signatories start-->
	  <?php if(isset($_REQUEST['signatories'])) { ?><br/><br/>
	  <div class="col-xs-12">
	  <div class="w3-left w3-xlarge">Set Signatories</div><br/><br/><br/>

	  
	  <?php $s_sig="select * from signatories";
			$q_sig=mysql_query($s_sig) or die(mysql_error());
			$r_sig=mysql_fetch_assoc($q_sig);
			
			echo "<table class='table'>
					<tr>
						<td>Name</td>
						<td>Position</td>
						<td>Level</td>
						<td>Form</td><td></td>
					</tr>";
			do{
				echo "<tr>
						<form method='get' action='script_signatories.php'>";
					echo "<td><input name='fullname' type='text' value='".$r_sig['fullname']."'></td>";
					echo "<td><input name='position' type='text' value='".$r_sig['position']."'></td>";
					echo "<td><input name='form_area' type='hidden' value='".$r_sig['form_area']."'>".$r_sig['form_area']."</td>";
					echo "<td><input name='form_name' type='hidden' value='".$r_sig['form_name']."'>".$r_sig['form_name']."</td>";
					echo "<td>"; ?><input type='submit' value='Update' onclick="return confirm('UPDATE SIGNATORIES?')"> <?php echo "</td>";
					echo "</form></tr>";
			}while($r_sig=mysql_fetch_assoc($q_sig));
	  
			echo "</table>";
	  
	  } ?>
	  
      <!--signatories end end-->
	  
	  </div>
  </div>
</div>  </div> </div>
 <?php } ?> 
<!---Settings End------------------------------------------------------------------------------------------------->	