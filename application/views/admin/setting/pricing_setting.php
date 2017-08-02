 <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-cog"></i> Pricing Setting</h1>
                       <!--  <h4>Simple and advance form elements</h4> -->
                    </div>
                </div>
                <!-- END Page Title-->



                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo base_url().ADMIN_CTRL;?>/dashboard">Home</a>
                            <span class="divider"><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li class="active">
                            <a href="">Pricing Setting</a>
                           
                        </li>
                    </ul>
                </div>
                <!-- END Breadcrumb -->




                 <!-- message box fields start -->
                        
                        <?php
                            if($this->session->flashdata('success')!='')
                            {
                        ?>
                                <div class="alert alert-success">
                                    <button class="close" data-dismiss="alert">×</button>
                                    <strong></strong><?php echo $this->session->flashdata('success'); ?>
                                </div>
                        <?php
                            } 
                        ?>

                        <?php
                            if($this->session->flashdata('error')!='')
                            {
                        ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-dismiss="alert">×</button>
                                    <strong>Error!</strong><?php echo $this->session->flashdata('error'); ?>
                                </div>
                        <?php
                            } 
                        ?>

                     <!--    <?php
                            if($error!='')
                            {
                        ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-dismiss="alert">×</button>
                                    <strong>Error!</strong><?php echo $error; ?>
                                </div>
                        <?php
                            } 
                        ?> -->
                        <!-- message box fields end -->


                <!-- BEGIN Main Content -->
                <div class="row">
                    <div class="col-md-12">
                         <div class="tabing-section-order">
                               <ul>
                                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/account" >Account Setting</a></li>
                                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/prize" class="acti">Pricing Setting</a></li>
                                                 
                                </ul>
                                <div class="clearfix"></div>
                        </div>
                     <div class="box">
                            <?php //echo '<pre>'; print_r($arr_pricing_setting);die(); ?>
                            <?php if(isset($arr_pricing_setting) && sizeof($arr_pricing_setting)>0)
                            {
                                ?>
                            <div class="box-content">
                                <form action="<?php echo base_url().ADMIN_CTRL;?>/prize/edit" method="post" id="validation-form" name="frm_admin_profile" enctype="multipart/form-data" class="form-horizontal">


                                     <?php  $csrf = array(
                                       'name' => $this->security->get_csrf_token_name(),
                                       'hash' => $this->security->get_csrf_hash()); ?>

                                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                   
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label">Platinum Plan<span style="color:red">*</span></label>
                                        <div class="col-sm-4 col-lg-4 controls">
                                            <input class="form-control show-tooltip" type="text" value="<?php if(isset($arr_pricing_setting[0]['platinum'])) { echo $arr_pricing_setting[0]['platinum']; } ?>" name="platinum" id="platinum" data-rule-required="true" data-original-title="Add Platinum Plan" data-trigger="hover"/>
                                            <div style="color:red;">
                                                <?php echo form_error('platinum');?>
                                             </div>   
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label">Gold Plan<span style="color:red">*</span></label>
                                        <div class="col-sm-4 col-lg-4 controls">
                                            <input type="text" data-rule-required="true" value="<?php if(isset($arr_pricing_setting[0]['gold'])) { echo $arr_pricing_setting[0]['gold']; } ?>" name="gold" class="form-control show-tooltip" data-original-title="Add Gold Plan" data-trigger="hover"/>
                                        <div style="color:red;">
                                                <?php echo form_error('gold');?>
                                             </div> 
                                        </div>
                                    </div>
                                   
                                   
                                  
                                    
                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                           <a href="<?php echo base_url().ADMIN_CTRL;?>/dashboard"> <button type="button" class="btn">Cancel</button></a>
                                        </div>
                                   </div>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    </div>

        
                  
 <!-- END Main Content -->

