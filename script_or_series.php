<?php

include 'connection/conn.php';

$select_or_series = mysql_query( "SELECT * FROM finance_or_series_list ORDER BY booklet_number ASC");

if (isset($_POST['or-submit'])) {
    $booklet = $_POST['or-booklet'];
    $start = $_POST['or-start'];
    $end = $_POST['or-end'];

    mysql_query( "INSERT INTO finance_or_series_list(booklet_number,series_start,series_end,date_encoded) VALUES($booklet,$start,$end,NOW())") or die(mysql_error($syshubconn));
    header("location:script_or_series.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>OR Series</title>
    <link rel="stylesheet" href="css/or_series.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
</head>

<body>
    <div class="grid container">
        <div class="page-input">
            <div class="input-bg"></div>

            <div class="input-container">
                <div class="page-title">
                    <i style="font-size: 80px;" class="fa fa-dollar"></i>
                    <div class="title">OR SERIES</div>
                </div>
                <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <label>BOOKLET NUMBER</label>
                    <input type="number" name="or-booklet" min="1" required />
                    <label>SERIES START</label>
                    <input type="number" name="or-start" min="1" required />
                    <label>SERIES END</label>
                    <input type="number" name="or-end" min="1" required />
                    <input type="submit" name="or-submit" value="ADD SERIES" />
                </form>
            </div>
        </div>

        <div class="page-data">
            <div class="data-header-container flex">
                <div>BOOKLET</div>
                <div>SERIES</div>
                <div>MISSING</div>
                <div>SERIES DATE</div>
            </div>

            <div class="data-container">
                <?php while ($or_list_row = mysql_fetch_assoc($select_or_series)) : 
                    $booklet = $or_list_row['booklet_number'];
                    $start = $or_list_row['series_start'];
                    $end = $or_list_row['series_end'];

                    $select_missing = mysql_query("SELECT id FROM sales_jo_payments WHERE or_no >= $start AND or_no <= $end GROUP BY or_no") or die(mysql_error());
                    $select_cancelled = mysql_query("SELECT ID FROM finance_or_cancelled WHERE or_no >= $start AND or_no <= $end GROUP BY or_no") or die(mysql_error());
                    $total_cancelled = mysql_num_rows($select_cancelled);
                    $total_or = mysql_num_rows($select_missing);
                    $missing = 50 - ($total_or + $total_cancelled);

                    $select_start_date = mysql_query("SELECT or_date FROM sales_jo_payments WHERE or_no >= $start AND or_no <= $end ORDER BY or_date ASC LIMIT 1");
                    $row_start = mysql_fetch_assoc($select_start_date);

                    $select_end_date = mysql_query("SELECT or_date FROM sales_jo_payments WHERE or_no >= $start AND or_no <= $end ORDER BY or_date DESC LIMIT 1");
                    $row_end = mysql_fetch_assoc($select_end_date);

                    $start_date = $row_start['or_date'];
                    $end_date = $row_end['or_date'];
                    
                    ?>
                    <a href="script_or_list.php?start=<?php echo $start; ?>&end=<?php echo $end; ?>" target="_blank"><div class="data flex">
                        <div><?php echo $booklet; ?></div>
                        <div><?php echo "$start - $end"; ?></div>
                        <div><?php echo "$missing"; ?></div>
                        <div class="data-date"><?php echo date('F d, Y', strtotime($start_date)) . " - " . date('F d, Y', strtotime($end_date)); ?></div>
                    </div></a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>

</html>