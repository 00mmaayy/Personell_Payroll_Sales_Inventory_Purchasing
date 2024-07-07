<?php
session_start();
include 'connection/conn.php';
include 'current_user.php';

$bch = $r9['bch'];

if ($bch != 'goc') {
    $select_list = mysql_query("SELECT * FROM sales_dr_series_list WHERE bch = '$bch' ORDER BY series_beginning ASC", $syshubconn);
} else {
    $select_list = mysql_query("SELECT * FROM sales_dr_series_list ORDER BY series_beginning ASC", $syshubconn);
}

if (isset($_POST['series-sub'])) {
    $start = $_POST['series-beg'];
    $end = $_POST['series-end'];
    $booklet = $_POST['book-num'];

    mysql_query("INSERT INTO sales_dr_series_list(series_beginning,series_end,date_added,encoded_by,bch,booklet_number) VALUES($start,$end,NOW(),'$current_user','$bch',$booklet)") or die(mysql_error());
    header("location: page_series_setter.php");
}

$ppsconn = mysql_connect($hsotname,$username,$password,true);
$ppsdb = mysql_select_db('pps',$ppsconn);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/dr_series.css" />
</head>

<body>
    <?php if ($current_user == 'kath' || $current_user == 'fanny' || $current_user == 'mikeyap_sj' || $current_user == 'gideon_sp' || $current_user == 'gabs_sm' || $current_user == 'fanny_sj') : ?>
        <div class="input-cont">
            <div class="title">Set Series</div>
            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <input type="number" min="1" name="book-num" placeholder="Booklet Number" required />
                <input type="number" min="1" name="series-beg" placeholder="Series Start" required />
                <input type="number" min="1" name="series-end" placeholder="Series End" required />
                <input type="submit" name="series-sub" value="Add Series" />
            </form>
        </div>
    <?php endif; ?>

    <div class="data-cont">
        <div class="title list">Series List</div>
        <div class="flex-wrap data">
            <?php while ($row = mysql_fetch_assoc($select_list)) :
                $start = $row['series_beginning'];
                $end = $row['series_end'];
                $select_dr = mysql_query("SELECT dr_no FROM `sales_bookings_details` WHERE dr_no >= $start AND dr_no <= $end group by dr_no", $syshubconn);
                $dr_count = mysql_num_rows($select_dr);

                $select_dr_pps = mysql_query("SELECT dr_no FROM `dr_list` WHERE dr_no >= $start AND dr_no <= $end group by dr_no", $ppsconn);
                $pps_dr_count = mysql_num_rows($select_dr_pps);

                $select_cancelled = mysql_query("SELECT dr_no FROM sales_dr_cancelled WHERE dr_no >= $start AND dr_no <= $end group by dr_no", $syshubconn);
                $result_cancelled = mysql_num_rows($select_cancelled);

                $dr_missing = 50 - ($dr_count + $pps_dr_count + $result_cancelled);
                ?>
                <div>
                    <a href="dr_list.php?start=<?php echo $start; ?>&end=<?php echo $end; ?>" target="_blank">
                        <div class="data-info">
                            <span style="font-weight: bold;"><?php echo $row['booklet_number']; ?></span>
                            <div class="bullet">&colon;</div><?php echo "$start - $end :"; ?><span style="color: orange; font-size: 13px"><?php echo " $dr_missing empty dr : "; ?></span><span style="color: aquablue; font-size: 13px"><?php echo " $result_cancelled others"; ?></span>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>