<?php
ob_start();
if ($_POST) {
    include './shreeLib/DBAdapter.php';
    $dba = new DBAdapter();
    $_POST['user_pass'] = md5($_POST['user_pass']);
    $msg;
    $data = $dba->getRow("create_user", array("*"), "user_login_username='" . $_POST['user_username'] . "' and user_login_password='" . $_POST['user_pass'] . "'");
    print_r($data);
    if (!empty($data)) {
        if ($_POST['user_username'] === $data[0][6] && $_POST['user_pass'] === $data[0][7]) {

            $data1 = $dba->getRow("create_branch INNER JOIN create_user ON create_branch.id=create_user.branch_id", array("create_branch.branch_status"), "create_branch.branch_status='true' AND create_user.id=" . $data[0][0] . " GROUP BY create_branch.id");
            if ($data1[0][0] == 'true') {
                session_start();
                $_SESSION['user_login_username'] = $data[0][6];
                $_SESSION['user_id'] = $data[0][0];
                // $_SESSION['party_id'] = 1;
                header("Location:Dashboard.php");
            } else {
                $msg = "Your Branch is Disable!";
            }
        } else {
            $msg = "Authentication Fail!";
        }
    } else {
        $msg = "Authentication Fails!";
    }
}
?>
<html lang="en" class="no-js">
    <head>
        <title>Login | Blue Parl Import Export</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Blue Parl Import Export">
        <meta name="author" content="LPK Technosoft">
        <!-- CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/main.css" rel="stylesheet" type="text/css">
        <!--[if lte IE 9]>
         <link href="assets/css/main-ie.css" rel="stylesheet" type="text/css" />
         <link href="assets/css/main-ie-part2.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/kingadmin-favicon144x144.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/kingadmin-favicon114x114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/kingadmin-favicon72x72.png">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="assets/ico/kingadmin-favicon57x57.png">
        <link rel="shortcut icon" href="assets/ico/favicon.png">
    </head>

    <body>
        <div class="wrapper full-page-wrapper page-auth page-login text-center">
            <div class="inner-page">
                <div class="logo">
                    <a href="index.php"><h1>Welcome to Blue Parl Import Export</h1></a>
                </div>
                <div class="login-box center-block">
                    <form class="form-horizontal" method="post" role="form">
                        <p class="title">Login</p>
                        <div class="form-group">
                            <label for="username" class="control-label sr-only">Username</label>
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input type="text" placeholder="username" id="user_username" name="user_username" class="form-control" required>
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                        <label for="password" class="control-label sr-only">Password</label>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input type="password" placeholder="password" name="user_pass" id="password" class="form-control" required>
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-custom-primary btn-lg btn-block btn-auth"><i class="fa fa-arrow-circle-o-right"></i> Login</button>
                    </form>
                    <div class="text-danger">
                        <?php
                        if ($_POST) {
                            echo $msg;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <!-- Javascript -->

    </body>
</html>
