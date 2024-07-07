<?php
session_start();
include('connection/conn.php');
if (!isset($_SESSION['username'])) {
	$loc = 'Location: index.php?msg=requires_login ' . $_SESSION['username'];
	header($loc);
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<br>
<div class='container'>
	<form>
		<select name='sort'>
			<option></option>
			<?php $sx = mysql_query("select * from company order by company asc") or die(mysql_error());
			$rx = mysql_fetch_assoc($sx);
			do {
				echo "<option>" . $rx['company'] . "</option>";
			} while ($rx = mysql_fetch_assoc($sx));
			?>
		</select>
		<input class='btn w3-blue w3-tiny' type='submit' value='SORT COMPANY'>

	</form>

	<form method="POST" action="script_monthly_rice_allowance.php" target="_blank">
		<select name="company" class="form-control" style="width: 200px;" required>
		
			<?php $sx = mysql_query("select * from company order by company asc") or die(mysql_error());
			$rx = mysql_fetch_assoc($sx);
			do {
				echo "<option>" . $rx['company'] . "</option>";
			} while ($rx = mysql_fetch_assoc($sx));
			?>
	
		</select>
		<input class="form-control" style="width: 200px;" type="date" name="f-cutoff" required />
		<input class="form-control" style="width: 200px;" type="date" name="s-cutoff" required />
		<input class="btn w3-blue wr-tiny" type="submit" name="submit" value="Print" />
	</form>

	<form method="POST" action="script_rice_allowance_printed.php" target="_blank">
		<select name="company" class="form-control" style="width: 200px;" required>
		
		<?php $sx = mysql_query("select * from company order by company asc") or die(mysql_error());
			$rx = mysql_fetch_assoc($sx);
			do {
				echo "<option>" . $rx['company'] . "</option>";
			} while ($rx = mysql_fetch_assoc($sx));
			?>
		
		</select>
		<input class="form-control" style="width: 200px;" type="date" name="f-cutoff" required />
		<input class="form-control" style="width: 200px;" type="date" name="s-cutoff" required />
		<input class="btn w3-blue wr-tiny" type="submit" name="submit" value="Final Print" />
	</form>
	<table border="1" width='100%'>
		<tr class='w3-green' align='center'>
			<td>COMPANY</td>
			<td>ID NO</td>
			<td>EMPLOYEE</td>
			<td>RATE</td>
		</tr>
		<?php

		if (isset($_REQUEST['sort'])) {
			$sort = "and e_company='" . $_REQUEST['sort'] . "'";
			$s = "select e_company,e_no,e_lname,e_mname,e_fname,e_rice,e_employment_status from employee where e_rice!=0 $sort order by e_company,e_lname asc";
		} else {
			$s = "select e_company,e_no,e_lname,e_mname,e_fname,e_rice,e_employment_status from employee where e_rice!=0 order by e_company,e_lname asc";
		}

		$q = mysql_query($s) or die(mysql_error());
		$r = mysql_fetch_assoc($q);

		do {
			echo "<tr class='w3-hover-pale-red'>
						<td>" . $r['e_company'] . "</td>
						<td>" . $r['e_no'] . "</td>
						<td>" . $r['e_lname'] . ", " . $r['e_fname'] . " " . $r['e_mname'];

			if ($r['e_employment_status'] == "Resigned" or $r['e_employment_status'] == "NotConnected" or $r['e_employment_status'] == "Agency") {
				echo "<i class='w3-text-red w3-tiny'>&nbsp&nbsp(" . $r['e_employment_status'] . ")</i>";
			} else {
				echo "<i class='w3-text-blue w3-tiny'>&nbsp&nbsp(" . $r['e_employment_status'] . ")</i>";
			}

			echo "</td>
						<td align='right'>" . number_format($r['e_rice'], 2) . "</td>
					 </tr>";
		} while ($r = mysql_fetch_assoc($q));
		?>
	</table>

</div>