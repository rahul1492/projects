
<div id="main-content">
    <!-- BEGIN Page Title -->
    <div class="page-title">
        <div>
            <h1><i class="fa fa-sitemap"></i> <?php echo isset($module_name)? $module_name:'Demo Page'; ?></h1>
        </div>
    </div>
    <!-- END Page Title -->
    <!-- BEGIN Breadcrumb -->
    <div id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo base_url().ADMIN_CTRL;?>/dashboard">Home</a>
                <span class="divider"><i class="fa fa-angle-right"></i></span>
            </li>
            <li><i class="fa fa-sitemap"></i> <a href="<?php echo base_url().ADMIN_CTRL;?>/category">Category</a>
                <span class="divider"><i class="fa fa-angle-right"></i></span></li>
                <li class="active"> <?php echo isset($module_name)? $module_name:'Demo Page'; ?></li>
            </ul>
        </div>
        <!-- END Breadcrumb -->

        <?php
        if($this->session->flashdata('success')!='')
        {
            ?>
            <div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Success!</strong><?php echo $this->session->flashdata('success'); ?>
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

        <div class="row">
            <div class="col-md-12">

                <div class="box">

                    <div class="box-title">
                        <h3><i class="fa fa-bars"></i> Add Category</h3>
                    </div>
                    <div class="box-content" style="padding: 25px">

                        <form action="" id="validation-form" class="form-inline" method="post" >

                           <div class="form-group col-md-6 col-sm-5">
                              <label class="col-sm-5 col-lg-5 control-label" for="category_name">Category Name<span style="color: red">*</span></label>
                              <div class="col-sm-5 col-md-5 controls">
                                 <input class="form-control show-tooltip" type="text" name="category_name" id="category_name" data-rule-required="true" data-original-title="Add Category Name" data-trigger="hover" placeholder="Enter Category Name"/>
                                 <span style="color:red;">
                                    <?php echo form_error('category_name');?>
                                </span>   
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-lg-10 col-sm-offset-3">
                               <button type="submit" name="add_category" id="add_make" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                           </div>
                       </div>
                       <?php $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()); ?>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </form>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <div class="col-md-12">
            <div class="tabing-section-order">
                <ul>
                    <li><a href="<?php echo base_url().'admin/category'; ?>" class="acti">All Categories(<?php echo $total? $total:0;?>)</a></li>
                    <li><a href="<?php echo base_url().'admin/category/blockedcategory'; ?>">Blocked Categories(<?php echo $blocked?>)</a></li>

                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">

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
                        <form id="per_page" method="get" action="<?php echo base_url().'admin/category?per_page=$per_page'; ?>">
                            <div class="form-group col-md-1">
                              <select class="form-control" id="perpage" name="per_page">
                                <option value="10" <?php echo (isset($_GET['per_page'])&&($_GET['per_page'])==10)? "selected='selected'":''; ?>>10</option>
                                <option value="25" <?php echo (isset($_GET['per_page'])&&($_GET['per_page'])==25)? "selected='selected'":''; ?>>25</option>
                                <option value="50" <?php echo (isset($_GET['per_page'])&&($_GET['per_page'])==50)? "selected='selected'":''; ?>>50</option>
                                <option value="100" <?php echo (isset($_GET['per_page'])&&($_GET['per_page'])==100)? "selected='selected'":''; ?>>100</option>
                            </select>
                        </div>
                        <input type='hidden' name='search_name' value="<?php echo (isset($_GET['search_name']))? $_GET['search_name']:'' ?>"> 
                    </form>
                    <form method="GET" id="search_form" class="form-inline" action="">
                        <div class="form-group">
                          <div class="col-sm-9 col-lg-4 col-sm-offset-3 controls">
                              <input name="search_name" placeholder="Search By Name" value="<?php echo isset($_GET['search_name'])? $_GET['search_name']:''; ?>"  class="form-control" type="text" id="search_name" id="search_name">
                          </div>
                      </div>  
                      <div class="form-group">
                         <div>
                          <button type="submit" id="submit-btn" class="btn btn-primary col-sm-offset-3"> Search</button>
                      </div>
                  </div>
              </form>
              <span id="search_error" class="col-sm-offset-1" style="color: red"></span>
              <form name="frm_make_view" id="frm_make_view" method="post" action="<?php echo base_url().ADMIN_CTRL;?>/category/multi_action">
                <?php  $csrf = array(
                 'name' => $this->security->get_csrf_token_name(),
                 'hash' => $this->security->get_csrf_hash()); ?>

                 <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                 <input type="hidden" name="action" value="" id="action">
                 <table class="table table-advance">
                    <thead>
                        <tr>
                            <th style="width:18px"><input type="checkbox"></th>
                            <th>Sr No</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th class="visible-md visible-lg" style="width:130px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($total>0){
                            $i=1;
                            foreach ($records as $record) { ?>
                            <tr class="">
                                <td><input type="checkbox" name="chk[]" id="chk" value="<?php echo $record['id'];?>"/></td>
                                <td><?php echo $i+($page? $page:0);?> </td>
                                <td><?php echo $record['category_name']; ?></td>
                                <td>
                                    <?php if($record['category_status']==1){ ?>
                                    <a class="show-tooltip" title="Block" onclick="return confirm('You Want Block ?')" href="<?php echo base_url('/admin/category/block/').base64_encode($record['id']) ?>"><i class="fa fa-unlock"></i></a>
                                    <?php }else{ ?>
                                    <a class="show-tooltip" onclick="return confirm('You Want Unblock ?')" title="Block" href="<?php echo base_url('/admin/category/unblock/').base64_encode($record['id']) ?>"><i class="fa fa-lock"></i></a>
                                    <?php } ?>
                                </td>
                                <td class="visible-md visible-lg">
                                    <div class="btn-group">
                                        <a class="btn btn-sm show-tooltip" title="" href="<?php echo base_url('/admin/category/edit/').base64_encode($record['id']); ?>" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-danger show-tooltip" onclick="return confirm('Are you sure you want to delete record ?')" title="" href="<?php echo base_url('/admin/category/delete/').base64_encode($record['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
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
         <?php echo $pagination;?>
     </div> 
     <div class="dataTables_info" id="table1_info"> Showing <?php echo (($i==1)? 0:$page+1); ?> - <?php echo ($i+($page? $page:0))-1; ?>      
        Out of <?php echo $total? $total:0;?> </div>

    </div>
</div>
</div>
</div>
<!-- </div> -->

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