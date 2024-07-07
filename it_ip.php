<!DOCTYPE html>

<?php
    require 'connection/conn.php';

    $select_query = 'SELECT * FROM ip_address';
    $select_result = mysql_query($select_query) or die(mysql_error());
    $edit = 1;
    $update = 0;

    if(isset($_GET['edit']))
    {
        $edit = 0;
    }
    if(isset($_GET['update']))
    {
        $ip_ID = $_GET['ID'];
        $user = $_GET['data-user'];
        $lease = $_GET['data-lease'];
        $mac = $_GET['data-mac'];
        $update_query = "UPDATE ip_address SET user='$user',mac_address='$mac',lease_status='$lease' WHERE ID=$ip_ID";
        mysql_query($update_query) or die(mysql_error());
        header('location: it_ip.php');  
    }
?>

<html>
    <head>
        <title>IT Cheat Sheet</title>
       <!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->
       <link rel="stylesheet" type="text/css" href="css/itcs.css" />
       <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    </head>

    <body>
        <div class="main-container">
            <div class="data-container">
                <div class="header">
                    <div class="ip-add-header">IP Address</div>
                    <div class="ip-user-header">User</div>
                    <div class="ip-lease-header">Lease Time</div>
                    <div class="ip-mac-header">MAC Address</div>
                    <div class="ip-blank-header"></div>
                </div>

                <?php if(mysql_num_rows($select_result)>0): ?>
                    <?php while($ip_row = mysql_fetch_assoc($select_result)): ?>
                        <form method="GET" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <a class="link-details" href="user_details.php?ID=<?php echo $ip_row['ID'] ?>" target="_blank" >
                            <div class="ip-container bg-black">
                                <?php $ID = $ip_row['ID'] ?>
                                <div class="ip-add color-white"><?php echo $ip_row['IP']; ?></div>
                                <hr />
                        </a>
                                <div class="ip-user color-white">
                                    <?php if($ID != $_GET['ID']): ?>
                                    <a class="link-details" href="user_details.php?ID=<?php echo $ip_row['ID'] ?>" target="_blank" >
                                        <?php echo $ip_row['user']; ?>
                                    </a>
                                    <?php elseif($edit === 0 && $ID === $_GET['ID']): ?>
                                        <input class="user-input" type="text" value="<?php echo $ip_row['user'] ?>" name="data-user">
                                    <?php endif; ?>
                                </div> 
                                <div class="ip-lease">
                                    <?php if($ID != $_GET['ID']): ?>
                                    <a class="link-details" href="user_details.php?ID=<?php echo $ip_row['ID'] ?>" target="_blank" >
                                        <?php echo $ip_row['lease_status']; ?>
                                    </a>
                                    <?php elseif($edit === 0 && $ID === $_GET['ID']): ?>
                                        <input class="lease-input" type="text" value="<?php echo $ip_row['lease_status'] ?>" name="data-lease">
                                    <?php endif; ?>
                                </div>

                                <div class="ip-mac">
                                        <?php if($ID != $_GET['ID']): ?>
                                        <a class="link-details" href="user_details.php?ID=<?php echo $ip_row['ID'] ?>" target="_blank" >
                                            <?php echo $ip_row['mac_address']; ?>
                                        </a>
                                        <?php elseif($edit === 0 && $ID === $_GET['ID']): ?>
                                            <input class="mac-input" type="text" value="<?php echo $ip_row['mac_address'] ?>" name="data-mac">
                                        <?php endif; ?>
                                </div>

                                <div class="edit">
                                        <input type="hidden" name="ID" value="<?php echo $ID ?>">
                                    <?php if($ID != $_GET['ID']): ?>
                                        <button class="fa fa-edit button" type="submit" name="edit" value="edit"></button>
                                    <?php elseif($edit === 0 && $ID === $_GET['ID']): ?>
                                        <input class="update-btn" type="submit" name="update" value="update"> 
                                    <?php endif; ?> 
                                </div> 
                            </div>
                       
                        </form>
                    <?php endwhile; endif; ?>
                           
            </div>
        </div>
    </body>
</html>