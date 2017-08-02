  <!-- BEGIN Content -->
  <div id="main-content">
    <!-- BEGIN Page Title -->
    <div class="page-title">
      <div>
        <h1><i class="fa fa-envelope"></i> <?php echo isset($page_name)? $page_name:'Demo Page'; ?> </h1>
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
          
          <a href="<?php echo base_url().ADMIN_CTRL;?>/email/manage"><?php echo isset($module_name)? $module_name:'Demo Page'; ?></a>
          <span class="divider"><i class="fa fa-angle-right"></i></span>
        </li>
        
        <li class="active"><?php echo isset($page_name)? $page_name:'Demo Page'; ?></li>
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
    if(count($email)>0)
    {
     ?>
     <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-title">
            <h3><i class="fa fa-bars"></i> Edit Email Templete</h3>
          </div>
          <div class="box-content">
           <form action="<?php echo base_url().ADMIN_CTRL;?>/email/edit/<?php echo base64_encode($email[0]['id']);?>" id="validation-form" class="form-horizontal" method="post" >

             <?php  $csrf = array(
               'name' => $this->security->get_csrf_token_name(),
               'hash' => $this->security->get_csrf_hash()); ?>

               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
               
               <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="template_name">Email Template Name<span style="color:red">*</span></label>
                <div class="col-sm-9 col-md-4 controls">
                  
                 <input class="form-control show-tooltip" type="text" name="template_name" id="template_name" value="<?php echo $email[0]['template_name'];?>" data-rule-required="true" data-original-title="Email Template Name" data-trigger="hover"/>
                 <div style="color:red;">
                  <?php echo form_error('template_name');?>
                </div>   

              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="template_from">Email Template From<span style="color:red">*</span></label>
              <div class="col-sm-9 col-md-4 controls">
                
               <input class="form-control show-tooltip" type="text" name="template_from" id="template_from" value="<?php echo $email[0]['template_from'];?>" data-rule-required="true" data-original-title="Email Template From" data-trigger="hover"/>
               <div style="color:red;">
                <?php echo form_error('template_from');?>
              </div>   

            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" for="template_from_mail">Email Template From Email<span style="color:red">*</span></label>
            <div class="col-sm-9 col-md-4 controls">
              
             <input class="form-control show-tooltip" type="text" name="template_from_mail" id="template_from_mail" value="<?php echo $email[0]['template_from_mail'];?>" data-rule-requiredtemplate_from_mail="true" data-original-title="Email Template From Email" data-rule-required="true"  data-trigger="hover"/>
             <div style="color:red;">
              <?php echo form_error('template_from_mail');?>
            </div>   

          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-3 col-lg-2 control-label" for="template_subject">Email Template Subject<span style="color:red">*</span></label>
          <div class="col-sm-9 col-md-4 controls">
            
           <input class="form-control show-tooltip" type="text" name="template_subject" id="template_subject" value="<?php echo $email[0]['template_subject'];?>" data-rule-requiredtemplate_from_mail="true" data-original-title="Email Template Subject" data-trigger="hover" data-rule-required="true" />
           <div style="color:red;">
            <?php echo form_error('template_subject');?>
          </div>   

        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 col-lg-2 control-label">Email Template Body </label>
        <div class="col-sm-6 col-lg-7 controls">
          <textarea class="form-control col-md-12 ckeditor" name="body" id="body" data-original-title="Email Template Body " data-trigger="hover"/><?php if(isset($email[0]['template_html'])) { echo $email[0]['template_html']; } ?></textarea>
          <div style="color:red;">
            <?php echo form_error('body');?>
          </div> 
        </div>
      </div> 


      <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
          <input type="hidden" name="record_id" id="record_id" value="<?php echo $email[0]['id'];?>"/>
          <button type="submit" name="edit_email" id="edit_email" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
          <a type="button" class="btn btn-primary" href="<?php echo base_url().'admin/email/manage' ?>"><i class="fa fa-arrow-left"></i> Back</a>
          
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

<!--  <script type="text/javascript">
                jQuery(document).ready(function() {

                        CKEDITOR.replace('about');

                  $('#validation-form1').validate({
                      ignore: [],         
                      rules: {
                                answer: {
                                    required: function() 
                                    {
                                      CKEDITOR.instances.about.updateElement();
                                    }
                                  }
                              },
                              messages: {
                                answer: "This Field Is Required"
                              },
                              /* use below section if required to place the error*/
                              errorPlacement: function(error, element) 
                              {
                                  if (element.attr("name") == "about") 
                                 {
                                  error.insertBefore("textarea#about");
                                  }
                                   else {
                                  error.insertBefore(element);
                                  }
                              }
                    });
                 });
</script> -->