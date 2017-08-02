<html>
	<head>
		<title>Reset Your Password</title>	
	</head>
	<body>
			<center>
					<h3>Reset Your Password</h3>
			</center>
			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" style="padding:15px; border:1px solid #e5e5e5;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td  height="1" bgcolor="#ddd"></td>
        </tr>
        <tr>
          <td  height="10"></td>
        </tr>
         <tr>
        <td align="left" style="font-family: Tahoma, Geneva, sans-serif; font-size:13px; font-weight:bold; color:#525252; padding-bottom:10px;">Hello <?php echo $name; ?>, </td>
        </tr>

<tr>
                         <br /><br />
                         <td>
                         <strong>A new password has been requested by you to registered e-mail address.</strong><br />
                          <strong>Please change your password</strong><br /><br />
                          <strong> Email:</strong> <?php echo $email; ?><br />
                          </td>

                        </tr>

                        <tr>
                           <td>
                               <br/><br/>
                               Please click following link to reset your password <a href="<?php echo $reset_link;?>">Click Here</a>
                           </td>
                        </tr>

        <tr>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td height="2" bgcolor="#3f3f3f"></td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <td style="text-align:center;">Copyright © <?php echo date('Y');?> <?php echo $this->config->item('project_name');?>  All rights reserved</td>
        </tr>
      </table>
	</body>
</html>