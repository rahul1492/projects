    <?php
if($this->session->userdata('admin_info') == "")
{
    redirect(base_url().ADMIN_CTRL.'/login');
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $page_title;?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <!-- image upload css-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/chosen-bootstrap/chosen.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/jquery-tags-input/jquery.tagsinput.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/jquery-pwstrength/jquery.pwstrength.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bootstrap-fileupload/bootstrap-fileupload.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bootstrap-duallistbox/duallistbox/bootstrap-duallistbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/dropzone/downloads/css/dropzone.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bootstrap-colorpicker/css/colorpicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bootstrap-timepicker/compiled/timepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/clockface/css/clockface.css" />
       <!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bootstrap-daterangepicker/daterangepicker.css" /> -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bootstrap-switch/static/stylesheets/bootstrap-switch.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/jquery-ui.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/style.css" type="text/css" />
        

        <!--base css styles-->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/font-awesome/css/font-awesome.min.css">

        <!--page specific css styles-->

        <!--flaty css styles-->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/flaty.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/flaty-responsive.css">

        <link rel="shortcut icon" href="<?php echo base_url();?>assets/admin/img/favicon.png">
        <style type="text/css">
            .error{
                color: #FF0000;
            }
        </style>

          <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/admin/js/jquery-ui.js"></script>

            <script type="text/javascript">
                var site_url = '<?php echo base_url().ADMIN_CTRL;?>';
            </script>
    </head>

  

    <body>

        <!-- BEGIN Navbar -->
        <div id="navbar" class="navbar">
            <button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
                <span class="fa fa-bars"></span>
            </button>
            <a class="navbar-brand" href="#">
                <small>
                    <i class="fa fa-desktop"></i>
                   101Tails Admin
                </small>
            </a>
            <?php  /*$arr_account_setting  = $this->Master_model->getRecords('tbl_account_setting');*/ ?>
            <!-- BEGIN Navbar Buttons -->
            <ul class="nav flaty-nav pull-right">
             

                <!-- BEGIN Button User -->
                <li class="user-profile">
                    <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                        <img class="nav-user-photo" src="<?php echo base_url();?>uploads/admin/profile_image/<?php echo $this->session->userdata('profile_image'); ?>" />
                        <span class="hhh" id="user_info">
                            <?php 
                                $admin_info = $this->session->userdata('admin_info');
                               
                                echo $admin_info['admin_username'];
                            ?>

                        </span>
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <!-- BEGIN User Dropdown -->
                    <ul class="dropdown-menu dropdown-navbar" id="user_menu">
                        <!--<li class="nav-header">
                            <i class="fa fa-clock-o"></i>
                            Logined From 20:45
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                Account Settings
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-user"></i>
                                Edit Profile
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-question"></i>
                                Help
                            </a>
                        </li>-->

                        <li class="divider visible-xs"></li>

                        <li class="visible-xs">
                            <a href="#">
                                <i class="fa fa-tasks"></i>
                                Tasks
                                <span class="badge badge-warning">4</span>
                            </a>
                        </li>
                        <li class="visible-xs">
                            <a href="#">
                                <i class="fa fa-bell"></i>
                                Notifications
                                <span class="badge badge-important">8</span>
                            </a>
                        </li>
                        <li class="visible-xs">
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                Messages
                                <span class="badge badge-success">5</span>
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo base_url().ADMIN_CTRL?>/password">
                                    <i class="fa fa-key"></i>
                                    Password Change
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().ADMIN_CTRL?>/dashboard/logout">
                                <i class="fa fa-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                    <!-- BEGIN User Dropdown -->
                </li>
                <!-- END Button User -->
            </ul>
            <!-- END Navbar Buttons -->
        </div>
        <!-- END Navbar -->