<?php

session_start();
include 'connection/conn.php';
include 'current_user.php';

$start = $_GET['start'];
$end = $_GET['end'];


if(isset($_POST['cancel-jo'])) {
    $jo_no = $_POST['jo-num'];
    $bch = $_POST['branch'];

    mysql_query("INSERT INTO sales_jo_cancelled(status,jo_no,bch,set_by,generated_date) VALUES('cancelled',$jo_no,'$bch','$current_user',NOW())");
    header("location: script_jo_list.php?start=$start&end=$end");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>JO Listing</title>
    <link rel="stylesheet" href="css/jo_list.css" />
</head>

<body>
    <div>
        <div class="flex data-header-container">
            <div>JO #</div>
            <div>Main</div>
            <div>Amount</div>
            <div>San Pedro</div>
            <div>Amount</div>
            <div>San Jose</div>
            <div>Amount</div>
            <div>SM</div>
            <div>Amount</div>
			<div>Adplus</div>
            <div>Amount</div>
        </div>

        <?php for ($i = $start; $i <= $end; $i++) :
            $select_main = mysql_query("SELECT sales_clients.name,sales_jo.jo_amount FROM sales_jo LEFT JOIN sales_clients ON sales_clients.client_id = sales_jo.client_id LEFT JOIN sales_bookings ON sales_jo.jo_no = sales_bookings.b_jo WHERE sales_jo.jo_actual = $i AND sales_bookings.bch = 'main'");
            $result_main = mysql_fetch_assoc($select_main);
            $client_main = $result_main['name'];
            $amount_main = $result_main['jo_amount'];

            $select_sp = mysql_query("SELECT sales_clients.name,sales_jo.jo_amount FROM sales_jo LEFT JOIN sales_clients ON sales_clients.client_id = sales_jo.client_id LEFT JOIN sales_bookings ON sales_jo.jo_no = sales_bookings.b_jo WHERE sales_jo.jo_actual = $i AND sales_bookings.bch = 'sp'");
            $result_sp = mysql_fetch_assoc($select_sp);
            $client_sp = $result_sp['name'];
            $amount_sp = $result_sp['jo_amount'];

            $select_sj = mysql_query("SELECT sales_clients.name,sales_jo.jo_amount FROM sales_jo LEFT JOIN sales_clients ON sales_clients.client_id = sales_jo.client_id LEFT JOIN sales_bookings ON sales_jo.jo_no = sales_bookings.b_jo WHERE sales_jo.jo_actual = $i AND sales_bookings.bch = 'sj'");
            $result_sj = mysql_fetch_assoc($select_sj);
            $client_sj = $result_sj['name'];
            $amount_sj = $result_sj['jo_amount'];

            $select_sm = mysql_query("SELECT sales_clients.name,sales_jo.jo_amount FROM sales_jo LEFT JOIN sales_clients ON sales_clients.client_id = sales_jo.client_id LEFT JOIN sales_bookings ON sales_jo.jo_no = sales_bookings.b_jo WHERE sales_jo.jo_actual = $i AND sales_bookings.bch = 'sm'");
            $result_sm = mysql_fetch_assoc($select_sm);
            $client_sm = $result_sm['name'];
            $amount_sm = $result_sm['jo_amount'];

            $select_rzl = mysql_query("SELECT sales_clients.name,sales_jo.jo_amount FROM sales_jo LEFT JOIN sales_clients ON sales_clients.client_id = sales_jo.client_id LEFT JOIN sales_bookings ON sales_jo.jo_no = sales_bookings.b_jo WHERE sales_jo.jo_actual = $i AND sales_bookings.bch = 'rzl'");
            $result_rzl = mysql_fetch_assoc($select_rzl);
            $client_rzl = $result_rzl['name'];
            $amount_rzl = $result_rzl['jo_amount'];
			
			$select_adpls = mysql_query("SELECT sales_clients.name,sales_jo.jo_amount FROM sales_jo LEFT JOIN sales_clients ON sales_clients.client_id = sales_jo.client_id LEFT JOIN sales_bookings ON sales_jo.jo_no = sales_bookings.b_jo WHERE sales_jo.jo_actual = $i AND sales_bookings.bch = 'adpls'");
            $result_adpls = mysql_fetch_assoc($select_adpls);
            $client_adpls = $result_adpls['name'];
            $amount_adpls = $result_adpls['jo_amount'];

            
			$select_main_cancelled = mysql_query("SELECT jo_no FROM sales_jo_cancelled WHERE bch='main' AND jo_no = $i");
            $result_main_cancelled = mysql_fetch_assoc($select_main_cancelled);
            $cancelled_main = $result_main_cancelled['jo_no'];

            $select_sp_cancelled = mysql_query("SELECT jo_no FROM sales_jo_cancelled WHERE bch='sp'  AND jo_no = $i");
            $result_sp_cancelled = mysql_fetch_assoc($select_sp_cancelled);
            $cancelled_sp = $result_sp_cancelled['jo_no'];

            $select_sj_cancelled = mysql_query("SELECT jo_no FROM sales_jo_cancelled WHERE bch='sj'  AND jo_no = $i");
            $result_sj_cancelled = mysql_fetch_assoc($select_sj_cancelled);
            $cancelled_sj = $result_sj_cancelled['jo_no'];

            $select_sm_cancelled = mysql_query("SELECT jo_no FROM sales_jo_cancelled WHERE bch='sm'  AND jo_no = $i");
            $result_sm_cancelled = mysql_fetch_assoc($select_sm_cancelled);
            $cancelled_sm = $result_sm_cancelled['jo_no'];

            $select_rzl_cancelled = mysql_query("SELECT jo_no FROM sales_jo_cancelled WHERE bch='rzl'  AND jo_no = $i");
            $result_rzl_cancelled = mysql_fetch_assoc($select_rzl_cancelled);
            $cancelled_rzl = $result_rzl_cancelled['jo_no'];
			
			//new added branch start
			$select_adpls_cancelled = mysql_query("SELECT jo_no FROM sales_jo_cancelled WHERE bch='adpls'  AND jo_no = $i");
            $result_adpls_cancelled = mysql_fetch_assoc($select_adpls_cancelled);
            $cancelled_adpls = $result_adpls_cancelled['jo_no'];
			//new added branch end
            ?>
            <div class="flex data-container">

                <!-- MAIN -->
                <div><?php echo $i; ?></div>
                <div>
                    <?php if ($client_main == '' && $cancelled_main != $i) : ?>
                        <div style="background: #cc2306; padding: 5px; color: white; width: 100px; margin: auto;">NO JO</div>
                    <?php elseif ($cancelled_main == $i ) : ?>
                        <div style="background: royalblue; padding: 5px; color: white; width: 100px; margin: auto;">CANCELLED JO</div>
                    <?php else : ?>
                        <?php echo $client_main; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($client_main == '' && $cancelled_main != $i) : ?>
                        <div>
                            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="jo-num" value="<?php echo $i; ?>" />
                                <input type="hidden" name="branch" value="main" />
                                <input type="submit" name="cancel-jo" value="Cancel JO" />
                            </form>
                        </div>
                    <?php elseif ($cancelled_main == $i) : ?>
                        <?php echo "-"; ?>
                    <?php else : ?>
                        <?php echo "PHP " . number_format($amount_main, 2); ?>
                    <?php endif; ?>
                </div>

                <!-- SAN PEDRO -->
                <div>
                    <?php if ($client_sp == '' && $cancelled_sp != $i) : ?>
                        <div style="background: #cc2306; padding: 5px; color: white; width: 100px; margin: auto;">NO JO</div>
                    <?php elseif ($cancelled_sp == $i) : ?>
                        <div style="background: royalblue; padding: 5px; color: white; width: 100px; margin: auto;">CANCELLED JO</div>
                    <?php else : ?>
                        <?php echo $client_sp; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($client_sp == '' && $cancelled_sp != $i) : ?>
                        <div>
                            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="jo-num" value="<?php echo $i; ?>" />
                                <input type="hidden" name="branch" value="sp" />
                                <input type="submit" name="cancel-jo" value="Cancel JO" />
                            </form>
                        </div>
                    <?php elseif ($cancelled_sp == $i) : ?>
                        <?php echo "-"; ?>
                    <?php else : ?>
                        <?php echo "PHP " . number_format($amount_sp, 2); ?>
                    <?php endif; ?>
                </div>

                <!-- SAN JOSE -->
                <div>
                    <?php if ($client_sj == '' && $cancelled_sj != $i) : ?>
                        <div style="background: #cc2306; padding: 5px; color: white; width: 100px; margin: auto;">NO JO</div>
                    <?php elseif ($cancelled_sj == $i) : ?>
                        <div style="background: royalblue; padding: 5px; color: white; width: 100px; margin: auto;">CANCELLED JO</div>
                    <?php else : ?>
                        <?php echo $client_sj; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($client_sj == '' && $cancelled_sj != $i) : ?>
                        <div>
                            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="jo-num" value="<?php echo $i; ?>" />
                                <input type="hidden" name="branch" value="sj" />
                                <input type="submit" name="cancel-jo" value="Cancel JO" />
                            </form>
                        </div>
                    <?php elseif ($cancelled_sj == $i) : ?>
                        <?php echo "-"; ?>
                    <?php else : ?>
                        <?php echo "PHP " . number_format($amount_sj, 2); ?>
                    <?php endif; ?>
                </div>

                <!-- SM -->
                <div>
                    <?php if ($client_sm == '' && $cancelled_sm != $i) : ?>
                        <div style="background: #cc2306; padding: 5px; color: white; width: 100px; margin: auto;">NO JO</div>
                    <?php elseif ($cancelled_sm == $i) : ?>
                        <div style="background: royalblue; padding: 5px; color: white; width: 100px; margin: auto;">CANCELLED JO</div>
                    <?php else : ?>
                        <?php echo $client_sm; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($client_sm == '' && $cancelled_sm != $i) : ?>
                        <div>
                            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="jo-num" value="<?php echo $i; ?>" />
                                <input type="hidden" name="branch" value="sm" />
                                <input type="submit" name="cancel-jo" value="Cancel JO" />
                            </form>
                        </div>
                    <?php elseif ($cancelled_sm == $i) : ?>
                        <?php echo "-"; ?>
                    <?php else : ?>
                        <?php echo "PHP " . number_format($amount_sm, 2); ?>
                    <?php endif; ?>
                </div>

                   <!-- RIZAL -->
                   <div>
                    <?php if ($client_rzl == '' && $cancelled_rzl != $i) : ?>
                        <div style="background: #cc2306; padding: 5px; color: white; width: 100px; margin: auto;">NO JO</div>
                    <?php elseif ($cancelled_rzl == $i) : ?>
                        <div style="background: royalblue; padding: 5px; color: white; width: 100px; margin: auto;">CANCELLED JO</div>
                    <?php else : ?>
                        <?php echo $client_rzl; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($client_rzl == '' && $cancelled_rzl != $i) : ?>
                        <div>
                            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <input type="hidden" name="jo-num" value="<?php echo $i; ?>" />
                                <input type="hidden" name="branch" value="rzl" />
                                <input type="submit" name="cancel-jo" value="Cancel JO" />
                            </form>
                        </div>
                    <?php elseif ($cancelled_rzl == $i) : ?>
                        <?php echo "-"; ?>
                    <?php else : ?>
                        <?php echo "PHP " . number_format($amount_rzl, 2); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</body>

</html>