 <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-cog"></i> Pet Product</h1>
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
                      
                            <a href="<?php echo base_url().ADMIN_CTRL;?>/petproduct">Pet Product</a>
                           
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
                        <h3><i class="fa fa-bars"></i> Add Product</h3>
                    </div>
                               <!--  <ul>
                                    <li><a href="" class="acti">Account Setting</a></li>
                                    <li><a href="<?php echo base_url().ADMIN_CTRL;?>/prize" >Pricing Setting</a></li>
                                                 
                                </ul> -->
                                 <div class="clearfix"></div>
                        </div>
                               
                 <div class="box">
                            <?php //echo '<pre>'; print_r($arr_account_setting);die(); ?>
                           
                            <div class="box-content">
                                <form action="<?php echo base_url().ADMIN_CTRL;?>/petproduct/submit" method="post" id="validation-form" name="frm_admin_profile" enctype="multipart/form-data" class="form-horizontal">

                                     <?php  $csrf = array(
                                       'name' => $this->security->get_csrf_token_name(),
                                       'hash' => $this->security->get_csrf_hash()); ?>

                                         <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                    <div class="form-group">
                                      <label class="col-sm-3 col-lg-2 control-label">Image Upload</label>
                                      <div class="col-sm-9 col-lg-10 controls">
                                         <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                               <img src="<?php echo base_url();?>uploads/admin/profile_image/no-image-icon.jpg" alt="" />
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
                                            <input class="form-control show-tooltip" type="text" value="" name="product_name" id="product_name" data-rule-required="true" data-original-title="Add Product Name" data-trigger="hover"/>
                                            <div style="color:red;">
                                                <?php echo form_error('product_name');?>
                                             </div>   
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label">Product Price<span style="color:red">*</span></label>
                                        <div class="col-sm-4 col-lg-4 controls">
                                            <input type="text" data-rule-required="true" value="" name="price" class="form-control show-tooltip" data-original-title="Add Product Price" data-trigger="hover"/>
                                        <div style="color:red;">
                                                <?php echo form_error('price');?>
                                             </div> 
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label">About<span style="color:red">*</span></label>
                                        <div class="col-sm-4 col-lg-4 controls">
                                            <textarea rows="4" cols="50" data-rule-required="true" value="" name="about" class="form-control show-tooltip" data-original-title="Add About Details" data-trigger="hover"></textarea>
                                        <div style="color:red;">
                                                <?php echo form_error('about');?>
                                             </div> 
                                        </div>
                                    </div>
                                   
           

                                
                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                           <a href="<?php echo base_url().ADMIN_CTRL;?>/dashboard"> <button type="button" class="btn">Cancel</button></a>
                                        </div>
                                   </div>
                                </form>
                            </div>
                           
                        </div>
                    </div>
                    </div>
