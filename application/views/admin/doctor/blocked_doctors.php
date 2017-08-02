<!-- BEGIN Content -->
<div id="main-content">
  <!-- BEGIN Page Title -->
  <div class="page-title">
    <div>
      <h1><i class="fa fa-user-md"></i> Manage Doctors</h1>
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
      <i class="fa fa-user-md"></i>
      <li class="active"> Manage Doctors</li>
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

  <div class="row">
    <div class="col-md-12">

      <div class="">
        <div class="box-title">

      <div class="box box-black">
<!--         <div class="box-title">
          <h3><i class="fa fa-table"></i> Manage Doctors</h3>
          <ul class="nav nav-tabs">
                        <li class="active"><a href="<?php echo base_url().'admin/doctor/manage'; ?>">All Doctors(<?php echo $total? $total:0;?>)</a></li>
                        <li><a href="<?php echo base_url().'admin/doctor/blocked_doctors'; ?>">Blocked Doctors(<?php echo $blocked?>)</a></li>
                    </ul>
                </div> -->
                      <div class="tabing-section-order">
                     <ul>
                        <li><a  href="<?php echo base_url().'admin/doctor/manage'; ?>">All Doctors(<?php echo $total? $total:0;?>)</a></li>
                        <li><a class="acti" href="<?php echo base_url().'admin/doctor/blocked_doctors'; ?>">Blocked Doctors(<?php echo $blocked?>)</a></li>
                    </ul>
                     <div class="clearfix"></div>
                    </div>
                <div class="box-content">
                  <div class="btn-toolbar pull-right">
                    <div class="btn-group">
                      <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Block selected"><i class="fa fa-lock" onclick="javascript:blockselect();"></i></a>
                      <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Unblock selected"><i class="fa fa-unlock" onclick="javascript:unblockselect();"></i></a>
                      <a class="btn btn-circle show-tooltip" title="" href="#" data-original-title="Delete selected" onclick="javascript:delselect();"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </div>
                  <br/><br/>

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
                              <input  class="form-control" type="text" name="search_name" value="<?php echo isset($_GET['search_name'])? $_GET['search_name']:''; ?>" id="search_name" data-rule-required="true" data-original-title="Add Search Name" data-trigger="hover" placeholder="Search By Name" />
                               <div style="color:red;">
                                <?php echo form_error('search_name');?>
                            </div> 
                          </div>
                      </div>&nbsp;&nbsp;  
                       <div class="form-group">
                          <div>
                          <button type="submit" id="submit-btn" class="btn btn-primary col-sm-offset-3"> Search</button>
                      </div>
                      </div>  
                  </form>
                   <span id="search_error" class="col-sm-offset-1" style="color: red"></span>
                   <form name="frm_make_view" id="frm_make_view" method="post" action="<?php echo base_url().ADMIN_CTRL;?>/doctor/multi_action">
                      <input type="hidden" name="action" value="" id="action">
                      <table class="table table-advance">
                        <thead>
                          <tr>
                            <!-- <th style="width:5%;"><input type="checkbox" name="all" value="Check All" onclick="this.value=check(this.form.chk)"/></th> -->
                            <th style="width:18px">
                              <input type="checkbox" name="mult_change" id="mult_change" />
                            </th>
                            <th style="width:5%;">Sr. No.</th>
                            <th style="width:10%;">First Name</th>
                            <th style="width:10%;">Last Name</th>
                            <th style="width:30%;">Email ID</th>
                            <th style="width:15%;">Email Verified</th>
                            <th style="width:10%;">User Status</th>
                            <th class="visible-md visible-lg" style="width:15%;">Action</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          
                          if(count($user_registration_records)>0)
                          {
                            $i = 1;
                            
                            foreach($user_registration_records as $key => $get_records)
                            {
                              ?>
                              <tr class="table">
                               <td><input type="checkbox" name="chk[]" id="chk" value="<?php echo $get_records['id'];?>"/></td>
                              <td><?php echo $i+($page? $page:0);?> </td>
                               <th><?php echo $get_records['user_firstname'];?></th>
                               <th><?php echo $get_records['user_lastname'];?></th>
                               <th><?php echo $get_records['user_email'];?></th>
                               <td>
                                <?php

                                if($get_records['verification_status'] == '0')
                                {   
                                  ?>
                                  <a class="btn btn-circle show-tooltip" style="color:red;" title="Deactive" href="#"><i class="fa fa-circle" style="color:red;"></i></a> 
                                  
                                  <?php

                                }
                                else
                                {    

                                  ?>  
                                  <a class="btn btn-circle show-tooltip" style="color:green;"  title="Active" href="#"><i class="fa fa-circle" style="color:green;"></i></a>
                                  
                                  <?php
                                }   
                                ?>    
                              </td>

       

                <td>
                          <?php if($get_records['user_status']==1){ ?>
                          <a class="show-tooltip" title="Block" onclick="return confirm('Are you sure you want to Block this Doctor ?')" href="<?php echo base_url('/admin/doctor/block/').base64_encode($get_records['id']) ?>"><i class="fa fa-unlock"></i></a>
                          <?php }else{ ?>
                          <a class="show-tooltip" onclick="return confirm('Are you sure you want to Unblock this Doctor ?')" title="Block" href="<?php echo base_url('/admin/doctor/unblock_page/').base64_encode($get_records['id']) ?>"><i class="fa fa-lock"></i></a>
                          <?php } ?>
            </td>

              <td class="visible-md visible-lg">
                <div class="btn-group">
                    <a class="btn btn-sm show-tooltip" title="" href="<?php echo base_url('/admin/doctor/edit/').base64_encode($get_records['id']); ?>" data-original-title="Edit"><i class="fa fa-edit"></i></a>                  
                    <a class="btn btn-sm btn-danger show-tooltip" onclick="return confirm('Are you sure you want to Delete this Doctor ?')" title="" href="<?php echo base_url('/admin/doctor/delete/').base64_encode($get_records['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                </div>
              </td>
            </tr>
            <?php
            $i++;
          }
        }
        else
        {   
         $i=1; 
          ?>
          <tr class="table">
            <td colspan="8">
             <b> No records found..!</b>
           </td>    
         </tr>
         <?php
       }
       ?>
     </tbody>
   </table>
   
 </form>
</div>
<div class="text-center">
 <?php echo $pagination;?>
</div> 
<div class="dataTables_info" id="table1_info"> Showing <?php echo (($i==1)? 0:$page+1); ?> - <?php echo ($i+($page? $page:0))-1; ?>      
            Out of <?php echo $blocked? $blocked:0;?> </div>
</div>
</div>
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
            if(confirm("Do you really want to delete this record ?")==true)
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
            if(confirm("Do you really want to delete this record ?")==true)
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
            if(confirm("Do You Want To Block This Record ?")==true)
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
            if(confirm("Do You Want To Block This Record ?")==true)
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
            if(confirm("Do You Want To Unblock This Record ?")==true)
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
            if(confirm("Do You Want To Unblock This Record ?")==true)
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