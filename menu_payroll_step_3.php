<?php

//STEP 3
if (isset($_REQUEST['other_deductions'])) {  ?>
  <table class="table">
    <tr>
      <td width="300"></td>
      <td width="600" align="center">

        <br>
        <form method='get' action='script_actual_hours_calc.php' target='_blank'>
          <input name='search' type='hidden' value='xxx'>
          <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
          <?php if ($access['a7'] == 1) { ?><input class='form-control btn-info' type='submit' value='WORK HOURS ENTRY'><?php } ?>
        </form>

        <br>
        <form method="get" action="script_payroll_entry_review.php" target="_blank">
          <input name='search' type='hidden' value='xxx'>
          <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
          <?php if ($access['a8'] == 1) { ?><input type="submit" class="form-control btn-info" value="DEDUCTIONS & ADJUSTMENTS ENTRY PER EMPLOYEE"><?php } ?>
        </form>

        <br>
        <form method="get" action="script_deductions_adjustments_batch.php" target="_blank">
          <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <input name="menu" type="hidden" value="0">
          <?php if ($access['a8'] == 1) { ?><input type="submit" class="form-control btn-info" value="DEDUCTIONS & ADJUSTMENTS ENTRY PER BATCH"><?php } ?>
        </form>
		
		<!--- --->
		
		<br>
        <form method="get" action="script_companion_loans_new.php" target="_blank">
          <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
		  <input name="menu" type="hidden" value="0">
          <?php if ($access['a8'] == 1) { ?><input type="submit" class="form-control btn-info" value="LOANS MANAGEMENT"><?php } ?>
        </form>
		
		<!--- --->


        <br>
        <form action='../alc-companion-module/index.php' target='_blank'>
          <?php if ($access['a7'] == 1) { ?><input class='form-control btn-info' type='submit' value='COMPANION APP'><?php } ?>
        </form>

        <br>
        <?php if (date('d') >= $z3['c1'] && date('d') <= $z3['c11']) { ?>

          <?php if ($access['a9'] == 1) { ?>
            <form method="get" action="script_payroll_reports.php" target="_blank">
              <input name="payroll" type="hidden" value="1">
              <input name="payroll_period" type="hidden" value="<?php echo date('Y-m') . "-" . $z3['c1']; ?>">
              <input name="payroll_processing" type="hidden" value="1">
              <input name="department" type="hidden" value="ALL">
              <strong><span class='text-danger'>NOTE:</span></strong> Review all entries before proceeding.<br>
              <input name="review_final" class="form-control btn btn-primary" type="submit" value="REVIEW PAYROLL">
            </form>
          <?php } ?>

        <?php } ?>

        <?php
        if(date('d')>=$z3['c2'] && date('d')<=$z3['c22']) 
        { ?>
          <?php if ($access['a9'] == 1) { ?>
            <form method="get" action="script_payroll_reports.php" target="_blank">
              <input name="payroll" type="hidden" value="1">
              <input name="payroll_period" type="hidden" value="<?php echo date('Y-m') . "-" . $z3['c2']; ?>">
              <input name="payroll_processing" type="hidden" value="1">
              <input name="department" type="hidden" value="ALL">
              <strong><span class='text-danger'>NOTE:</span></strong> Review all entries before proceeding.<br>
              <input name="review_final" class="form-control btn btn-primary" type="submit" value="REVIEW PAYROLL">
            </form>
          <?php } ?>

        <?php } ?>


        <br>
        <?php if ($access['a10'] == 1) { ?>
          <form method="get">
            <input name="payroll" type="hidden" value="1">
            <input name="payroll_period" type="hidden" value="<?php echo $_REQUEST['payroll_period']; ?>">
            <input name="payroll_processing" type="hidden" value="1">
            <strong><span class='text-danger'>MESSEGE:</span></strong> I understand and reviewed carefully the entries posted within this cutoff.<br>
            <input required name="manager_overide" type="password" class="btn" placeholder="Input Password"><br><br>
            <input name="other_deduct_final" type="submit" class="btn btn-danger" value="SUBMIT PAYROLL TO FINANCE/ACCOUNTING" onclick="return confirm('WARNING: I understand and reviewed carefully the entries posted within this cutoff. Submit to Finance/Accounting for review. Are you sure?')">
          </form>
        <?php } ?>
        <br>


      </td>

      <td width="300" align="center">
      </td>

    </tr>
  </table>
<?php
}

?>