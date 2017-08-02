 <footer>
  <p><?php echo date('Y')?> © 101Tails Admin.</p>
</footer>

<a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
</div>
<!-- END Content -->
</div>
<!-- END Container -->


<!--basic scripts-->
<script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/admin/jquery/jquery-2.1.4.min.js"><\/script>')</script>
<script src="<?php echo base_url();?>assets/admin/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/jquery-cookie/jquery.cookie.js"></script>

<!--page specific plugin scripts-->
<script src="<?php echo base_url();?>assets/admin/flot/jquery.flot.js"></script>
<script src="<?php echo base_url();?>assets/admin/flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url();?>assets/admin/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url();?>assets/admin/flot/jquery.flot.stack.js"></script>
<script src="<?php echo base_url();?>assets/admin/flot/jquery.flot.crosshair.js"></script>
<script src="<?php echo base_url();?>assets/admin/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/sparkline/jquery.sparkline.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/admin/chosen-bootstrap/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/jquery-pwstrength/jquery.pwstrength.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-duallistbox/duallistbox/bootstrap-duallistbox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/dropzone/downloads/dropzone.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/clockface/js/clockface.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
       <!-- <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-daterangepicker/date.js"></script>
       <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-daterangepicker/daterangepicker.js"></script>-->
       <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-switch/static/js/bootstrap-switch.js"></script>
       <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
       <script type="text/javascript" src="<?php echo base_url();?>assets/admin/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

       <!--flaty scripts-->
       <script src="<?php echo base_url();?>assets/admin/js/flaty.js"></script>
       <script src="<?php echo base_url();?>assets/admin/js/flaty-demo-codes.js"></script>

       <!--form-validation-data-rules-->
       <script src="<?php echo base_url();?>assets/admin/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
       <script src="<?php echo base_url();?>assets/admin/jquery-validation/dist/additional-methods.min.js" type="text/javascript"></script>

       <!-- ckeditor scripts-->
       <script src="<?php echo base_url();?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
       <script type="text/javascript">
        
        $('#search_form').submit(function(){
          if($('#search_name').val()==''){
            $('#search_error').html('* This field is required.');
            return false;
          }
        });
      </script>

    </body>
    </html>