<div class="row">

    <div class="col-md-12">

        <div class="box">

            <div class="box-title">
                <h3><i class="fa fa-bars"></i> <?php echo ($module_name)? $module_name:'Demo Page'; ?></h3>
              
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box ">
            <div class="box-content">
                <div class="btn-toolbar pull-right">
                    <div class="btn-group">
                        <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Block selected"><i class="fa fa-lock" onclick="javascript:blockselect();"></i></a>
                        <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Unblock selected"><i class="fa fa-unlock" onclick="javascript:unblockselect();"></i></a>
                        <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Delete selected" onclick="javascript:delselect();"><i class="fa fa-trash-o"></i></a>
                    </div>

                </div>
                <br><br>
                <div class="table-responsive">
                    <form id="per_page" method="get">
                        <div class="form-group col-md-1">
                          <select class="form-control" id="perpage" name="per_page">
                            <option value="10" <?php echo (set_value('per_page')&&set_value('per_page')==10)? "selected='selected'":''; ?>>10</option>
                            <option value="25" <?php echo (set_value('per_page')&&set_value('per_page')==25)? "selected='selected'":''; ?>>25</option>
                            <option value="50" <?php echo (set_value('per_page')&&set_value('per_page')==50)? "selected='selected'":''; ?>>50</option>
                            <option value="100" <?php echo (set_value('per_page')&&set_value('per_page')==100)? "selected='selected'":''; ?>>100</option>
                        </select>
                    </div> 
                </form>
                <form method="get" id="search_form" class="form-inline" action="<?php echo base_url().'admin/petproduct' ?>">
                    <div class="form-group">
                      <div class="col-sm-9 col-lg-4 col-sm-offset-3 controls">
                          <input name="search_name" placeholder="Search By Name" value="" data-rule-required="true" class="form-control" name="search_name" type="text" id="search_name">
                      </div>
                  </div classs="col-sm-offset-4">  
                  <div class="form-group">
                      <div>
                          <button type="submit" class="btn btn-primary"> Search</button>
                      </div>
                  </div>
              </form>
              <span id="search_error" class="col-sm-offset-1" style="color: red"></span>
              <form name="frm_make_view" id="frm_make_view" method="post" action="<?php echo base_url().ADMIN_CTRL;?>/petproduct/multi_action">

                  <?php  $csrf = array(
                   'name' => $this->security->get_csrf_token_name(),
                   'hash' => $this->security->get_csrf_hash()); ?>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <input type="hidden" name="action" value="" id="action">
                <table class="table table-advance">
                    <thead>
                        <tr>
                            <th style="width:18px"><input type="checkbox"></th>
                            <th>SR NO</th>
                            <th>PRODUCT NAME</th>
                            <th>PRODUCT PRICE</th>
                            <th>STATUS</th>
                            <th class="visible-md visible-lg" style="width:130px">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($total>0){
                            $i=1;
                            foreach ($records as $record) { ?>
                                <tr class="">
                                    <td><input type="checkbox" name="chk[]" id="chk" value="<?php echo $record['id'];?>"/></td>
                                    <td><?php echo $i+($page? $page:0);?> </td>
                                    <td><?php echo $record['product_name']; ?></td>
                                    <td><?php echo $record['product_price']; ?></td>
                                    <td>
                                        <?php if($record['product_status']==1){ ?>
                                            <a class="show-tooltip" title="Block" onclick="return confirm('Are you sure you want to Block Record?')" href="<?php echo base_url('/admin/petproduct/block/').base64_encode($record['id']) ?>"><i class="fa fa-unlock"></i></a>
                                            <?php }else{ ?>
                                                <a class="show-tooltip" onclick="return confirm('Are you sure you want to Unblock Record ?')" title="Block" href="<?php echo base_url('/admin/petproduct/unblock/').base64_encode($record['id']) ?>"><i class="fa fa-lock"></i></a>
                                                <?php } ?>
                                            </td>
                                            <td class="visible-md visible-lg">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm show-tooltip" title="" href="<?php echo base_url('/admin/petproduct/edit/').base64_encode($record['id']); ?>" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-danger show-tooltip" onclick="return confirm('Are you sure you want to delete record ?')" title="" href="<?php echo base_url('/admin/petproduct/delete/').base64_encode($record['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                } else{
                                    $i=1;
                                    ?>
                                    <tr class=""> <td colspan="3">No Records Found.</td></tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="text-center">
                     <?php echo $links;?>
                 </div> 
                 <div class="dataTables_info" id="table1_info"> Showing <?php echo (($i==1)? 0:$page+1); ?> - <?php echo ($i+($page? $page:0))-1; ?>      
                    Out of <?php echo $total? $total:0;?> </div>

                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        var checkflag = "false";
        function check(field)
        {
            if(checkflag=="false")
            {
                for(i=0;i<field.length;i++)
                {
                    field[i].checked=true;
                }
                checkflag="true";
                return "Uncheck All";
            }
            else
            {
                for(i=0;i<field.length;i++)
                {
                    field[i].checked=false;
                }
                checkflag="false";
                return "Check All";
            }    
        }
        function delselect()
        {
            var chk=document.frm_make_view.chk;
            var total="";

            if((chk.length)>0)
            {
                for(var i=0;i<chk.length;i++)
                {
                    if(chk[i].checked)
                    {

                     total +=chk[i].value+ "\n";

                 }

             }
             if(total=="")
             {
                alert("Please Select Any Record");
            }
            else
            {
                if(confirm("Are you sure you want to delete record ?")==true)
                {
                    $("#action").val('delete');
                    $("#frm_make_view")[0].submit();

                }
            }    
        }
        else
        {
            if(chk.checked)
            {
                if(confirm("Are you sure you want to delete record ?")==true)
                {
                    $("#action").val('delete');
                    $("#frm_make_view")[0].submit();
                }
            }
            else
            {
                alert("Please Select Any Record");
            }    
        }    

    }
    function blockselect()
    {
        var chk=document.frm_make_view.chk;
        var total="";

        if((chk.length)>0)
        {
            for(var i=0;i<chk.length;i++)
            {
                if(chk[i].checked)
                {

                 total +=chk[i].value+ "\n";

             }

         }
         if(total=="")
         {
            alert("Please Select Any Record");
        }
        else
        {
            if(confirm("Are you sure you want to block record ?")==true)
            {
                $("#action").val('block');
                $("#frm_make_view")[0].submit();

            }
        }    
    }
    else
    {
        if(chk.checked)
        {
            if(confirm("Are you sure you want to block record ?")==true)
            {
                $("#action").val('block');
                $("#frm_make_view")[0].submit();
            }
        }
        else
        {
            alert("Please Select Any Record");
        }    
    }    

}
function unblockselect()
{
    var chk=document.frm_make_view.chk;
    var total="";

    if((chk.length)>0)
    {
        for(var i=0;i<chk.length;i++)
        {
            if(chk[i].checked)
            {

             total +=chk[i].value+ "\n";

         }

     }
     if(total=="")
     {
        alert("Please Select Any Record");
    }
    else
    {
        if(confirm("Are you sure you want to unblock record ?")==true)
        {
            $("#action").val('unblock');
            $("#frm_make_view")[0].submit();

        }
    }    
}
else
{
    if(chk.checked)
    {
        if(confirm("Are you sure you want to unblock record ?")==true)
        {
            $("#action").val('unblock');
            $("#frm_make_view")[0].submit();
        }
    }
    else
    {
        alert("Please Select Any Record");
    }    
}    

}

$('#perpage').on('change',function()
{
    $('#per_page').submit();    
});
</script>
