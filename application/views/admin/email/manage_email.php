<!-- BEGIN Content -->
<div id="main-content">
  <!-- BEGIN Page Title -->
  <div class="page-title">
    <div>
      <h1><i class="fa fa-envelope"></i> Manage Email Templete</h1>
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
      <i class="fa fa-envelope"></i>
      <li class="active"> Manage Email Templete</li>
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
          <div class="box">
            <div class="box-title">
                    <h3><i class="fa fa-bars"></i>Manage Email Templete</h3>
                </div>
                <div class="box-content">
                <div class="table-responsive"> 
              
            <span id="search_error" class="col-sm-offset-1" style="color: red"></span>
                   <form name="frm_make_view" id="frm_make_view" method="post" action="<?php echo base_url().ADMIN_CTRL;?>/user/multi_action">
                      <input type="hidden" name="action" value="" id="action">
                      <table class="table table-advance">
                        <thead>
                          <tr>
                            <th style="width:10%;">Name</th>
                            <th style="width:10%;">From</th>
                            <th style="width:30%;">From Email</th>
                            <th style="width:15%;">Subject</th>
                            <th class="visible-md visible-lg" style="width:15%;">Action</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          
                          if(count($email_records)>0)
                          {
                            $i = 1;
                            
                            foreach($email_records as $key => $get_records)
                            {
                              ?>
                              <tr class="table">
                               
                             
                               <th><?php echo $get_records['template_name'];?></th>
                               <th><?php echo $get_records['template_from'];?></th>
                               <th><?php echo $get_records['template_from_mail'];?></th>
                               <th><?php echo $get_records['template_subject'];?></th>
                              
                <td class="visible-md visible-lg">
                <div class="btn-group">
                  
                  <a class="btn btn-circle show-tooltip" title="View" href="<?php echo base_url().ADMIN_CTRL;?>/email/edit/<?php echo base64_encode($get_records['id']);?>"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-sm btn-danger show-tooltip" onclick="return confirm('Are You Sure You Want To Delete Record?')" title="" href="<?php echo base_url('/admin/email/delete/').base64_encode($get_records['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
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
            if(confirm("Do you really want to delete this record")==true)
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
            if(confirm("Do you really want to delete this record")==true)
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