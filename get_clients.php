<!DOCTYPE html>
<?php

include 'connection/conn.php';

//$select_clients = mysql_query("SELECT * FROM final_jo");
if(isset($_POST['submit']))
{
    $id_from = $_POST['client-from'];
    $id_to = $_POST['client-to'];
    $update = mysql_query("UPDATE sales_jo SET client_id = $id_to WHERE client_id = $id_from");
    $update_booking = mysql_query("UPDATE sales_bookings SET client_id = $id_to WHERE client_id = $id_from");
    $update_payment = mysql_query("UPDATE sales_jo_payments SET client_id = $id_to WHERE client_id = $id_from");
}

?>
<html>

<body>
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
        <input name="client-from" type="number" placeholder="Client ID From" />
        <input name="client-to" type="number" placeholder="Client ID To" />
        <input type="submit" name="submit" value="Change" />
    </form>
</body>

</html>