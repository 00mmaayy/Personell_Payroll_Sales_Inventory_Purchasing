<?php

include 'connection/conn.php';

$select_jo_series = mysql_query( "SELECT * FROM sales_jo_series_list ORDER BY booklet_number ASC");

if (isset($_POST['jo-submit'])) {
    $booklet = $_POST['jo-booklet'];
    $start = $_POST['jo-start'];
    $end = $_POST['jo-end'];

    mysql_query( "INSERT INTO sales_jo_series_list(booklet_number,series_beginning,series_end,date_encoded) VALUES($booklet,$start,$end,NOW())") or die(mysql_error());
    header("location:script_jo_series.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>JO Series</title>
    <link rel="stylesheet" href="css/jo_series.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
</head>

<body>
    <div class="grid container">
        <div class="page-input">
            <div class="input-bg"></div>

            <div class="input-container">
                <div class="page-title">
                    <i style="font-size: 150px;" class="fa fa-file-text-o"></i>
                    <div class="title">JO SERIES</div>
                </div>
                <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <label>BOOKLET NUMBER</label>
                    <input type="number" name="jo-booklet" min="1" required />
                    <label>SERIES START</label>
                    <input type="number" name="jo-start" min="1" required />
                    <label>SERIES END</label>
                    <input type="number" name="jo-end" min="1" required />
                    <input type="submit" name="jo-submit" value="ADD SERIES" />
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
                <?php while ($jo_list_row = mysql_fetch_assoc($select_jo_series)) :
                    $booklet = $jo_list_row['booklet_number'];
                    $start = $jo_list_row['series_beginning'];
                    $end = $jo_list_row['series_end'];

                    $select_missing_main = mysql_query( "SELECT sales_jo.jo_no,sales_bookings.bch FROM sales_jo LEFT JOIN sales_bookings ON sales_bookings.b_jo = sales_jo.jo_no WHERE (sales_jo.jo_actual >= $start AND sales_jo.jo_actual <= $end) AND sales_bookings.bch = 'main'  GROUP BY jo_actual");
                    $total_jo_main = mysql_num_rows($select_missing_main);
                    $missing_main = 50 - $total_jo_main;

                    $select_missing_sp = mysql_query( "SELECT sales_jo.jo_no,sales_bookings.bch FROM sales_jo LEFT JOIN sales_bookings ON sales_bookings.b_jo = sales_jo.jo_no WHERE (sales_jo.jo_actual >= $start AND sales_jo.jo_actual <= $end) AND sales_bookings.bch = 'sp'  GROUP BY jo_actual");
                    $total_jo_sp = mysql_num_rows($select_missing_sp);
                    $missing_sp = 50 - $total_jo_sp;

                    $select_missing_sj = mysql_query( "SELECT sales_jo.jo_no,sales_bookings.bch FROM sales_jo LEFT JOIN sales_bookings ON sales_bookings.b_jo = sales_jo.jo_no WHERE (sales_jo.jo_actual >= $start AND sales_jo.jo_actual <= $end) AND sales_bookings.bch = 'sj'  GROUP BY jo_actual");
                    $total_jo_sj = mysql_num_rows($select_missing_sj);
                    $missing_sj = 50 - $total_jo_sj;

                    $select_missing_sm = mysql_query( "SELECT sales_jo.jo_no,sales_bookings.bch FROM sales_jo LEFT JOIN sales_bookings ON sales_bookings.b_jo = sales_jo.jo_no WHERE (sales_jo.jo_actual >= $start AND sales_jo.jo_actual <= $end) AND sales_bookings.bch = 'sm'  GROUP BY jo_actual");
                    $total_jo_sm = mysql_num_rows($select_missing_sm);
                    $missing_sm = 50 - $total_jo_sm;
					
					//new added branch start
					$select_missing_rzl = mysql_query( "SELECT sales_jo.jo_no,sales_bookings.bch FROM sales_jo LEFT JOIN sales_bookings ON sales_bookings.b_jo = sales_jo.jo_no WHERE (sales_jo.jo_actual >= $start AND sales_jo.jo_actual <= $end) AND sales_bookings.bch = 'rzl'  GROUP BY jo_actual");
                    $total_jo_rzl = mysql_num_rows($select_missing_rzl);
                    $missing_rzl = 50 - $total_jo_rzl;
					
					$select_missing_adpls = mysql_query( "SELECT sales_jo.jo_no,sales_bookings.bch FROM sales_jo LEFT JOIN sales_bookings ON sales_bookings.b_jo = sales_jo.jo_no WHERE (sales_jo.jo_actual >= $start AND sales_jo.jo_actual <= $end) AND sales_bookings.bch = 'adpls'  GROUP BY jo_actual");
                    $total_jo_adpls = mysql_num_rows($select_missing_adpls);
                    $missing_adpls = 50 - $total_jo_adpls;
					//new added branch end


                    $select_start_date = mysql_query( "SELECT jo_actual_date FROM sales_jo WHERE jo_actual >= $start AND jo_actual <= $end ORDER BY jo_actual_date ASC LIMIT 1");
                    $row_start = mysql_fetch_assoc($select_start_date);

                    $select_end_date = mysql_query( "SELECT jo_actual_date FROM sales_jo WHERE jo_actual >= $start AND jo_actual <= $end ORDER BY jo_actual_date DESC LIMIT 1");
                    $row_end = mysql_fetch_assoc($select_end_date);

                    $start_date = $row_start['jo_actual_date'];
                    $end_date = $row_end['jo_actual_date'];

                    ?>
                    <a href="script_jo_list.php?start=<?php echo $start; ?>&end=<?php echo $end; ?>" target="_blank">
                        <div class="data flex">
                            <div><?php echo $booklet; ?></div>
                            <div><?php echo "$start - $end"; ?></div>
							<!-- new added branch -->
                            <div style="font-size: 13px;"><?php echo "MAIN: <span style='font-weight:bold'>$missing_main</span>
																	- SP: <span style='font-weight:bold'>$missing_sp</span> 
																	- SJ: <span style='font-weight:bold'>$missing_sj</span> 
																	- SM: <span style='font-weight:bold'>$missing_sm</span> 
																	- RZL: <span style='font-weight:bold'>$missing_rzl</span> 
																	- ADPLS: <span style='font-weight:bold'>$missing_adpls</span>"; ?></div>
                            <div class="data-date"><?php echo date('F d, Y', strtotime($start_date)) . " - " . date('F d, Y', strtotime($end_date)); ?></div>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>

</html>