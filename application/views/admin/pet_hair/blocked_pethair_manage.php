<!-- BEGIN Content -->
<div id="main-content">
    <!-- BEGIN Page Title -->
    <div class="page-title">
        <div>
            <h1><i class="fa fa-sitemap"></i> <?php echo isset($module_name)? $module_name:'Demo Page'; ?></h1>
            <!--  <h4>Advance table with pagination and toolbar</h4> -->
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
                    <h3><i class="fa fa-bars"></i> Add Hair Type</h3>
                </div>
                <div class="box-content" style="padding: 25px">
                    <form action="" id="validation-form" class="form-inline" method="post" >
                        <?php $csrf = array(
                            'name' => $this->security->get_csrf_token_name(),
                            'hash' => $this->security->get_csrf_hash()); ?>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" /> 
                       <div class="form-group">
                          <label class="col-sm-5 col-lg-5 control-label" for="category_name">Hair Name Type<span style="color: red;">*</span></label>
                          <div class="col-sm-4 col-md-4 controls">

                             <input class="form-control show-tooltip" type="text" name="hair_type" id="category_name" data-rule-required="true" data-original-title="Add Hair Type Name" data-trigger="hover" placeholder="Enter Hair Type Name" />
                             <div style="color:red;">
                                <?php echo form_error('hair_type');?>
                            </div>   
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5 col-lg-5">
                           <button type="submit" name="add_type" id="add_make" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                       </div>
                   </div>
               </form>
           </div>
       </div>
   </div>
</div>

<div class="row">
         <div class="col-md-12">
            <div class="tabing-section-order">
                <ul>
                    <li><a href="<?php echo base_url().'admin/pethair'; ?>">All Hair(<?php echo $total? $total:0;?>)</a></li>
                    <li><a href="<?php echo base_url().'admin/pethair/blockedpethair'; ?>" class="acti">Blocked Hair(<?php echo $blocked?>)</a></li>
                </ul>
                <div class="clearfix"></div>
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
                    <form id="per_page" method="POST">
                                        <?php $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()); ?>

                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                        <div class="form-group col-md-1">
                          <select class="form-control" id="perpage" name="per_page">
                            <option value="10" <?php echo (set_value('per_page')&&set_value('per_page')==10)? "selected='selected'":''; ?>>10</option>
                            <option value="25" <?php echo (set_value('per_page')&&set_value('per_page')==25)? "selected='selected'":''; ?>>25</option>
                            <option value="50" <?php echo (set_value('per_page')&&set_value('per_page')==50)? "selected='selected'":''; ?>>50</option>
                            <option value="100" <?php echo (set_value('per_page')&&set_value('per_page')==100)? "selected='selected'":''; ?>>100</option>
                        </select>
                    </div> 
                </form>
                <form method="GET" id="search_form" class="form-inline" action="">
                    <div class="form-group">
                      <div class="col-sm-9 col-lg-4 col-sm-offset-3 controls">
                          <input name="search_name" placeholder="Search By Hair" value="<?php echo isset($_GET['search_name'])? $_GET['search_name']:''; ?>" class="form-control" type="text" id="search_name">
                      </div>
                  </div classs="col-sm-offset-4">  
                  <div class="form-group">
                      <div>
                          <button type="submit" class="btn btn-primary">Search</button>
                      </div>
                  </div>
              </form>
              <span id="search_error" class="col-sm-offset-1" style="color: red"></span>
              <form name="frm_make_view" id="frm_make_view" method="post" action="<?php echo base_url().ADMIN_CTRL;?>/pethair/multi_action">
              <?php $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()); ?>

                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <input type="hidden" name="action" value="" id="action">
                <table class="table table-advance">
                    <thead>
                        <tr>
                            <th style="width:18px"><input type="checkbox"></th>
                            <th>SR NO</th>
                            <th>HAIR TYPE</th>
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
                                    <td><?php echo $record['hair_type']; ?></td>
                                    <td>
                                        <?php if($record['status']==1){ ?>
                                            <a class="show-tooltip" title="Block" onclick="return confirm('Are you sure you want to Block this Record ?')" href="<?php echo base_url('/admin/pethair/block/').base64_encode($record['id']) ?>"><i class="fa fa-unlock"></i></a>
                                            <?php }else{ ?>
                                                <a class="show-tooltip" onclick="return confirm('Are you sure you want to Unblock this Record ?')" title="Block" href="<?php echo base_url('/admin/pethair/unblock/').base64_encode($record['id']) ?>"><i class="fa fa-lock"></i></a>
                                                <?php } ?>
                                            </td>
                                            <td class="visible-md visible-lg">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm show-tooltip" title="" href="<?php echo base_url('/admin/pethair/edit/').base64_encode($record['id']); ?>" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-sm btn-danger show-tooltip" onclick="return confirm('Are you sure you want to Delete this Record ?')" title="" href="<?php echo base_url('/admin/pethair/delete/').base64_encode($record['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
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