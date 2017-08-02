 <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-cog"></i>Edit Pet Product</h1>
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
                      
                            <a href="<?php echo base_url().ADMIN_CTRL;?>/petproduct">Manage Pet Product</a>
                           
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
                        <div class="box">
                        <div class="box-title">
                        <h3><i class="fa fa-bars"></i> Edit Product</h3>
                    </div>
                               <!--  <ul>
                                    <li><a href="" class="acti">Account Setting</a></li>
                                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/prize" >Pricing Setting</a></li>
                                                 
                                </ul> -->
                                 <div class="clearfix"></div>
                        </div>
                               
                 <div class="box">
                            <?php //echo '<pre>'; print_r($arr_account_setting);die(); ?>
                             <?php if(isset($arr_pet_product) && sizeof($arr_pet_product)>0)
                            {
                                ?>
                           
                            <div class="box-content">
                                <form action="<?php echo base_url().ADMIN_CTRL;?>/petproduct/edit/<?php echo $arr_pet_product[0]['id'];?>" method="post" id="validation-form" name="frm_admin_profile" enctype="multipart/form-data" class="form-horizontal">

                                     <?php  $csrf = array(
                                       'name' => $this->security->get_csrf_token_name(),
                                       'hash' => $this->security->get_csrf_hash()); ?>

                                         <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="form-group">
                                      <label class="col-sm-3 col-lg-2 control-label">Image Upload</label>
                                      <div class="col-sm-9 col-lg-10 controls">
                                         <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                               <img src="<?php echo base_url();?>uploads/admin/product_image/<?php echo ($arr_pet_product[0]['product_image'])? $arr_pet_product[0]['product_image']:'no-image-icon.jpg'  ?>" alt="" />
                                            </div>
                                            <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                            <div>
                                               <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                               <span class="fileupload-exists">Change</span>
                                               <input type="file" name="profile_img" id="profile_img" class="default"  /></span>
                                               <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                         </div>
                                         </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label">Product Name<span style="color:red">*</span></label>
                                        <div class="col-sm-4 col-lg-4 controls">
                                            <input class="form-control show-tooltip" type="text" value="<?php if(isset($arr_pet_product[0]['product_name'])) { echo $arr_pet_product[0]['product_name']; } ?>" name="product_name" id="product_name" data-rule-required="true" data-original-title="Add Product Name" data-trigger="hover"/>
                                            <div style="color:red;">
                                                <?php echo form_error('product_name');?>
                                             </div>   
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label">Product Price<span style="color:red">*</span></label>
                                        <div class="col-sm-4 col-lg-4 controls">
                                            <input type="text" data-rule-required="true" value="<?php if(isset($arr_pet_product[0]['product_price'])) { echo $arr_pet_product[0]['product_price']; } ?>" name="price" class="form-control show-tooltip" data-original-title="Add Product Price" data-trigger="hover"/>
                                        <div style="color:red;">
                                                <?php echo form_error('price');?>
                                             </div> 
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label">About<span style="color:red">*</span></label>
                                        <div class="col-sm-4 col-lg-4 controls">
                                            <textarea rows="4" cols="50" data-rule-required="true" value="" name="about" class="form-control show-tooltip" data-original-title="Add About Details" data-trigger="hover"><?php if(isset($arr_pet_product[0]['product_description'])) { echo $arr_pet_product[0]['product_description']; } ?></textarea>
                                        <div style="color:red;">
                                                <?php echo form_error('about');?>
                                             </div> 
                                        </div>
                                    </div>
                                   
           

                                
                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                        <input type="hidden" name="record_id" id="record_id" value="<?php echo $arr_pet_product[0]['id'];?>"/>
                                            <input type="submit" name="edit_product" id="edit_product" value="Submit" class="btn btn-primary">
                                           <a href="<?php echo base_url().ADMIN_CTRL;?>/dashboard"> <button type="button" class="btn">Cancel</button></a>
                                        </div>
                                   </div>
                                </form>
                            </div>
                           <?php } ?>
                        </div>
                    </div>
                    </div>
