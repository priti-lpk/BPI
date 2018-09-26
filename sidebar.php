 <?php
 ob_start();
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location:index.php');
} 
?>

<!-- LEFT SIDEBAR -->
<div id="left-sidebar" class="left-sidebar ">

    <!-- main-nav -->
    <div class="sidebar-scroll">
        <nav class="main-nav">
            <ul class="main-menu">
                <li>
                    <a href="Dashboard.php">
                        <i class="fa fa-list fw"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <?php
                include 'shreeLib/dbconn.php';

                $sql = "SELECT module.mod_name,module.mod_pagename,module.id FROM role_rights INNER JOIN create_user ON role_rights.role_id = create_user.id INNER JOIN module ON role_rights.mod_id= module.id WHERE ((role_rights.role_create=1 and role_rights.role_view=0) or (role_rights.role_create=1 and role_rights.role_view=1) or (role_rights.role_create=0 and role_rights.role_view=1) ) and create_user.id=" . $_SESSION['user_id'] . " order by module.mod_order";
                //print_r($sql);
                $result = mysqli_query($con, $sql);
                
                while ($row = mysqli_fetch_array($result)) {
                    $uid = $row['mod_pagename'];
                    //  print_r($uid);
                    ?>
                    <li>
                        <a href="<?= $uid ?>" >
                        
                            <i class="fa fa-edit fa-fw"></i>

                            <span class="text"><?= $row['mod_name'] ?></span>
                            
                        </a>
                    </li>
                    <?php
                }
                ?>

            </ul>
        </nav>
        <!-- /main-nav -->
    </div>
</div>
<!-- END LEFT SIDEBAR -->
