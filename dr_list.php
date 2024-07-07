<?php

session_start();
include 'connection/conn.php';
include 'current_user.php';

$bch = $r9['bch'];
$start = $_GET['start'];
$end = $_GET['end'];

if (isset($_POST['submit-dr'])) {
    $dr_no = $_POST['dr-no'];
    mysql_query("INSERT INTO sales_dr_cancelled(dr_no,generated_date,status,bch,set_by) VALUES($dr_no,NOW(),1,'$bch','$current_user')") or die(mysql_error());
    header("location: dr_list.php?start=$start&end=$end");
}
if (isset($_POST['collect-dr'])) {
    $dr_no = $_POST['dr-no'];
    mysql_query("INSERT INTO sales_dr_cancelled(dr_no,generated_date,status,bch,set_by) VALUES($dr_no,NOW(),2,'$bch','$current_user')") or die(mysql_error());
    header("location: dr_list.php?start=$start&end=$end");
}

$ppsconn = mysql_connect($hsotname,$username,$password,true);
$ppsdb = mysql_select_db('pps',$ppsconn);

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/dr_list.css" />
</head>

<body>

    <div clas="main-cont">
        <div class="header-cont flex">
            <div class="col1-header flex">
                <div class="header-num">DR No</div>
                <div class="d-client">CLIENT</div>
                <div class="bl-header">Backlog / AR</div>
                <div class="stats-header">Status</div>
            </div>

            <div class="col2-header flex">
                <div class="header-num">DR No</div>
                <div class="d-client">JOB</div>
                <div class="bl-header">Backlog / AR</div>
                <div class="stats-header">Status</div>
            </div>
        </div>

        <div class="data-cont flex">
            <div class="col1-data">
                <?php for ($i = $start; $i <= ($end - 25); $i++) :
                    $empty = 0;

                   /*  if ($bch != 'goc') {
                        $select_dr = mysql_query("SELECT * FROM sales_bookings_details WHERE dr_no = $i AND bch = '$bch' GROUP BY dr_no", $syshubconn);
                        $result_dr = mysql_fetch_assoc($select_dr);

                        $backlog_dr = mysql_query("SELECT b_count FROM sales_bookings_details WHERE dr_no = $i AND created_by = 'oliver_main' AND bch = '$bch' GROUP BY dr_no", $syshubconn);
                        $result_backlog = mysql_fetch_assoc($backlog_dr);

                        $select_client = mysql_query("SELECT sales_clients.name FROM sales_bookings_details LEFT JOIN sales_bookings ON sales_bookings.b_id = sales_bookings_details.b_id LEFT JOIN sales_clients ON sales_bookings.client_id = sales_clients.client_id WHERE sales_bookings_details.dr_no = $i AND sales_bookings_details.bch = '$bch'", $syshubconn);
                        $result_client = mysql_fetch_assoc($select_client);

                        $select_cancelled = mysql_query("SELECT status FROM sales_dr_cancelled WHERE dr_no = $i AND bch = '$bch'", $syshubconn);
                        $result_cancelled = mysql_fetch_assoc($select_cancelled);

                        if ($bch != 'main') {
                            $result_pps_dr['dr_no'] = Null;
                        } else {
                            $select_pps_dr = mysql_query("SELECT dr_no FROM dr_list WHERE dr_no = $i", $ppsconn);
                            $result_pps_dr = mysql_fetch_assoc($select_pps_dr);
                        }
                    } else { */
                        $select_dr = mysql_query("SELECT * FROM sales_bookings_details WHERE dr_no = $i GROUP BY dr_no", $syshubconn);
                        $result_dr = mysql_fetch_assoc($select_dr);

                        $backlog_dr = mysql_query("SELECT b_count FROM sales_bookings_details WHERE dr_no = $i AND created_by = 'oliver_main' GROUP BY dr_no", $syshubconn);
                        $result_backlog = mysql_fetch_assoc($backlog_dr);

                        $select_client = mysql_query("SELECT sales_clients.name FROM sales_bookings_details LEFT JOIN sales_bookings ON sales_bookings.b_id = sales_bookings_details.b_id LEFT JOIN sales_clients ON sales_bookings.client_id = sales_clients.client_id WHERE sales_bookings_details.dr_no = $i", $syshubconn);
                        $result_client = mysql_fetch_assoc($select_client);

                        $select_cancelled = mysql_query("SELECT status FROM sales_dr_cancelled WHERE dr_no = $i", $syshubconn);
                        $result_cancelled = mysql_fetch_assoc($select_cancelled);

                        $select_pps_dr = mysql_query("SELECT dr_no FROM dr_list WHERE dr_no = $i", $ppsconn);
                        $result_pps_dr = mysql_fetch_assoc($select_pps_dr);
                  /*   } */
                    

                    ?>
                    <div class="col-data flex">
                        <!-- DR NUMBER -->
                        <?php if ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] == Null) : ?>
                            <div class="data-num" style="font-weight: bold; font-size: 13px;"><?php echo "-" ?></div>
                        <?php elseif ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] != Null) : ?>
                            <div class="data-num" style="font-weight: bold; font-size: 13px;"><?php echo $result_pps_dr['dr_no']; ?></div>
                        <?php elseif ($result_dr['dr_no'] != Null && $result_pps_dr['dr_no'] == Null) : ?>
                            <div class="data-num" style="font-weight: bold; font-size: 13px;"><a href="script_sales_jo_finder.php?find_dr=<?php echo $result_dr['dr_no']; ?>" target="_blank"><?php echo $result_dr['dr_no']; ?></a></div>
                        <?php elseif ($result_dr['dr_no'] != Null && $result_pps_dr['dr_no'] != Null) : ?>
                            <div class="data-num" style="background: rgb(245, 63, 63); color: white;"><?php echo "DR CONFLICT"; ?></div>
                        <?php endif; ?>

                        <!-- DR COUNT -->
                        <?php if (($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] == Null) && $result_cancelled['status'] != Null) : ?>
                            <div class="d-client" style="background: rgb(255, 170, 34); color: white;">
                                <?php if ($result_cancelled['status'] == 1) {
                                    echo "CANCELLED";
                                } else {
                                    echo "DR FOR COLLECTION";
                                }
                                ?></div>
                        <?php elseif ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] == Null) :
                            $empty = 1;
                            ?>
                            <div class="d-client" style="background: rgb(245, 63, 63); color: white;"><?php echo "DR MISSING" ?></div>
                        <?php elseif ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] != Null) : ?>
                            <div class="d-client" style="background:rgb(175, 172, 22); color: white;"><?php echo  "PPS"; ?></div>
                        <?php elseif ($result_dr['dr_no'] != Null && $result_pps_dr['dr_no'] == Null) : ?>
                            <div class="d-client" style="background:royalblue; color: white;"><?php echo $result_client['name']; ?></div>
                        <?php elseif ($result_dr['dr_no'] != Null && $result_pps_dr['dr_no'] != Null) : ?>
                            <div class="d-client" style="background: rgb(245, 63, 63); color: white;"><?php echo "DR CONFLICT"; ?></div>
                        <?php endif; ?>

                        <?php if ($result_backlog['b_count'] != Null) : ?>
                            <div class="bl-data" style="color: royalblue;"><?php echo "Backlog"; ?></div>
                        <?php else : ?>
                            <div class="bl-data"><?php echo "-"; ?></div>
                        <?php endif; ?>

                        <?php if ($empty != 0) : ?>
                            <?php if ($result_cancelled['ID'] == NULL && ($current_user == 'kath' || $current_user == 'fanny' || $current_user == 'mikeyap_sj' || $current_user == 'gideon_sp' || $current_user == 'gabs_sp')) : ?>
                                <div class="stats-data">
                                    <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                        <input type="hidden" name="dr-no" value="<?php echo $i; ?>" />
                                        <input type="submit" name="submit-dr" name value="Cancel" />
                                        <input type="submit" name="collect-dr" name value="Collector's" />
                                    </form>
                                </div>
                            <?php else : ?>
                                <div class="stats-data">-</div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="stats-data">-</div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="col2-data">
                <?php for ($i = ($start + 25); $i <= ($end); $i++) :
                    $empty = 0;
                    if ($bch != 'goc') {
                        $select_dr = mysql_query("SELECT * FROM sales_bookings_details WHERE dr_no = $i AND bch = '$bch' GROUP BY dr_no", $syshubconn);
                        $result_dr = mysql_fetch_assoc($select_dr);

                        $backlog_dr = mysql_query("SELECT b_count FROM sales_bookings_details WHERE dr_no = $i AND created_by = 'oliver_main' AND bch = '$bch' GROUP BY dr_no", $syshubconn);
                        $result_backlog = mysql_fetch_assoc($backlog_dr);

                        $select_client = mysql_query("SELECT sales_clients.name FROM sales_bookings_details LEFT JOIN sales_bookings ON sales_bookings.b_id = sales_bookings_details.b_id LEFT JOIN sales_clients ON sales_bookings.client_id = sales_clients.client_id WHERE sales_bookings_details.dr_no = $i AND sales_bookings_details.bch = '$bch'", $syshubconn);
                        $result_client = mysql_fetch_assoc($select_client);

                        $select_cancelled = mysql_query("SELECT status FROM sales_dr_cancelled WHERE dr_no = $i AND bch = '$bch'", $syshubconn);
                        $result_cancelled = mysql_fetch_assoc($select_cancelled);

                        if ($bch != 'main') {
                            $result_pps_dr['dr_no'] = Null;
                        } else {
                            $select_pps_dr = mysql_query("SELECT dr_no FROM dr_list WHERE dr_no = $i", $ppsconn);
                            $result_pps_dr = mysql_fetch_assoc($select_pps_dr);
                        }
                    } else {
                        $select_dr = mysql_query("SELECT * FROM sales_bookings_details WHERE dr_no = $i GROUP BY dr_no", $syshubconn);
                        $result_dr = mysql_fetch_assoc($select_dr);

                        $backlog_dr = mysql_query("SELECT b_count FROM sales_bookings_details WHERE dr_no = $i AND created_by = 'oliver_main' GROUP BY dr_no", $syshubconn);
                        $result_backlog = mysql_fetch_assoc($backlog_dr);

                        $select_client = mysql_query("SELECT sales_clients.name FROM sales_bookings_details LEFT JOIN sales_bookings ON sales_bookings.b_id = sales_bookings_details.b_id LEFT JOIN sales_clients ON sales_bookings.client_id = sales_clients.client_id WHERE sales_bookings_details.dr_no = $i", $syshubconn);
                        $result_client = mysql_fetch_assoc($select_client);

                        $select_cancelled = mysql_query("SELECT status FROM sales_dr_cancelled WHERE dr_no = $i", $syshubconn);
                        $result_cancelled = mysql_fetch_assoc($select_cancelled);

                        $select_pps_dr = mysql_query("SELECT dr_no FROM dr_list WHERE dr_no = $i", $ppsconn);
                        $result_pps_dr = mysql_fetch_assoc($select_pps_dr);
                    }
                    ?>
                    <div class="col-data flex">
                        <?php if ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] == Null) : ?>
                            <div class="data-num"><?php echo "-" ?></div>
                        <?php elseif ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] != Null) : ?>
                            <div class="data-num"><?php echo $result_pps_dr['dr_no']; ?></div>
                        <?php elseif ($result_dr['dr_no'] != Null && $result_pps_dr['dr_no'] == Null) : ?>
                            <div class="data-num"><a href="script_sales_jo_finder.php?find_dr=<?php echo $result_dr['dr_no']; ?>" target="_blank"><?php echo $result_dr['dr_no']; ?></a></div>
                        <?php elseif ($result_dr['dr_no'] != Null && $result_pps_dr['dr_no'] != Null) : ?>
                            <div class="dr-conflict" style="background: rgb(245, 63, 63); color: white;"><?php echo "DR CONFLICT"; ?></div>
                        <?php endif; ?>

                        <!-- DR JOB -->
                        <?php if (($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] == Null) && $result_cancelled['status'] != Null) : ?>
                            <div class="d-client" style="background: rgb(255, 170, 34); color: white;">
                                <?php if ($result_cancelled['status'] == 1) {
                                    echo "CANCELLED";
                                } else {
                                    echo "DR FOR COLLECTION";
                                }
                                ?>
                            </div>
                        <?php elseif ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] == Null) :
                            $empty = 1;
                            ?>
                            <div class="d-client" style="background: rgb(245, 63, 63); color: white;"><?php echo "DR MISSING" ?></div>
                        <?php elseif ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] == Null || $result_cancelled['ID'] != Null) : ?>
                            <div class="d-client" style="background: rgb(245, 63, 63); color: white;"><?php echo "CANCELLED" ?></div>
                        <?php elseif ($result_dr['dr_no'] == Null && $result_pps_dr['dr_no'] != Null) : ?>
                            <div class="d-client" style="background:rgb(175, 172, 22); color: white;"><?php echo  "PPS"; ?></div>
                        <?php elseif ($result_dr['dr_no'] != Null && $result_pps_dr['dr_no'] == Null) : ?>
                            <div class="d-client" style="background:royalblue; color: white;"><?php echo $result_client['name']; ?></div>
                        <?php elseif ($result_dr['dr_no'] != Null && $result_pps_dr['dr_no'] != Null) : ?>
                            <div class="d-client" style="background: rgb(245, 63, 63); color: white;"><?php echo "DR CONFLICT"; ?></div>
                        <?php endif; ?>

                        <?php if ($result_backlog['b_count'] != Null) : ?>
                            <div class="bl-data" style="color: royalblue;"><?php echo "Backlog"; ?></div>
                        <?php else : ?>
                            <div class="bl-data"><?php echo "-"; ?></div>
                        <?php endif; ?>

                        <?php if ($empty != 0) : ?>
                            <?php if ($result_cancelled['ID'] == NULL && ($current_user == 'kath' || $current_user == 'fanny' || $current_user == 'mikeyap_sj' || $current_user == 'gideon_sp' || $current_user == 'gabs_sp')) : ?>
                                <div class="stats-data">
                                    <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                        <input type="hidden" name="dr-no" value="<?php echo $i; ?>" />
                                        <input type="submit" name="submit-dr" name value="Cancel" />
                                        <input type="submit" name="collect-dr" name value="Collector's" />
                                    </form>
                                </div>
                            <?php else : ?>
                                <div class="stats-data">-</div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="stats-data">-</div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>

</html>