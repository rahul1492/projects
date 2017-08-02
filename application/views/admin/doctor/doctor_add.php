<!-- BEGIN Content -->
<div id="main-content">
    <!-- BEGIN Page Title -->
    <div class="page-title">
        <div>
            <h1><i class="fa fa-user-md"></i> Doctor Registration </h1>
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
            <li>
                <a href="<?php echo base_url().ADMIN_CTRL;?>/doctor/manage">Manage Doctors</a>
                <span class="divider"><i class="fa fa-angle-right"></i></span>
            </li>

            <li class="active">Add Doctor</li>
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
            <strong>Success!</strong><?php echo $this->session->flashdata('success'); ?>
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

    <?php
    if($error!='')
    {
        ?>
        <div class="alert alert-danger">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Error!</strong><?php echo $error; ?>
        </div>
        <?php
    } 
    ?>
    <!-- message box fields end -->

    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>Add Doctor</h3>
                </div>
                <div class="box-content">
                    <form action="<?php echo base_url().ADMIN_CTRL;?>/doctor/add" id="validation-form" class="form-horizontal" method="post">
                        <div class="col-sm-12">
                            <?php $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()); ?>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="color_name">First Name<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">

                                        <input class="form-control show-tooltip" value="<?php echo set_value('first_name'); ?>" type="text" name="first_name" id="first_name" data-rule-required="true" data-original-title="Add First Name" data-trigger="hover"/>
                                        <div style="color:red;">
                                            <?php echo form_error('first_name');?>
                                        </div>   
                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="last_name">Last Name<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">
                                        <input class="form-control show-tooltip" value="<?php echo set_value('last_name'); ?>" type="text" name="last_name" id="last_name" data-rule-required="true" data-original-title="Add Last Name" data-trigger="hover"/>
                                        <div style="color:red;">
                                            <?php echo form_error('last_name');?>
                                        </div>   

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="email_id">Email Id<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">

                                        <input class="form-control show-tooltip" value="<?php echo set_value('email_id'); ?>" type="text" name="email_id" id="email_id" data-rule-required="true" data-rule-email="true" data-original-title="Add Email Id" data-trigger="hover"/>
                                        <div style="color:red;">
                                            <?php echo form_error('email_id');?>
                                        </div>   

                                    </div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="email_id">Password<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">
                                        <input class="form-control show-tooltip" value="<?php echo set_value('password'); ?>" type="password" name="password" id="password" data-rule-required="true" data-original-title="Add Password" data-trigger="hover"/>
                                        <div style="color:red;">
                                            <?php echo form_error('password');?>
                                        </div>   

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 col-lg-3 control-label">State<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">
                                        <select class="form-control" data-rule-required="true" data-original-title="Select State" id="state" name="state" onchange="getcity(this);">
                                            <option value="">Select State</option>
                                            <?php
                                            foreach($state_data as $state)
                                                echo "<option value=".$state['id'].">".$state['state_name']."</option>";
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 col-lg-3 control-label">City<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">
                                        <select class="form-control" data-rule-required="true" data-original-title="Select City" id="city" name="city">
                                            <option value="">Select State First</option>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="last_name">Gender<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">
                                        <select class="form-control show-tooltip" name="gender" id="gender" data-rule-required="true" data-original-title="Select Gender" data-trigger="hover">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <div style="color:red;">
                                            <?php echo form_error('gender');?>
                                        </div>   
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="email_id">Phone<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">

                                        <input class="form-control show-tooltip" value="<?php echo set_value('phone'); ?>" type="text" name="phone" id="phone" data-rule-required="true" data-original-title="Add Phone no" data-trigger="hover"/>
                                        <div style="color:red;">
                                            <?php echo form_error('phone');?>
                                        </div>   

                                    </div>
                                </div> 
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group col-lg-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="email_id">Address<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">

                                        <input class="form-control show-tooltip" value="<?php echo set_value('addr_line_1'); ?>" type="text" name="addr_line_1" id="addr_line_1" data-rule-required="true" data-original-title="Add Address" data-trigger="hover"/>
                                        <div style="color:red;">
                                            <?php echo form_error('addr_line_1');?>
                                        </div>   

                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="email_id">Pin Code<span style="color: red;">*</span></label>
                                    <div class="col-sm-9 col-lg-9 controls">
                                        <input class="form-control show-tooltip" value="<?php echo set_value('pin_code'); ?>" type="text" name="pin_code" id="pin_code" data-rule-required="true" data-original-title="Add Pin Code" data-trigger="hover"/>
                                        <div style="color:red;">
                                            <?php echo form_error('pin_code');?>
                                        </div>   
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-12">

                                <div class="form-group col-lg-6">
                                    <label class="col-sm-4 col-lg-3 control-label" for="email_id">Street/Town</label>
                                    <div class="col-sm-9 col-lg-9 controls">
                                        <input class="form-control show-tooltip" value="<?php echo set_value('addr_line_2'); ?>" type="text" name="addr_line_2" id="addr_line_2" data-original-title="Add Street/Town" data-trigger="hover"/>
                                        <div style="color:red;">
                                            <?php echo form_error('addr_line_2');?>
                                        </div>   
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-6 col-lg-10 col-lg-offset-5">
                                    <button type="submit" name="add_user" id="add_user" class="btn btn-primary"><i class="fa fa-check"></i> Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            function getcity(id)
            {
                if(id.value != '')
                {
                    $.ajax({
                        url: '<?= base_url().'admin/doctor/getcity_records'?>',
                        type:'POST',
                        dataType: 'json',
                        data: "state_id="+id.value+"&<?=$csrf['name'];?>=<?=$csrf['hash'];?>",
                        success:function(response){
                            var trHTML = '';

                            trHTML = '<option value="">Select City</option>';

                            $.each(response, function (i, item) {

                                trHTML += '<option value="'+ response[i].city_id +'">' + response[i].city_name + '</option>';
                            });

                            document.getElementById("city"). innerHTML= trHTML;
                        }
                    });
                }
            }
        </script>
<!-- END Main Content -->