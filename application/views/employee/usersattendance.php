<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Attendance
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Attendance Details</h3>
              <button type="button" class="btn bg-maroon btn-flat float-right btn-xs" value="downloadBtn" name="downloadBtn" onclick="printDiv('attendancetable')">Print <i class="fa fa-print"></i></button>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <?php
                  if($this->session->flashdata('success')){
                  ?>
                  <div class="alert alert-dismissable alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
                  </div>
                  <?php
                  }
                  
                  if($this->session->flashdata('error')){
                  ?>
                  <div class="alert alert-dismissable alert-danger">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                  </div>
                  <?php
                  }
                  ?>
                </div>
                    <div class="col-lg-12" id="attendancetable">
                   
                      <table id="" class="table table-condensed table-small-font table-bordered table-striped">
                      	<thead>
	                        <tr>
                            <th>Log Date</th>
	                          <th>Employee Name</th>
	                          <th>CheckIn Time</th>
                            <th>CheckIn Loc</th>
	                          <th>CheckOut Time</th>
                            <th>CheckOut Loc</th>
                            <th>Hour</th>
	                          <th>Status</th>
	                        </tr>
                        </thead>
                        <tbody id="attendancedata">
                        	<?php 
                              $users = $this->Common_Model->FetchData("employees","*","user_id=".$user_id." ");
                              $appratten = $this->Common_Model->FetchData("empapprove_attendance","*","user_id=".$user_id." AND month='".$month."' AND year='".$year."'");
                              if ($users) {

                                $ndate = '01-'.$month.'-'.$year;
                                $fdate = date('Y-m-01',strtotime($ndate));
                                $ldate = date('Y-m-t',strtotime($ndate));
                                
                                $dates = $this->Common_Model->getBetweenDates($fdate,$ldate);
                                //print_r($dates);
                              
                                $totwh=0;
                                $tothour =0;
                                $totminute=0;
                                if(!empty($dates)){
                                  foreach ($dates as $ke => $val) {
                                  $rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$users[0]['user_id']." AND status='1'");

                                  $rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$users[0]['user_id']." AND status='2'");
                                  if (!empty($rec1) && !empty($rec2)) {
                                      /*$datetime1 = new DateTime($rec1[0]['log_datetime']);
                                      $datetime2 = new DateTime($rec2[0]['log_datetime']);*/
                                      $login_timestamp = strtotime($rec1[0]['log_datetime']);
                                      $logout_timestamp = strtotime($rec2[0]['log_datetime']);
                                      $time_difference = $logout_timestamp - $login_timestamp;
               
                                      $hours = floor($time_difference / 3600);
                                      $time_difference %= 3600;
                                      $minutes = floor($time_difference / 60);
                                      $seconds = $time_difference % 60;
                                      $total_hours += $hours;
                                      $total_minutes += $minutes;
                                      $time_difference_formatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                                      $workinghour = date('H.i.s', strtotime($time_difference_formatted));
                                      $status='Present';
                                      $totattn +=1;
                                    }else{
                                      $status='Absent';
                                      $workinghour='0';
                                    } 

                                    if (!empty($rec1)) {
                                        $clockintime = $rec1[0]['log_datetime'];
                                        $clockinloc = $rec1[0]['log_loc'];
                                      }else{
                                        $clockintime = '--';
                                        $clockinloc = '';
                                      }

                                      if (!empty($rec2)) {
                                        $clockouttime = $rec2[0]['log_datetime'];
                                        $clockoutloc = $rec2[0]['log_loc'];
                                      }else{
                                        $clockouttime = '--';
                                        $clockoutloc = '';
                                      }
                                      if ($rec1) {
                                        
                                    ?>

                                    <tr>
                                      
                                      <td><?=date('d-m-Y',strtotime($val));?></td>
                                      <td><?=$users[0]['employee_name'];?></td>
                                      <td><?=$clockintime;?> &nbsp; &nbsp; &nbsp;
                                      <?php  if (empty($appratten)) { ?>
                                        <a href="javascript:void(0);" title="Update Price" class="clockintimebtn"><i class="fa fa-edit" style="color:maroon;"></i></a>

                                        <div class="modal clockintimeModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                              <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top:14%;padding: 40px;margin-right: 50% !important;">
                                                <div class="modal-content">
                                                  <div class="modal-body">
                                                    <input type="datetime-local" class="form-control input-sm clockintime" value="<?=$clockintime?$clockintime:'';?>"><br>
                                                    <input type="hidden" class="form-control input-sm clockintimelog_id" value="<?=$rec1?$rec1[0]['attendance_log_id']:'';?>">
                                                    <button type="button"  class="btn btn-primary btn-sm clockintimesubmitBtn">Update</button>
                                                    <button type="button"  class="btn btn-warning btn-sm" data-dismiss="modal">Cancel</button>
                                                  </div>
                                                  
                                                  
                                                </div>
                                              </div>
                                        </div>
                                        <?php  } ?>
                                      </td>
                                      <td><?=$clockinloc;?></td>
                                      <td><?=$clockouttime;?> &nbsp; &nbsp; &nbsp;
                                        <?php  if (empty($appratten)) { ?>
                                        <a href="javascript:void(0);" title="Update Price" class="clockouttimebtn"><i class="fa fa-edit" style="color:maroon;"></i></a>

                                        <div class="modal clockouttimeModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                              <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top:14%;padding: 40px;margin-right: 25% !important;">
                                                <div class="modal-content">
                                                  <div class="modal-body">
                                                    <input type="datetime-local" class="form-control input-sm clockouttime" value="<?=$clockouttime?$clockouttime:'';?>"><br>
                                                    <input type="hidden" class="form-control input-sm clockouttimelog_id" value="<?=$rec2?$rec2[0]['attendance_log_id']:'';?>">
                                                    <button type="button"  class="btn btn-primary btn-sm clockouttimesubmitBtn">Update</button>
                                                    <button type="button"  class="btn btn-warning btn-sm" data-dismiss="modal">Cancel</button>
                                                  </div>
                                                  
                                                  
                                                </div>
                                              </div>
                                        </div>
                                        <?php  } ?>
                                      </td>
                                      <td><?=$clockoutloc;?></td>
                                      <td><?=$workinghour;?></td>
                                      <td><?=$status;?></td>
                                    </tr>

                               <?php   }}
                                }}

                                $total_hours += floor($total_minutes / 60);
                                $total_minutes %= 60;

                                $hours = $total_hours;
                                $minutes = $total_minutes;
                                list($days, $remainingHours, $remainingMinutes) = hoursAndMinutesToDays($hours, $minutes,$users[0]['dutyhour']);
                                 ?>
                                 <tr>
                                    <th colspan="6">Total Working Hour</th>
                                    <th><?=$days.' days, '.$remainingHours.' hour, '.$remainingMinutes.'minutes';?></th>
                                    <th></th>
                                  </tr>
                        </tbody>
                        
                      </table>
                      <form action="<?=site_url("employee/attendanceapproval");?>" method="post">
                          <input type="hidden" name="user_id" value="<?=$user_id;?>">
                          <input type="hidden" name="month" value="<?=$month;?>">
                          <input type="hidden" name="year" value="<?=$year;?>">
                          <input type="hidden" name="days" value="<?=$days;?>">
                          <input type="hidden" name="hours" value="<?=$remainingHours;?>">
                          <input type="hidden" name="minutes" value="<?=$remainingMinutes;?>">
                          <input type="hidden" name="totatten" value="<?=$totattn;?>">
                        <?php  if (!empty($appratten)) { ?>
                                <h5 style="color:green;"><i class="fa fa-check"></i> Approved </h5>
                            <?php  }else{
                         ?>
                          <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure to approve this?');">Approve Attendance</button>
                        <?php } ?>
                      </form>
                      
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
  
  $(document).on('click','.clockouttimebtn',function(){
    var obj = $(this).closest("tr");
      obj.find(".clockouttimeModal").modal('toggle');
      obj.find(".clockouttimeModal").modal('show');
  });

  $(document).on('click','.clockintimebtn',function(){
    var obj = $(this).closest("tr");
      obj.find(".clockintimeModal").modal('toggle');
      obj.find(".clockintimeModal").modal('show');
  });


  $(document).on('click','.clockouttimesubmitBtn',function(){
    var obj = $(this).closest("tr");
    var clockouttimelog_id = obj.find('.clockouttimelog_id').val();
    var clockouttime = obj.find('.clockouttime').val();
    

      if (clockouttime != '' && clockouttimelog_id > 0) {
          $.ajax({
              url: '<?=site_url("employee/Updateclockouttime");?>',
              data: {clockouttimelog_id : clockouttimelog_id,clockouttime:clockouttime},
              dataType:"HTML",
              async: true,
              type:"POST",
              success:function(data){
                  window.location.reload();
              }
            });
        }  
  });

  $(document).on('click','.clockintimesubmitBtn',function(){
    var obj = $(this).closest("tr");
    var clockintimelog_id = obj.find('.clockintimelog_id').val();
    var clockintime = obj.find('.clockintime').val();
    

      if (clockintime != '' && clockintimelog_id > 0) {
          $.ajax({
              url: '<?=site_url("employee/Updateclockintime");?>',
              data: {clockintimelog_id : clockintimelog_id,clockintime:clockintime},
              dataType:"HTML",
              async: true,
              type:"POST",
              success:function(data){
                  window.location.reload();
              }
            });
        }  
  });

  function printDiv(attendancetable) {
     var printContents = document.getElementById(attendancetable).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

</body>
</html>

