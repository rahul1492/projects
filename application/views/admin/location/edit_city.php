  <!-- BEGIN Content -->
  <div id="main-content">
    <!-- BEGIN Page Title -->
    <div class="page-title">
      <div>
        <h1><i class="fa fa-globe"></i> <?php echo isset($page_name)? $page_name:'Demo Page'; ?> </h1>
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
                <i class="fa fa-globe"></i>
                <a href="<?php echo base_url().ADMIN_CTRL;?>/city">Location</a>
                <span class="divider"><i class="fa fa-angle-right"></i></span>
            </li>
            <li class="active">
                <i class="fa fa-globe"></i>
                <a href="<?php echo base_url().ADMIN_CTRL;?>/city">Cities</a>
                <span class="divider"><i class="fa fa-angle-right"></i></span>
            </li>

            <li class="active"><i class="fa fa-globe"></i> Edit <?php echo isset($module_name)? $module_name:'Demo Page'; ?></li>
        </ul>
    </div>
    <!-- END Breadcrumb -->

    <?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-danger alert-dismissable fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Success!</strong> 
    </div>
    <?php  } ?>

    <?php if($this->session->flashdata('success')){ ?>

    <div class="alert alert-success alert-dismissable fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
    </div>
    <?php  } ?>
    <!-- BEGIN Main Content -->
    <?php
    if(count($city)>0)
    {
     ?>
     <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-title">
            <h3><i class="fa fa-bars"></i> Edit city</h3>
          </div>
          <div class="box-content">
           <form action="<?php echo base_url().ADMIN_CTRL;?>/city/edit/<?php echo $city[0]['city_id'];?>" id="validation-form" class="form-horizontal" method="post" >
             <?php  $csrf = array(
                   'name' => $this->security->get_csrf_token_name(),
                   'hash' => $this->security->get_csrf_hash()); ?>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

             <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="city_name"> City Name<span style="color: red">*</span></label>
              <div class="col-sm-9 col-md-4 controls">

               <input class="form-control show-tooltip" type="text" name="city_name" id="city_name" value="<?php echo $city[0]['city_name'];?>" data-rule-required="true" data-original-title="Edit city Name" data-trigger="hover"/>
               <div style="color:red;">
                <?php echo form_error('city_name');?>
              </div>   

            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label">Select State<span style="color: red">*</span></label>
            <div class="col-sm-9 col-lg-4 controls">
             <select class="form-control" data-placeholder="Choose a Category" tabindex="1" name="state" data-rule-required="true">
              <option value="">Select State</option>
              <?php if($states){
                foreach ($states as $state) { ?>
                <option value="<?php echo $state['id']; ?>" <?php echo ($state['id']==$city[0]['state_id'])? "selected='selected'":''; ?>><?php echo $state['state_name']; ?></option>
                <?php }
              } ?>
            </select>
            <div style="color:red;">
                <?php echo form_error('state');?>
              </div>  
          </div>
        </div>


        <div class="form-group">
          <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
            <input type="hidden" name="record_id" id="record_id" value="<?php echo base64_encode($city[0]['city_id']);?>"/>
            <button type="submit" name="edit_city" id="edit_city" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
            <a href="<?php echo base_url().ADMIN_CTRL;?>/city" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>

          </div>
        </div>                               
      </form>                            
    </div>
  </div>
</div>
</div>

<?php
}
?>             
