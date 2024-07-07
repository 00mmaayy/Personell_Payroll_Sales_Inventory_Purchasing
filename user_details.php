<!DOCTYPE html>
<html>

<?php
    require 'connection/conn.php';
    $ID = $_GET['ID'];
    $update = 1;
    $submit = 0;
    $select_query = 
        "SELECT ipa.ID,ipa.IP,ipa.user,
                ipd.admin_user,ipd.admin_pass,ipd.ip_dept,ipd.ip_device,ipd.pidgin_user,ipd.vnc_password,
                ipd.fileserver_status,ipd.fileserver_user,ipd.fileserver_pass,ipd.user_backup,ipd.user_usb,
                ipd.user_lan,ipd.anti_status,ipd.anti_brand,ipd.proxy_settings,
                ipd.proxy_status,ipd.belarc_status,ipd.ip_os,ipd.socmed_fb,ipd.device_pass
                FROM `ip_details` AS ipd 
                JOIN ip_address AS ipa
                ON ipa.ID = ipd.ID 
                WHERE ipa.ID='$ID'";

    $select_result = mysql_query($select_query) or die(mysql_error());

    if(isset($_POST['update']))
    {   
        $update = 0;
        $submit = 1;
    }
    elseif(isset($_POST['submit']))
    {
        $input_admin_user = $_POST['admin-user'];
        $input_admin_pass = $_POST['admin-pass'];
        $input_pidgin_user = $_POST['pidgin-user'];
        $input_vnc_pass = $_POST['vnc-pass'];
        $input_fileserver_status = $_POST['fileserver-status'];
        $input_fileserver_user = $_POST['fileserver-user'];
        $input_fileserver_pass = $_POST['fileserver-pass'];
        $input_department = $_POST['ip-department'];
        $input_user_backup = $_POST['user-backup'];
        $input_user_usb = $_POST['user-usb'];
        $input_anti_stats = $_POST['anti-stats'];
        $input_anti_brand = $_POST['anti-brand'];
        $input_proxy_settings = $_POST['proxy-settings'];
        $input_proxy_status = $_POST['proxy-status'];
        $input_belarc_status = $_POST['belarc-status'];
        $input_os = $_POST['ip-os'];
        $input_socmed_fb = $_POST['socmed-fb'];
        $input_ip_device = $_POST['ip-device'];
        $input_device_pass = $_POST['device-pass'];
        $update_query = "UPDATE ip_details 
                        SET admin_user='$input_admin_user',admin_pass='$input_admin_pass',
                        pidgin_user='$input_pidgin_user',vnc_password='$input_vnc_pass',
                        fileserver_status=$input_fileserver_status, fileserver_user='$input_fileserver_user',
                        fileserver_pass='$input_fileserver_pass',ip_dept=$input_department,
                        user_backup=$input_user_backup,user_usb=$input_user_usb,
                        anti_status=$input_anti_stats,anti_brand=$input_anti_brand,
                        proxy_settings=$input_proxy_settings,proxy_status=$input_proxy_status,
                        belarc_status=$input_belarc_status,ip_os=$input_os,
                        socmed_fb=$input_socmed_fb, ip_device=$input_ip_device,
                        device_pass='$input_device_pass' WHERE ID=$ID";
        
        mysql_query($update_query);
        header("location: user_details.php?ID=$ID");
    }
?>

<head>
    <title>IT Cheat Sheet</title>
    <link rel="stylesheet" type="text/css" href="css/user_details.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
</head>

