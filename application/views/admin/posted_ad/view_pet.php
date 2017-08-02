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
 		<i class="fa fa-paw"></i>
 			<a href="<?php echo base_url().ADMIN_CTRL;?>/pets">Posted Ad</a>
 			<span class="divider"><i class="fa fa-angle-right"></i></span>
 		</li>
 		<li class="active"> <?php echo ($module_name)? $module_name:'Demo Page'; ?> </li>
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
 				<h3><i class="fa fa-bars"></i>Pet Information </h3>

 			</div>
 			<div class="box-content">

 				<?php 
 				if($pet)
 				{
 					?>   


 					<form action="<?php echo base_url().ADMIN_CTRL;?>/user_registration/edit/<?php echo $pet[0]['id'];?>" id="validation-form" class="form-horizontal" method="post" > 
 					  <?php  $csrf = array(
                   'name' => $this->security->get_csrf_token_name(),
                   'hash' => $this->security->get_csrf_hash()); ?>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="firstname" style="text-align: left;">Pet Name</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo print_data($pet[0]['pet_name']);?>
 							</div>
 						</div>
 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="lastname" style="text-align: left;">Owner Name</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo print_data($pet[0]['owener_name']);?>
 							</div>
 						</div>
 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="lastname" style="text-align: left;">Location</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo print_data($pet[0]['location']);?>
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="email" style="text-align: left;">Gender</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo print_data($pet[0]['gender']);?>
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="birthdate" style="text-align: left;">Breed</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo print_data($pet[0]['breed']);?>
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="gender" readonly="true" style="text-align: left;">Age</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo print_data($pet[0]['age'])?> Years
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="gender" readonly="true" style="text-align: left;">Weight</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo $pet[0]['weight'];?> K.G.
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="gender" readonly="true" style="text-align: left;">Price</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo $pet[0]['price'];?> INR
 							</div>
 						</div>
 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="gender" readonly="true" style="text-align: left;">Ad-Type</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo print_data($pet[0]['ad_type']);?>
 							</div>
 						</div>
 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="gender" readonly="true" style="text-align: left;">Age</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo $pet[0]['age'];?> Years
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="gender" readonly="true" style="text-align: left;">Ad-Status</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo ($pet[0]['pets_status']==1)? "Active":"Inactive";?>  
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="gender" readonly="true" style="text-align: left;">Registered in kennel club ?</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo ($pet[0]['kennel_club']==1)? "Yes":"No";?>  
 							</div>
 						</div>

 						<div class="form-group">
 							<label class="col-sm-3 col-lg-3 control-label" for="gender" readonly="true" style="text-align: left;">Micro Chip ?</label>
 							<div class="col-sm-8 col-lg-9 controls">
 								: <?php echo ($pet[0]['micro_chip']==1)? "Yes":"No";?>  
 							</div>
 						</div>
 						
 						<div class="form-group">
 							<div class="col-sm-8 col-sm-offset-3 col-lg-10 col-lg-offset-2">

             <!--  <button type="button" name="edit_user" id="edit_user" class="btn btn-primary"><i class="fa fa-check"></i> Back</button>
         -->        
         <a href="<?php echo $_SERVER['HTTP_REFERER'];?>" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></button>
         
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


                <!-- END Main Content -->