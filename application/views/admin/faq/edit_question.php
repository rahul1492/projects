  <!-- BEGIN Content -->
  <div id="main-content">
    <!-- BEGIN Page Title -->
    <div class="page-title">
      <div>
        <h1><i class="fa fa-sitemap"></i> <?php echo isset($page_name)? $page_name:'Demo Page'; ?> </h1>
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
          
          <a href="<?php echo base_url().ADMIN_CTRL;?>/category"><?php echo isset($module_name)? $module_name:'Demo Page'; ?></a>
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
    if(count($question)>0)
    {
     ?>
     <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-title">
            <h3><i class="fa fa-bars"></i> Edit category</h3>
          </div>
          <div class="box-content">
           <form action="<?php echo base_url().ADMIN_CTRL;?>/faq/edit/<?php echo base64_encode($question[0]['id']);?>" id="validation-form" class="form-horizontal" method="post" >
             
             <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="question"> Question*</label>
              <div class="col-sm-9 col-md-4 controls">
                
               <input class="form-control show-tooltip" type="text" name="question" id="question" value="<?php echo $question[0]['question'];?>" data-rule-required="true" data-original-title="Edit Question" data-trigger="hover"/>
               <div style="color:red;">
                <?php echo form_error('question');?>
              </div>   

            </div>
          </div>

          <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="answer"> Answer*</label>
              <div class="col-sm-9 col-md-4 controls">
                
               <input class="form-control show-tooltip" type="text" name="answer" id="answer" value="<?php echo $question[0]['answer'];?>" data-rule-required="true" data-original-title="Edit Answer" data-trigger="hover"/>
               <div style="color:red;">
                <?php echo form_error('answer');?>
              </div>   

            </div>
          </div>
          
          
          <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
              <input type="hidden" name="record_id" id="record_id" value="<?php echo $question[0]['id'];?>"/>
              <button type="submit" name="edit_question" id="edit_category" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
              <a type="button" class="btn btn-primary" href="<?php echo base_url().'admin/faq' ?>"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
          </div>  
          <?php $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()); ?>

<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" /> 
          </form>                            
        </div>
      </div>
    </div>
  </div>

  <?php
}
?>             
