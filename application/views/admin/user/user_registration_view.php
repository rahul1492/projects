 <!-- BEGIN Content -->
<div id="main-content">
<!-- BEGIN Page Title -->

<style type="text/css">
.box-content.posn-retv{position: relative;}
  .form-horizontal .control-label{padding-top: 0px;}
  
}
</style>

<div class="page-title">
    <div>
        <h1><i class="fa fa-user"></i> View user details </h1>
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
            
            <a href="<?php echo base_url().ADMIN_CTRL;?>/user/manage"> Manage Users</a>
            <span class="divider"><i class="fa fa-angle-right"></i></span>
        </li>
        <li class="active"> User Registration </li>
    </ul>
</div>
<!-- END Breadcrumb -->
 <?php
        if($this->session->flashdata('del_success')!='')
        {
    ?>
            <div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Success!</strong><?php echo $this->session->flashdata('del_success'); ?>
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

<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i>Personal Information </h3>
               <!--  <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                </div> -->
            </div>
      <div class="box-content">
      
       <?php 
        if(count($view_user_registration_show)>0)
        {
       ?>   

        
        <form action="<?php echo base_url().ADMIN_CTRL;?>/user_registration/edit/<?php echo $view_user_registration_show[0]['id'];?>" id="validation-form" class="form-horizontal" method="post" > 
           <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="firstname">First Name</label>
              <div class="col-sm-9 col-lg-9 controls">
                <?php echo $view_user_registration_show[0]['user_firstname'];?>
                <!--  <input class="form-control"  type="text" name="firstname" id="firstname" data-rule-required='true' value="<?php echo $view_user_registration_show[0]['user_firstname'];?>"/> -->
               
              </div>
           </div>
           <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="lastname">Middle Name</label>
              <div class="col-sm-9 col-lg-9 controls">
              <?php echo $view_user_registration_show[0]['user_middlename'];?>
               <!--   <input class="form-control"  type="text" name="middlename" id="middlename" value="<?php echo $view_user_registration_show[0]['user_middlename'];?>"/> -->
               
              </div>
           </div>
           <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="lastname">Last Name</label>
              <div class="col-sm-9 col-lg-9 controls">
                <?php echo $view_user_registration_show[0]['user_lastname'];?>
                <!--  <input class="form-control"  type="text" name="lastname" id="lastname" data-rule-required='true' value="<?php echo $view_user_registration_show[0]['user_lastname'];?>"/> -->
               
              </div>
           </div>
           
            <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="email">Email Id</label>
              <div class="col-sm-9 col-lg-9 controls">
              <?php echo $view_user_registration_show[0]['user_email'];?>
              <!--    <input class="form-control"  disabled="" readonly="" type="text" name="email" id="email" value="<?php echo $view_user_registration_show[0]['user_email'];?>"/> -->
              </div>
           </div>

           <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="birthdate">Birth Date</label>
              <div class="col-sm-9 col-lg-9 controls">
              <?php echo date('d-m-Y',strtotime($view_user_registration_show[0]['user_birthdate']));?>
                 <!-- <input class="form-control"  type="text" name="birthdate" id="birthdate" value="<?php echo date('d-m-Y',strtotime($view_user_registration_show[0]['user_birthdate']));?>"/> -->
              </div>
           </div>

           <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="gender" readonly="true">Gender</label>
              <div class="col-sm-9 col-lg-9 controls">
              <?php echo $view_user_registration_show[0]['user_gender'];?>

               <!--  <select name="gender" id="gender" class="form-control">
                  <option <?php if($view_user_registration_show[0]['user_gender']== 'Male'){ echo ' selected ="selected"';} ?> >Male</option>
                  <option <?php if($view_user_registration_show[0]['user_gender']== 'Female'){ echo ' selected ="selected"';} ?> >Female</option>
                </select> -->
                 
              </div>
           </div>

          
           <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="phone_number">Phone No</label>
              <div class="col-sm-9 col-lg-9 controls">
              <?php echo $view_user_registration_show[0]['user_phonenumber'];?>
               <!--   <input class="form-control" type="text" name="phone_number" id="phone_number"   value="<?php echo $view_user_registration_show[0]['user_phonenumber'];?>"/> -->
              </div>
           </div>
          
          <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="mobile_number">Mobile No</label>
              <div class="col-sm-9 col-lg-9 controls">
                <?php echo $view_user_registration_show[0]['user_mobilenumber'];?>
                 <!-- <input class="form-control"  type="text" name="mobile_number" id="mobile_number"   value="<?php echo $view_user_registration_show[0]['user_mobilenumber'];?>"/> -->
              </div>
           </div>

           <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">

             <!--  <button type="button" name="edit_user" id="edit_user" class="btn btn-primary"><i class="fa fa-check"></i> Back</button>
            -->        
        <a href="<?php echo $_SERVER['HTTP_REFERER'];?>" class="btn btn-primary">Back</a></button>
           
            </div>
          </div>

      </form>


      <?php
        }
      ?>
      

      
    </div>
  </div>
 </div>
</div>


<!-- <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i>Addresses </h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="box-content">
  <?php //echo '<pre>'; print_r($view_user_registration_address);die();?>
  <?php 
  if(count($view_user_registration_address)>0)
  {

  foreach ($view_user_registration_address as $key => $value) {
  ?>   

     <form action="#" id="validation-form" class="form-horizontal" method="post" > 
      
         <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" for="address1">Address Line One</label>
            <div class="col-sm-9 col-lg-9 controls">
            
               <input class="form-control"  disabled="" readonly="" type="text" name="address1" id="address1" value="<?php echo $value['user_address_line1'];?>"/>
             
            </div>
         </div>
         <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" for="lastname">Address Line Two</label>
            <div class="col-sm-9 col-lg-9 controls">
            
               <input class="form-control"  disabled="" readonly="" type="text" name="address2" id="address2" value="<?php echo $value['user_address_line2'];?>"/>
             
            </div>
         </div>
         <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" for="city">City</label>
            <div class="col-sm-9 col-lg-9 controls">
            
               <input class="form-control"  disabled="" readonly="" type="text" name="city" id="city" value="<?php echo $value['city_name'];?>"/>
             
            </div>
         </div>
         
          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" for="state">State</label>
            <div class="col-sm-9 col-lg-9 controls">
               <input class="form-control"  disabled="" readonly="" type="text" name="state" id="state" value="<?php echo $value['state_name'];?>"/>
            </div>
         </div>

         <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" for="country">Country</label>
            <div class="col-sm-9 col-lg-9 controls">
               <input class="form-control"  disabled="" readonly="" type="date" name="country" id="country" value="<?php echo $value['country_name'];?>"/>
            </div>
         </div>

         <br/>
         <hr/>
        

              <?php 
              }
              ?>


          <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                 <a href ="<?php echo base_url().ADMIN_CTRL;?>/user_registration/manage"><button type="button" class="btn btn-primary"><i class="fa fa-mail-reply"></i> Go Back</button></a>
              </div>
             </div>
                  </form>
           <?php   
           }  
           else
           {
            echo "<b>No Address Found.</b>";
           } 
           ?> 

            </div>
        </div>
    </div>
</div> -->

<script type="text/javascript">
   jQuery(document).ready(function(){
    
         jQuery("#birthdate").datepicker({
        // dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange:"1950:"+(new Date).getFullYear()
         });
      });
</script>
               
               
                <!-- END Main Content -->