<!-- BEGIN Content -->
<div id="main-content">
    <!-- BEGIN Page Title -->
    <div class="page-title">
        <div>
            <h1><i class="fa fa-globe"></i> <?php echo isset($module_name)? $module_name:'Demo Page'; ?></h1>
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
            <li class="active">
                <i class="fa fa-globe"></i>
                <a href="<?php echo base_url().ADMIN_CTRL;?>/state">Location</a>
                <span class="divider"><i class="fa fa-angle-right"></i></span>
            </li>
            <li class="active">
                <i class="fa fa-globe"></i>
                <a href="<?php echo base_url().ADMIN_CTRL;?>/state">States</a>
                <span class="divider"><i class="fa fa-angle-right"></i></span>
            </li>

            <li class="active"><i class="fa fa-globe"></i> <?php echo isset($module_name)? $module_name:'Demo Page'; ?></li>
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
            <div class="box ">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i> <?php echo ($module_name)? $module_name:'Demo Page'; ?></h3>
              <!--   <ul class="nav nav-tabs">
                    <li class="active"><a href="<?php echo base_url().'admin/category'; ?>">All Categories(<?php echo $total? $total:0;?>)</a></li>
                    <li><a href="<?php echo base_url().'admin/category/blockedcategory'; ?>">Blocked Categories(<?php echo $blocked?>)</a></li>
                </ul> -->
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box ">
            <div class="box-content">
                <br><br>
                <div class="table-responsive">
                    <form id="per_page" method="get">
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
              <form name="frm_make_view" id="frm_make_view" method="post" action="<?php echo base_url().ADMIN_CTRL;?>/city/multi_action">
                <input type="hidden" name="action" value="" id="action">
                  <?php  $csrf = array(
                   'name' => $this->security->get_csrf_token_name(),
                   'hash' => $this->security->get_csrf_hash()); ?>

            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <table class="table table-advance">
                    <thead>
                        <tr>
                            <!-- <th style="width:18px"><input type="checkbox"></th> -->
                            <th>Sr No</th>
                            <th>city Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($total>0){
                            $i=1;
                            foreach ($records as $record) { ?>
                            <tr class="">
                                <!-- <td><input type="checkbox" name="chk[]" id="chk" value="<?php echo $record['city_id'];?>"/></td> -->
                                <td><?php echo $i+($page? $page:0);?> </td>
                                <td><?php echo $record['city_name']; ?></td>
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