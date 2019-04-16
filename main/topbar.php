<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}
?>
<html>

    <head>
        <base href="http://localhost/bpiindia1/main/">
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <style>
            .user1{
                margin-top: 20px;
                color: #fff;
            }
        </style>
    </head>
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
<!--            <a href="index.php" class="logo">
                <span>
                    <img src="logo/logo.jpg" alt="" height="64">
                </span>
                <i>
                    <img src="logo/logo.jpg" alt="" height="62">
                </i>
            </a>-->
        </div>

        <nav class="navbar-custom">
            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li> 
                <li class="float-left">

                    <!--</button>-->
                </li>  
            </ul>
            <ul class="navbar-right d-flex list-inline float-right mb-0">                      
                <li class="dropdown notification-list">
                    <div class="dropdown notification-list nav-pro-img">
                        <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/users/user-4.jpg" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <!--<a class="dropdown-item" href="change_password.php"><i class="mdi mdi-account-circle m-r-5"></i>Change Password</a>-->
                            <!--<div class="dropdown-divider"></div>-->
                            <a class="dropdown-item text-danger" href="shreeLib/destroy.php"><i class="mdi mdi-power text-danger"></i>Logout</a>
                        <!--</div>-->                                                                    
                    </div>
                </li>
            </ul>
        </nav>

    </div>

