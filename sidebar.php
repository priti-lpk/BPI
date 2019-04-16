<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location:index.php');
}
?>

<div class="left side-menu">


    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu" id="side-menu">
            <li>
                <a href="Dashboard.php" class="waves-effect">
                    <i class="mdi mdi-home"></i><span> Dashboard </span>
                </a>
            </li>
            <?php
            include_once 'shreeLib/DBAdapter.php';
            include_once 'shreeLib/dbconn.php';
            $dba = new DBAdapter();
            $data1 = $dba->getRow("module", array("mod_master"), "1 group by mod_master");
            $count = count($data1);
            for ($i = 0; $i < $count; $i++) {
                ?>
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-clipboard"></i><span> <?= $data1[$i][0] ?> <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
                    <ul class="submenu">
                        <?php
                        $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);
                        $sql = "SELECT module.mod_name,module.mod_pagename,module.id FROM role_rights INNER JOIN module ON role_rights.mod_id= module.id WHERE ((role_rights.role_create=1 and role_rights.role_view=0) or (role_rights.role_create=1 and role_rights.role_view=1) or (role_rights.role_create=0 and role_rights.role_view=1) ) and role_rights.role_id=" . $data . " and module.mod_master='" . $data1[$i][0] . "' order by module.mod_order";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $uid = $row['mod_pagename'];
                            ?>
                            <li><a href="<?= $uid ?>"><?= $row['mod_name'] ?></a></li>
                            <?php
                        }
                        ?> 
                    </ul>
                </li> 
                <?php
            }
            ?>

            <?php
            $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);

            $sql = "select create_user.roles_id,role_master.role_name FROM create_user INNER JOIN role_master ON create_user.roles_id=role_master.id where create_user.roles_id=" . $data;
//                    echo $sql;
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $id = $row[1];
//echo $id;
            if ($id == 'Manager') {
                $id = $row['roles_id'];
//                        echo $id;
                ?>
                <li><a href="view/PartyQuotationMsg.php" class="waves-effect">Party Quatation Status</a></li>
                <li><a href="view/Allocated_inquiry.php" class="waves-effect">Allocated Inquiry</a></li>

            <?php } ?> 
            <li><a href="view/Send_party.php" class="waves-effect">Performa Invoice</a></li>
        </ul>

    </div>
    <!-- sidebar -->
    <div class="clearfix"></div>


    <!-- sidebar -left -->

</div>

