<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.co and apple-touch-icon.png in the root directory -->

        <!--base css styles-->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/font-awesome/css/font-awesome.min.css">

        <!--page specific css styles-->

        <!--flaty css styles-->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/flaty.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/flaty-responsive.css">

         <link rel="shortcut icon" href="<?php echo base_url();?>assets/admin/img/favicon.png">
    </head>
    <body class="login-page">
        <!-- BEGIN Main Content -->
        <div class="login-wrapper">
            <!-- BEGIN Login Form -->
            <form id="form-login" action="<?php echo base_url().'index.php/'.ADMIN_CTRL;?>/login" method="post">
                  <?php  $csrf = array(
                   'name' => $this->security->get_csrf_token_name(),
                   'hash' => $this->security->get_csrf_hash()); ?>

                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                

                <h3>Login to your account</h3>
                <hr/>

                <?php
                    if($this->session->flashdata('login_error'))
                    {
                ?>

                <div class="alert alert-danger">
                    <button class="close" data-dismiss="alert"></button>
                    <strong>Error!</strong> Incorrect Username/Password.
                    </div>
                <hr/>

                <?php
                      }
                ?>

                <div class="form-group">
                    <div class="controls">
                        <input type="text" name="username" id="username" placeholder="Username" data-rule-required ="true" class="form-control" />
		                     <div style="color:red">
		                    	<?php echo form_error('username');?>
		                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="password" name="password" id="password" placeholder="Password" data-rule-required = "true" data-rule-minlength="6" class="form-control" />
		                   	 <div style="color:red">
		                    	<?php echo form_error('password');?>
		                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary form-control">Sign In</button>
                    </div>
                </div>
                <hr/>
                <p class="clearfix">
                    <a href="#" class="goto-forgot pull-left">Forgot Password?</a>

                </p>
            </form>
            <!-- END Login Form -->

            <!-- BEGIN Forgot Password Form -->
            <form id="form-forgot" action="<?php echo base_url().ADMIN_CTRL;?>/login/recover_password" method="POST" style="display:none">
            <?php $csrf = array(
              'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()); ?>
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" id="csrf"/>

                <h3>Get back your password</h3>
                <hr/>
                <div id="succ_email" style="color:green;"></div>
                <div class="form-group">
                    <div class="controls">
                        <input type="text" placeholder="Email" name="email1" id="email1" data-rule-required="true" data-rule-email="true" class="form-control" />
                        <div id="err_email" style="color:#FF0000;"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <button type="button" name="recover" id="recover" onclick="javascript: return verify_email('<?php echo base_url().ADMIN_CTRL;?>');" class="btn btn-primary form-control">Recover</button>
                    </div>
                </div>
                <hr/>
                <p class="clearfix">
                    <a href="#" class="goto-login pull-left">← Back to login form</a>
                </p>
            </form>
            <!-- END Forgot Password Form -->

            <!-- BEGIN Register Form -->
            <form id="form-register" action="index.html" method="get" style="display:none">
                <h3>Sign up</h3>
                <hr/>
                <div class="form-group">
                    <div class="controls">
                        <input type="text" placeholder="Email" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="text" placeholder="Username" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="password" placeholder="Password" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="password" placeholder="Repeat Password" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" value="remember" /> I accept the <a href="#">user aggrement</a>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary form-control">Sign up</button>
                    </div>
                </div>
                <hr/>
                <p class="clearfix">
                    <a href="#" class="goto-login pull-left">← Back to login form</a>
                </p>
            </form>
            <!-- END Register Form -->
        </div>
        <!-- END Main Content -->

        <!-- page related scripts added by Nayan -->
        <script src="<?php echo base_url();?>assets/admin/js/admin_validations.js"></script>*/
         <script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.1.min.js"></script>


       <script src="<?php echo base_url();?>assets/front/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url();?>assets/front/js/additional-methods.min.js"></script>
        <script>
        $( "#form-login" ).validate();

       $( "#form-forgot" ).validate();
        </script>
        <style type="text/css">
            #form-login .error {
            color: red;
            }
            #form-forgot .error {
            color: red;
            }
        </style>

        <!-- page related scripts end -->

        <!--basic scripts-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/admin/assets/jquery/jquery-2.1.4.min.js"><\/script>')</script>
        <script src="<?php echo base_url();?>assets/admin/bootstrap/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            function goToForm(form)
            {
                $('.login-wrapper > form:visible').fadeOut(500, function(){
                    $('#form-' + form).fadeIn(500);
                });
            }
            $(function() {
                $('.goto-login').click(function(){
                    goToForm('login');
                });
                $('.goto-forgot').click(function(){
                    goToForm('forgot');
                });
            });
        </script>
    </body>
</html>
