<div>
    <?php

    $today_date = date("d");
    $today_month = date("m");
    $today_year = date("Y");

    //NEXT PAYROLL PERIOD
    if ($today_date <= 15 && $today_date >= 1) {
        $pay_date = 11;
        $payroll_period = date("Y-m-") . $pay_date;
    } elseif ($today_date <= 31 && $today_date >= 26) {
        $pay_date = 11;
       $pay_month = $today_month + 1;
        $pay_year = $today_year;
        if ($pay_month > 12) {
            $pay_month = 1;
            $pay_year = $today_year + 1;
        }
        $payroll_period = "$pay_year-$pay_month-$pay_date";
    } elseif ($today_date <= 25 && $today_date >= 11) {
        $pay_date = 26;
        $payroll_period = date("Y-m-") . $pay_date;
    }

    //PREVIOUS PAYROLL PERIOD
    if ($today_date <= 10 && $today_date >= 1) {
        $prev_date = 26;
        $prev_month = $today_month - 1;
        $prev_year = $today_year;
        if ($prev_month < 1) {
            $prev_month = 12;
            $prev_year = $today_year - 1;
        }

        $previous_period = "$prev_year-$prev_month-$prev_date";
    } elseif ($today_date <= 31 && $today_date >= 26) {
        $prev_date = 26;
        $previous_period  = date("Y-m-") . $prev_date;
    } elseif ($today_date <= 25 && $today_date >= 11) {
        $prev_date = 11;
        $previous_period  = date("Y-m-") . $prev_date;
    }

    ?>

    <table align="center">
        <tr align="center" valign="top">
            <td width="300">
                <br>
                <?php if ($access['a13'] == 1) { ?>
                    <div align='center' class="text-danger">Cash Advance</div>
                    <form method='get' action='script_ca.php' target='_blank'>
                        <input class='form-control btn-danger' type='submit' value='Cash Advance Entry'>
                    </form>
                <?php } ?>
            </td>
            <td width="30">&nbsp;</td>
            <td width="300">
                <br>
                <?php if ($access['a13'] == 1) { ?>
                    <div align='center' class="text-danger">Adjustments</div>
                    <form method='get' action='script_adjustments_batch.php' target='_blank'>
                        <input type='hidden' name='pay-period' value='<?php echo $payroll_period; ?>' />
                        <input class='form-control btn-danger' type='submit' value='Adjustments Batch Entry'>
                    </form>
                <?php } ?>
            </td>
            <td width="30">&nbsp;</td>
            <td width="300">
                <br>
                <?php if ($access['a13'] == 1) { ?>
                    <div align='center' class="text-danger">Leaves</div>
                    <form method='get' action='script_leaves_batch_entry.php' target='_blank'>
                        <input class='form-control btn-danger' type='submit' value='Leave Batch Entry'>
                    </form>
                <?php } ?>
            </td>
        </tr>

        <tr align="center" valign="top">
            <td width="300">
                <br>
                <?php if ($access['a13'] == 1) { ?>
                    <div align='center' class="text-danger">Charges</div>
                    <form method='get' action='script_charges_batch.php' target='_blank'>
                        <input type='hidden' name='pay-period' value='<?php echo $payroll_period; ?>' />
                        <input class='form-control btn-danger' type='submit' value='Charges Batch Entry'>
                    </form>
                <?php } ?>
            </td>
            <td width="30">&nbsp;</td>
            <td width="300">
                <br>
                <?php if ($access['a13'] == 1) { ?>
                    <div align='center' class="text-danger">Over in previous pay</div>
                    <form method='get' action='script_previous_pay.php' target='_blank'>
                        <input type='hidden' name='prev-period' value='<?php echo $previous_period; ?>' />
                        <input type='hidden' name='pay-period' value='<?php echo $payroll_period; ?>' />
                        <input class='form-control btn-danger' type='submit' value='View  '>
                    </form>
                <?php } ?>
            </td>
            <td width="30">&nbsp;</td>
        </tr>
    </table>
</div>