<body>
    <div class="container flex">
        <div class="details-container bg-black">
        <?php if(mysql_num_rows($select_result)>0): ?>
            <?php while($ip_row = mysql_fetch_assoc($select_result)): ?>
                <?php 
                    $user = $ip_row['user'];
                    $ip = $ip_row['IP'];
                    $ip_device = $ip_row['ip_device'];
                    $device_pass = $ip_row['device_pass'];
                    $admin_user = $ip_row['admin_user'];
                    $admin_pass = $ip_row['admin_pass'];
                    $dept = $ip_row['ip_dept'];
                    $pidgin_user = $ip_row['pidgin_user'];
                    $vnc_password = $ip_row['vnc_password'];
                    $user_backup = $ip_row['user_backup'];
                    $user_usb = $ip_row['user_usb'];
                    $user_lan = $ip_row['user_lan'];
                    $fileserver_stats = $ip_row['fileserver_status'];
                    $fileserver_user = $ip_row['fileserver_user'];
                    $fileserver_pass = $ip_row['fileserver_pass'];
                    $anti_stats = $ip_row['anti_status'];
                    $anti_brand = $ip_row['anti_brand'];
                    $proxy_settings = $ip_row['proxy_settings'];
                    $proxy_status = $ip_row['proxy_status'];
                    $belarc_status = $ip_row['belarc_status'];
                    $ip_os = $ip_row['ip_os'];
                    $socmed_fb = $ip_row['socmed_fb'];
                ?>
               <div class="details-user"><?php echo $user; ?></div>
               <div class="details-ip"><?php echo $ip ?></div>
               <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']?>">
                        <div>
                            <?php if($update === 1): ?>
                                <input type="submit" class="btn-update-submit" name="update" value="UPDATE">
                            <?php elseif($submit === 1): ?>
                                <input type="submit" class="btn-update-submit" name="submit" value="SUBMIT">
                            <?php endif; ?>
                        </div>
                    
                    <div>
                        <div class="device">
                            <?php if($update === 1): ?>
                                <?php $select_device = "SELECT * FROM ip_devices WHERE ID=$ip_device";
                                        $select_device_result = mysql_query($select_device) or die(mysql_error());
                                        if($select_device_row = mysql_fetch_assoc($select_device_result)): ?>
                                            <span><?php echo $select_device_row['device_name']; ?></span>
                                        <?php endif; ?>
                            <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                <select name="ip-device">                           
                                <?php $option_device = "SELECT * FROM ip_devices ORDER BY device_name ASC"; 
                                        $option_device_result = mysql_query($option_device) or die(mysql_error());
                                        while($option_device_row = mysql_fetch_assoc($option_device_result)):?>
                                            <option <?php if($ip_device === $option_device_row['ID']){ echo 'selected';} ?> value="<?php echo $option_device_row['ID'];?>"><?php echo $option_device_row['device_name']; ?></option>
                                        <?php endwhile; ?>
                                </select>
                            <?php endif; ?>
                        </div>
                        <div class="device-password">
                            <?php if($update === 1): ?>
                                <span>"<?php echo $device_pass; ?>"</span>
                            <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>                                                   
                                <input type="text" name="device-pass" value="<?php echo $device_pass;?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex flex-column details">
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-cog"></i><span>Admin Account</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-user-secret details-info"></i>
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php echo $admin_user ?></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                            <input type="text" name="admin-user" value="<?php echo $admin_user ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="details-cont"><i class="fa fa-lock details-info"></i> 
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php echo $admin_pass ?></span>
                                        <?php elseif($submit === 1): ?>
                                            <input type="text" name="admin-pass" value="<?php echo $admin_pass ?>" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-commenting-o"></i><span>Pidgin</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-user-o details-info"></i>
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php echo $pidgin_user; ?></span>
                                        <?php elseif($submit === 1): ?>
                                            <input type="text" name="pidgin-user" value="<?php echo $pidgin_user; ?>" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-eye"></i><span>VNC</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-lock details-info"></i> 
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php echo $vnc_password; ?></span>
                                        <?php elseif($submit === 1): ?>
                                            <input type="text" name="vnc-pass" value="<?php echo $vnc_password; ?>" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-database"></i><span>File Server</span></div></button>
                                <div class="content">
                                    <div class="details-cont">
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray enable">Enabled <i class="<?php if($fileserver_stats==='0'){ echo "fa fa-times-circle-o";} else{ echo "fa fa-check-circle-o"; }?>" style="color: <?php if($fileserver_stats==='0'){ echo 'red'; } else{echo 'green';}?>"></i></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                            <select name="fileserver-status">
                                                <option <?php if($fileserver_stats == '0'){ echo 'selected';} ?> value="0">Disabled</option>
                                                <option <?php if($fileserver_stats == '1'){ echo 'selected';} ?> value="1">Enabled</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>

                                    <div class="details-cont"><i class="fa fa-user details-info"></i>
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php echo $fileserver_user;?></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                            <input type="text" name="fileserver-user" value="<?php echo $fileserver_user ?>" />
                                        <?php endif; ?>
                                    </div>

                                    <div  class="details-cont"> <i class="fa fa-lock details-info"></i>
                                        <?php if($update === 1): ?>
                                                <span class="clr-gray"><?php echo $fileserver_pass;?></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                            <input type="text" name="fileserver-pass" value="<?php echo $fileserver_pass; ?>" />
                                        <?php endif; ?>
                                    </div>   
                                </div>       
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-building-o"></i><span>Department</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-info details-info"></i>
                                        <?php if($update === 1): ?>
                                            <?php $select_dept = "SELECT department_name FROM ip_department WHERE ID=$dept"; 
                                            $select_dept_result = mysql_query($select_dept) or die(mysql_error());
                                            if($select_dept_row = mysql_fetch_assoc($select_dept_result)):
                                            ?>
                                            <span class="clr-gray"><?php echo $select_dept_row['department_name'] ?></span>
                                            <?php endif; ?>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                        <select name="ip-department">                           
                                            <?php $select_depts = "SELECT * FROM ip_department"; 
                                                    $select_depts_result = mysql_query($select_depts) or die(mysql_error());
                                                while($select_depts_row = mysql_fetch_assoc($select_depts_result)):?>
                                                <option <?php if($dept === $select_depts_row['ID']){echo 'selected';} ?> value="<?php echo $select_depts_row['ID'];?>"><?php echo $select_depts_row['department_name']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                        <?php endif;?>
                                    </div>
                                </div>
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-hdd-o"></i><span>Back Up</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-dot-circle-o details-info"></i>
                                            <?php if($update === 1): ?>
                                                <span class="clr-gray"><?php if($user_backup == 0){echo 'None';}elseif($user_backup == 1){echo 'Full';}elseif($user_backup == 2){echo 'Partial';} ?></span>
                                            <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                                <select name="user-backup">
                                                    <option <?php if($user_backup == 0){echo 'selected';} ?> value="0">None</option>
                                                    <option <?php if($user_backup == 1){echo 'selected';} ?> value="1">Full</option>
                                                    <option <?php if($user_backup == 2){echo 'selected';} ?> value="2">Partial</option>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                </div>
                        </div>
                        <div class="flex flex-column details">
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-usb"></i><span>USB</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-dot-circle-o details-info"></i>
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php if($user_usb == 0){echo 'Disabled';}elseif($user_usb == 1){echo 'Enabled';}?></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                        <select name="user-usb">
                                            <option <?php if($user_usb == 0){echo 'selected';} ?> value="0">Disabled</option>
                                            <option <?php if($user_usb == 1){echo 'selected';} ?> value="1">Enabled</option>
                                        </select>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-shield"></i><span>Antivirus</span></div></button>
                                <div class="content">
                                        <div class="details-cont"><i class="fa fa-dot-circle-o details-info"></i>
                                                <?php if($update === 1): ?>
                                                    <span class="clr-gray"><?php if($anti_stats == 0){echo 'None';}elseif($anti_stats == 1){echo 'Free';}elseif($anti_stats == 2){ echo 'Full'; }?></span>
                                                <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                                    <select name="anti-stats">
                                                        <option <?php if($anti_stats == 0){echo 'selected';} ?> value="0">None</option>
                                                        <option <?php if($anti_stats == 1){echo 'selected';} ?> value="1">Free</option>
                                                        <option <?php if($anti_stats == 2){echo 'selected';} ?> value="2">Full</option>
                                                    </select>
                                                <?php endif; ?>
                                            </div>

                                            <div class="details-cont"><i class="fa fa-dot-circle-o details-info"></i>
                                                <?php $select_anti_brand = "SELECT * FROM ip_antiv WHERE ID = $anti_brand";
                                                        $select_anti_result = mysql_query($select_anti_brand) or die(mysql_error());?>
                                                <?php if($update === 1): ?>
                                                <?php if($select_anti_row = mysql_fetch_assoc($select_anti_result)): ?>
                                                    <span class="clr-gray"><?php echo $select_anti_row['brand_name']; ?></span>
                                                <?php endif;  ?>
                                                <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                                    <select name="anti-brand">
                                                    <?php $option_anti_brand = "SELECT * FROM ip_antiv ORDER BY brand_name ASC";
                                                        $option_anti_result = mysql_query($option_anti_brand) or die(mysql_error());
                                                        while($option_anti_row = mysql_fetch_assoc($option_anti_result)):?>
                                                        <option <?php if($anti_brand === $option_anti_row['ID']){echo 'selected';} ?> value="<?php echo $option_anti_row['ID']?>"><?php echo $option_anti_row['brand_name'] ?></option>
                                                    <?php endwhile; ?>
                                                    </select>
                                                <?php endif; ?>
                                        </div>      
                                </div>
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-wifi"></i><span>Proxy</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-cog details-info"></i>
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php if($proxy_settings == 0){ echo 'Disabled'; }else{echo 'Enabled'; } ?></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                        <select name="proxy-settings">
                                            <option <?php if($proxy_settings == 0){echo 'selected';} ?> value="0">Disabled</option>
                                            <option <?php if($proxy_settings == 1){echo 'selected';} ?> value="1">Enabled</option>
                                        </select>
                                        <?php endif; ?>
                                    </div>  

                                    <div class="details-cont"><i class="fa fa-refresh details-info"></i>
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php if($proxy_status == 0){ echo 'Stopped'; }else{echo 'Running'; } ?></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                        <select name="proxy-status">
                                            <option <?php if($proxy_status == 0){echo 'selected';} ?> value="0">Stopped</option>
                                            <option <?php if($proxy_status == 1){echo 'selected';} ?> value="1">Running</option>
                                        </select>
                                        <?php endif; ?>
                                    </div>  
                                </div>
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-desktop"></i><span>Belarc</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-info details-info"></i>
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php if($belarc_status == 0){ echo 'Not Installed'; }else{echo 'Installed'; } ?></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                        <select name="belarc-status">
                                            <option <?php if($belarc_status == 0){echo 'selected';} ?> value="0">Not Installed</option>
                                            <option <?php if($belarc_status == 1){echo 'selected';} ?> value="1">Installed</option>
                                        </select>
                                        <?php endif; ?>
                                    </div>  
                                </div>
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-windows"></i><span>Operating System</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-dot-circle-o details-info"></i>
                                        <?php if($update === 1): ?>
                                            <?php $select_os = "SELECT os_name FROM ip_os WHERE ID=$ip_os"; 
                                            $select_os_result = mysql_query($select_os) or die(mysql_error());
                                            if($select_os_row = mysql_fetch_assoc($select_os_result)):
                                            ?>
                                            <span class="clr-gray"><?php echo $select_os_row['os_name'] ?></span>
                                            <?php endif; ?>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                        <select name="ip-os">                           
                                            <?php $option_os = "SELECT * FROM ip_os ORDER BY os_name ASC"; 
                                                    $option_os_result = mysql_query($option_os) or die(mysql_error());
                                                while($option_os_row = mysql_fetch_assoc($option_os_result)):?>
                                                <option value="<?php echo $option_os_row['ID'];?>"><?php echo $option_os_row['os_name']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                        <?php endif;?>
                                    </div>
                                </div>      
                            <button type="button" class="btn collapse"><div class="details-title"><i class="fa fa-comments"></i><span>Social Media</span></div></button>
                                <div class="content">
                                    <div class="details-cont"><i class="fa fa-facebook details-info"></i>
                                        <?php if($update === 1): ?>
                                            <span class="clr-gray"><?php if($socmed_fb == 0){ echo 'Not Available'; }else{echo 'Available'; } ?></span>
                                        <?php elseif($ID === $ip_row['ID'] && $submit === 1): ?>
                                        <select name="socmed-fb">
                                            <option <?php if($socmed_fb == 0){echo 'selected';} ?> value="0">Not Available</option>
                                            <option <?php if($socmed_fb == 1){echo 'selected';} ?> value="1">Available</option>
                                        </select>
                                        <?php endif; ?>
                                    </div>  
                                </div>
                        </div> 
                    </div>
                </form>
            <script type="text/javascript" src="js/user_script.js"></script>
            <?php endwhile; endif; ?>
        </div>
        <div class="grid grid-image">

        </div>
    </div>
</body>

</html>