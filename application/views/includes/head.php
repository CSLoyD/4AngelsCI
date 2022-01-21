<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="">

    <!-- Favicon icon -->

    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>assets/build/images/icon.png">

    <title><?php echo $title." | 4Angels Healthcare Staffing" ?></title>

	<link rel="canonical" href="https://www.wrappixel.com/templates/adminwrap/" />

    <!-- Bootstrap Core CSS -->

    <link href="<?php echo base_url() ?>assets/build/css/bootstrap.min.css" rel="stylesheet">



    <?php

        $route = $this->router->fetch_class();


        if ($route == 'reservationcalendar') { ?>

            <!-- Calendar CSS -->

        <link href="<?php echo base_url() ?>assets/calendar/dist/fullcalendar.css" rel="stylesheet" />

    <?php } ?>

    <!-- Datatables CSS -->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/build/css/responsive.bootstrap4.min.css">
    <link href="<?php echo base_url() ?>assets/build/css/select2.min.css" rel="stylesheet">
    <!-- Custom CSS -->

    <link href="<?php echo base_url() ?>assets/build/css/style.css" rel="stylesheet">


    <!-- <link href="</?php echo base_url() ?>assets/build/css/pages/icon-page.css" rel="stylesheet"> -->

    <!-- You can change the theme colors from here -->

    <link href="<?php echo base_url() ?>assets/build/css/colors/default.css" id="theme" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->

    <?php

        __load_assets__($__assets__,'css');

    ?>
    <?php

    $curURL = $_SERVER['REQUEST_URI'];
    if (strpos($curURL, 'viewScheduleCalendar') !== false) { ?>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/locales-all.min.js'></script>

    <?php } ?>

</head>



<body class="fix-header card-no-border fix-sidebar">

    <!-- ============================================================== -->

    <!-- Preloader - style you can find in spinners.css -->

    <!-- ============================================================== -->

    <div class="preloader">

        <div class="loader">

            <div class="loader__figure"></div>

            <p class="loader__label">4Angels Healthcare Staffing</p>

        </div>

    </div>

    <!-- ============================================================== -->

    <!-- Main wrapper - style you can find in pages.scss -->

    <!-- ============================================================== -->

    <div id="main-wrapper">

        <!-- ============================================================== -->

        <!-- Topbar header - style you can find in pages.scss -->

        <!-- ============================================================== -->

        <header class="topbar">

            <nav class="navbar top-navbar navbar-expand-md navbar-light">

                <!-- ============================================================== -->

                <!-- Logo -->

                <!-- ============================================================== -->

                <div class="navbar-header">

                    <a class="navbar-brand" href="<?php echo base_url(); ?>">

                        <!-- Logo icon --><b>

                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->

                            <!-- Dark Logo icon -->

                            <img src="<?php echo base_url()?>assets/build/images/main-logo.png" alt="logo" class="dark-logo" />

                            <!-- Light Logo icon -->

                            <img src="<?php echo base_url()?>assets/build/images/icon.png" alt="logo" class="light-logo" />

                        </b>

                </div>

                <!-- ============================================================== -->

                <!-- End Logo -->

                <!-- ============================================================== -->

                <div class="navbar-collapse">

                    <!-- ============================================================== -->

                    <!-- toggle and nav items -->

                    <!-- ============================================================== -->

                    <ul class="navbar-nav mr-auto">

                        <!-- This is  -->

                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="sl-icon-menu"></i></a> </li>

                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="sl-icon-menu"></i></a> </li>

                    </ul>

                    <!-- ============================================================== -->

                    <!-- User profile and search -->

                    <!-- ============================================================== -->

                    <ul class="navbar-nav my-lg-0">

                        <!-- Profile -->

                        <!-- ============================================================== -->

                        <li class="nav-item dropdown u-pro">

                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                <i class="icon-Bell"></i>
                                <div class="notify">
                                <span class="heartbit"></span> <span class="point"></span>
                                </div>
                            </a>

                            <div class="dropdown-menu mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center ps-container ps-theme-default" data-ps-id="111903c0-65b8-e383-6244-373efadc88c2">
                                        <!-- Message -->
                                        <div id="notification-dis"></div>
                                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);">
                                        <strong>Check all notifications</strong>
                                        <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_myProfile" class="btn-profile" data-id="<?php echo $_SESSION['user_id']; ?>">MY PROFILE</a>

                            <a href="<?php echo base_url('logout') ?>" class="btn-logout">LOGOUT</a>

                            <!-- <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""><i class="fas fa-sign-out"></i> <span class="hidden-md-down">LOGOUT</span> </a> -->

                        </li>

                    </ul>

                </div>

            </nav>

        </header>

        <!-- ============================================================== -->

        <!-- End Topbar header -->

        <!-- ============================================================== -->

        <!-- ============================================================== -->

        <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <!-- ============================================================== -->

        <aside class="left-sidebar">

            <!-- Sidebar scroll-->

            <div class="scroll-sidebar">

                <!-- Sidebar navigation-->

                <nav class="sidebar-nav">



                    <ul id="sidebarnav">

                        <li> <a class="waves-effect waves-dark user-prof" href="javascript:void(0);" aria-expanded="false"><i><img class="app-sidebar__user-avatar" src="<?php echo base_url('assets/build/images/profile.png') ?>" width="35" alt="User Image"></i><span class="hide-menu app-sidebar__desc"><?php echo ($_SESSION['user_type'] == 1)?'Administrator':$profile->firstname.' '.$profile->lastname; ?></span></a></li>

                        <li> <a class="waves-effect waves-dark" href="<?php echo base_url('employees')?>" aria-expanded="false"><i class="icon-Doctor"></i><span class="hide-menu">Employees</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="<?php echo base_url('users')?>" aria-expanded="false"><i class="icon-User"></i><span class="hide-menu">Users</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="<?php echo base_url('facilities')?>" aria-expanded="false"><i class="icon-Building"></i><span class="hide-menu">Facilities</span></a></li>
                        <li> <a class="waves-effect waves-dark" href="<?php echo base_url('attendance')?>" aria-expanded="false"><i class="icon-Calendar"></i><span class="hide-menu">Attendance</span></a></li>


                    </ul>

                </nav>

                <!-- End Sidebar navigation -->

            </div>

            <!-- End Sidebar scroll-->

        </aside>

        <!-- ============================================================== -->

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- ============================================================== -->

        <!-- ============================================================== -->

        <!-- Page wrapper  -->

        <!-- ============================================================== -->

        <div class="page-wrapper">

<!-- =============================My Profile Modal================================= -->
<div id="modal_myProfile" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> Update Profile</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updateProfile" action="" method="post">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input type="text" class="form-control" name="upfirstname" placeholder="Enter First Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="uplastname" placeholder="Enter Last Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="text" class="form-control" name="upusername" placeholder="Enter Username Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email Address</label>
                                    <input type="email" class="form-control" name="upemail" placeholder="Enter Email Address Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control" name="uppassword" placeholder="Password Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="upcpassword" placeholder="Confirm Password Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="tbl_user_id">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-user"></i> Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>

<!-- End of My Profile Modal -->
