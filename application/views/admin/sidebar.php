<?php
$class  = $this->router->fetch_class();
$method = $this->router->fetch_method();
?>
<div class="container" id="main-container">
    <div id="sidebar" class="navbar-collapse collapse">
        <!-- BEGIN Navlist -->
        <ul class="nav nav-list">
            <!-- END Search Form -->
            <li <?php if($class=='dashboard'){ echo 'class="active"';}?>>
                <a href="<?php echo base_url().ADMIN_CTRL;?>/dashboard">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li <?php if($class=='account' || $class=='model' ||  $class=='color' && ($method =='add' || $method =='edit' || $method =='manage')){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-cog "></i>
                    <span>Account Setting</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">
                    <li <?php if($class=='account' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/account">Manage</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='category' || $class=='model' ||  $class=='color' && ($method =='add' || $method =='edit' || $method =='manage')){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-sitemap "></i>
                    <span>Category</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">

                    <li <?php if($class=='category' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/category">Manage</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='petage' || $class=='petcolor' ||  $class=='pethair' ||  $class=='petproduct' ||  $class=='petbreed'){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-cog "></i>
                    <span>Pet Setting</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">
                    <li <?php if($class=='account' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/petcolor">Pet Color</a></li>
                    <li <?php if($class=='account' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/petbreed">Pet Breed</a></li>
                    <li <?php if($class=='account' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/petage">Pet Age</a></li>
                    <li <?php if($class=='account' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/pethair">Pet Hair</a></li>
                    <li <?php if($class=='account' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/petproduct">Pet Product</a></li>

                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='pets'){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-buysellads"></i>
                    <span>Posted Ad</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">
                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/pets">Own/Adopt Pets</a></li>
                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/pets/breedpets">Breed Pets</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='city'|$class=='state'){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-globe"></i>
                    <span>Location</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">
                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/state">States</a></li>
                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/city">Cities</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='email' || $class=='model' ||  $class=='color' && ($method =='add' || $method =='edit' || $method =='manage')){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-envelope"></i>
                    <span>Email Template</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">
                    <li <?php if($class=='model' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/email/manage">Manage</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='user' || $class=='model' ||  $class=='color' && ($method =='add' || $method =='edit' || $method =='manage')){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">
                    <li <?php if($class=='model' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/user/manage">Manage</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='doctor' || $class=='model' ||  $class=='color' && ($method =='add' || $method =='edit' || $method =='manage')){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-user-md"></i>
                    <span>Doctors</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">
                    <li <?php if($class=='doctor' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/doctor/add">Add</a></li>
                    <li <?php if($class=='doctor' && ($method =='manage' || $method=='edit')){ echo 'class="active"';}?>><a href="<?php echo base_url().ADMIN_CTRL;?>/doctor/manage">Manage</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='contact'){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-phone"></i>
                    <span>Contact Enquiry</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <!-- BEGIN Submenu -->
                <ul class="submenu">
                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/contact">Manage</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='faq'){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-question-circle"></i>
                    <span>Faq</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/faq">Manage</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <li <?php if($class=='newsletter'){ echo 'class="active"';}?>>
                <a href="#" class="dropdown-toggle">
                    <i class="fa fa-newspaper-o"></i>
                    <span>News Letter</span>
                    <b class="arrow fa fa-angle-right"></b>
                </a>
                <ul class="submenu">
                    <!-- BEGIN Submenu -->

                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/newsletter">Manage</a></li>
                </ul>
                <!-- END Submenu -->
            </li>
            <div id="sidebar-collapse" class="visible-lg">
                <i class="fa fa-angle-double-left"></i>
            </div>
            <!-- END Sidebar Collapse Button -->
        </div>
<!-- END Sidebar -->