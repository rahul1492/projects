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
 		<h1><i class="fa fa-user"></i> <?php echo ($module_name)? $module_name:'Demo Page'; ?> </h1>
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
 			<i class="fa fa-phone"></i>
 			<a href="<?php echo base_url().ADMIN_CTRL;?>/contact">Contact Enquiry</a>
 			<span class="divider"><i class="fa fa-angle-right"></i></span>
 		</li>
 		<li class="active">View Enquiry</li>
 	</ul>
 </div>
 <!-- END Breadcrumb -->
 <!-- BEGIN Main Content -->
 <div class="row">
 	<div class="col-md-12">
 		<div class="box">
 			<div class="box-title">
 				<h3><i class="fa fa-bars"></i>Contact Enquiry </h3>

 			</div>
 			<div class="box-content">

 				<div class="row">
 					<div class="col-md-12"> 
 						<div class="row">
 							<div class="col-md-6">
 								<h3>
 									<span class="text-" ondblclick="scrollToButtom()" style="cursor: default;" title="Double click to Take Action">
 									</span>
 								</h3>
 							</div>
 							<div class="col-md-6">
 							</div>
 						</div>
 						<form method="POST" action="" class="form-horizontal" id="validation-form" novalidate="novalidate">
 							<div class="form-group"> 
 								<?php  $csrf = array(
 									'name' => $this->security->get_csrf_token_name(),
 									'hash' => $this->security->get_csrf_hash()); ?>

 									<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
 									<label class="col-sm-3 col-lg-2 control-label"></label>
 									<div class="col-sm-3 col-lg-3 controls">
 										<h4><b>Enquiry Details:</b></h4>
 									</div>
 								</div> 


 								<div class="form-group">
 									<label class="col-sm-3 col-lg-2 control-label" for="email_id">User Name</label>
 									<div class="col-sm-6 col-lg-4 controls">
 										<input class="form-control" name="user_name" id="user_name" value="<?php echo $enquiry[0]['user_name']; ?>" readonly="" style="background-color : white">
 									</div>
 								</div>
 								<div class="form-group">
 									<label class="col-sm-3 col-lg-2 control-label" for="email_id">User Email</label>
 									<div class="col-sm-6 col-lg-4 controls">
 										<input class="form-control" name="email" id="email" value="<?php echo $enquiry[0]['user_email']; ?>" readonly="" style="background-color : white">
 									</div>
 								</div>


 								<div class="form-group">
 									<label class="col-sm-3 col-lg-2 control-label" for="message">Comment</label>
 									<div class="col-sm-6 col-lg-4 controls">
 										<textarea class="form-control" name="question" id="question" readonly="" style="background-color : white"><?php echo $enquiry[0]['comments']; ?></textarea>

 										<span class="help-block"></span>
 									</div>
 								</div>

 							<!-- <div class="form-group">
 								<label class="col-sm-3 col-lg-2 control-label" for="message">Answer</label>
 								<div class="col-sm-6 col-lg-4 controls">
 									<textarea class="form-control" data-rule-required="true" name="answer" id="answer" style="background-color : white"></textarea>
 									<span class="help-block"></span>
 								</div>
 							</div> -->
 							<div class="form-group">
 								<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
 									
 									<!-- <input class="btn btn-primary" value="Reply" type="submit"> -->
 									<a class="btn btn-primary" href="<?php echo base_url().ADMIN_CTRL;?>/contact"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
 								</div>
 							</div>

 						</form>
 					</div>
 				</div>
 			</div>  
 		</div>
 	</div>
 </div>


                <!-- END Main Content -->