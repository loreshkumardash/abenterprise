<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pending Leaves
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Pending Leave List</h3>
                
              </div>
              <div class="box-body">
                <table id="" class="table table-bordered table-condensed table-striped">
                  <tr>
                    <th style="text-align:center;">ID</th>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Applied From</th>
                    <th>Applied To</th>
                    <th>Number of Leave</th>
                    <th>Created On</th>
                    <th>Session</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                  <?php if($records){ for($i=0;$i<count($records);$i++){?>
                  <tr>
                    <td style="text-align:center;"><?php echo $records[$i]['leave_apply_id'];?></td>
                    <td><?php echo $records[$i]['employee_name'];?></td>
                    <td style="text-align:center;"><?php echo $records[$i]['leave_type'];?></td>
                    <td><?php echo date("d/m/Y", strtotime($records[$i]['apply_from']));?></td>
                    <td><?php echo date("d/m/Y", strtotime($records[$i]['apply_to']));?></td>
                    <td><?php echo $records[$i]['no_of_days'];?></td>
                    <td><?php echo date('d-m-Y H:iA',strtotime($records[$i]['created_on']));?></td>
                    <td><?php echo $records[$i]['session'];?></td>
                    <td><?php echo ($records[$i]['leave_status'] == 0)?'Pending':'Approved';?></td>
                    <td style="text-align:center;"><a href="<?=site_url("employee/approve_leave/".$records[$i]['leave_apply_id']);?>" class="btn btn-primary btn-xs">Action</a></td>
                  </tr>
                  <?php }}else{ echo '<tr><td colspan = "7"><center>Sorry!! No data found.</center></td></tr>';} ?>
                </table>
              </div>
          </div>
          <!-- /.box -->

         
        </div>
       
      </div>
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

<script type="text/javascript">
  $(document).ready(function(){
      
  });


function disableBtn(){
  $('#submitBtn').attr('disabled',true);
}

function checkLeaveavail(){
    if($('#leave_type').val() == ''){
      alert('Please select Leave Type.');
      $('#leave_type').focus();
      return false;
    }

    if($('#apply_from').val() == ''){
      alert('Please select Leave From Date');
      $('#apply_from').focus();
      return false;
    }

    if($('#apply_to').val() == ''){
      alert('Please select Leave To Date');
      $('#apply_to').focus();
      return false;
    }


    var leave_type = $('#leave_type').val();
    var employeeId = '<?=$employeeId?>';
    var curSession = '<?=$curSession?>';
    var apply_from = $('#apply_from').val();
    var apply_to   = $('#apply_to').val();
    $.ajax({
      method:'post',
      url: appUrl+'/Ajax_requests/checkLeaveavail',
      dataType:'json',
      data:{leave_type:leave_type,employeeId:employeeId,curSession:curSession,apply_from:apply_from,apply_to:apply_to},
      success:function(res){
        if(res.status === 500){
          alert(res.msg);
          $('#apply_from').focus();
        }else{
          var result     = res.result;
          var leaveType  = result[0]['leave_type'];
          var leaveCount = result[0]['leaveleft'];
          var dayDiffer  = res.daysDiff;
          $('#no_of_days').val(dayDiffer);
          $('.leavecount').html('<b><i>You have '+leaveCount+' leave left for '+leaveType+' Category</i></b>');

          if(parseInt(dayDiffer) > parseInt(leaveCount)){
            alert('Sorry You do not have sufficient leave for the selected Category and date range.');
          }else{
            $('#submitBtn').attr('disabled',false);
          }
        }
      }
    }); 
}
</script>
</body>
</html>
