<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Leave Application
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <!--<img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">-->
              <h3 class="profile-username text-center"><?php echo $employee[0]['employee_name'];?></h3>

              <p class="text-muted text-center">#ID : <?php echo $employee[0]['employee_id'];?></p>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">Apply Leave</a></li>
              <li><a href="#receipts" data-toggle="tab">Leave History</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="profile">
                <table class="table table-bordered table-condensed table-striped">
                  <tr>
                    <th colspan="2">Employee Name</th>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $employee[0]['employee_name'];?></td>
                  </tr>
                  <tr>
                    <th>Father's/Husband's Name</th>
                    <th>Aadhar Number</th>
                  </tr>
                  <tr>
                    <td><?php echo $employee[0]['fathus_name'];?></td>
                    <td><?php echo $employee[0]['aadhar_number'];?></td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <th>Phone Number</th>
                  </tr>
                  <tr>
                    <td><?php echo $employee[0]['employee_email'];?></td>
                    <td><?php echo $employee[0]['employee_mobile'];?></td>
                  </tr>
                  <tr>
                    <th colspan="2">Employee Address</th>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $employee[0]['employee_address'];?></td>
                  </tr>
                </table>


                <form role="form" action="<?php echo site_url("employee/applyleave/").$employeeId;?>" method="post">
                  <div class="row">
                    <div class="box-body col-md-6">
                      <div class="form-group">
                        <label for="total_amt_taken">Select Leave Type</label>
                        <select class="form-control" id="leave_type" name="leave_type" required="" onchange="return disableBtn();">
                          <option value="">-Select-</option>
                          <?php if(!empty($leaveMaster)){
                                    foreach ($leaveMaster as $k => $v) {
                                      # code...
                                      echo "<option value='".$v['leave_id']."'>".$v['leave_type']."</option>";
                                    }
                          }?>  
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="apply_from">Leave From</label>
                        <input type="date"  onchange="return disableBtn();" class="form-control" min="<?=date('Y-m-d');?>" id="apply_from" name="apply_from" required="">
                      </div>


                      <div class="form-group">
                        <label for="apply_to">Leave To</label>
                        <input type="date" class="form-control"  onchange="return disableBtn();" min="<?=date('Y-m-d');?>" id="apply_to" name="apply_to" required="">
                      </div>

                      <a href="javascript:void(0);" class="btn btn-success" onclick="return checkLeaveavail();">Check Leave Availability</a>
                      <br><br>
                      <div class="leavecount badge badge-warning"></div>

                    </div>
                  </div>

                  <div class="box-footer">
                    <input type="hidden" name="no_of_days" id="no_of_days">
                    <button type="submit" name="submitBtn" id="submitBtn" disabled="" value="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>

              </div>

              <div class="tab-pane" id="receipts">
                <table id="" class="table table-bordered table-condensed table-striped">
                  <tr>
                    <th>ID</th>
                    <th>Leave Type</th>
                    <th>Applied From</th>
                    <th>Applied To</th>
                    <th>Number Of Leave Taken</th>
                    <th>Session</th>
                    <th>Status</th>
                  </tr>
                  <?php if($records){ for($i=0;$i<count($records);$i++){?>
                  <tr>
                    <td><?php echo $records[$i]['leave_apply_id'];?></td>
                    <td><?php echo $records[$i]['leave_type'];?></td>
                    <td><?php echo date("d/m/Y", strtotime($records[$i]['apply_from']));?></td>
                    <td><?php echo date("d/m/Y", strtotime($records[$i]['apply_to']));?></td>
                    <td><?php echo $records[$i]['no_of_days'];?></td>
                    <td><?php echo $records[$i]['session'];?></td>
                    <td><?php echo ($records[$i]['leave_status'] == 0)?'Pending':'Approved';?></td>
                  </tr>
                  <?php }}else{ echo '<tr><td colspan = "7"><center>Sorry!! No data found.</center></td></tr>';} ?>
                </table>
              </div>
              
            </div>
          </div>
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