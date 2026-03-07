<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Unit Attendance
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Unit Attendance</h3>
              <?php if ($unit_id >0 && $month >0 && $year >0 && $user_id >0) { ?>
              <button type="button" class="btn bg-maroon btn-flat float-right btn-xs" value="downloadBtn" name="downloadBtn" onclick="printDiv('attendancetable')">Print <i class="fa fa-print"></i></button>
            <?php } ?>
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
                <!-- <form method="post" action="<?=site_url("users/downloadunitattendance");?>" target="_blank">
                  <div class="col-md-12 row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="user_id">Unit</label>
                        <select class="form-control" id="unit_id" name="unit_id">
                          <option value="">Select</option>
                         <?php  if ($records) {
                        	$accessar = json_decode($records[0]['unit_access']);
                        	//print_r($accessar);
                        }else{
                        	$accessar='';
                        } ?> 

                        <?php if ($accessar) {
                        		foreach ($accessar as $key => $value) {
                        			$units = $this->Common_Model->FetchData("units","*","unit_id=".$value);
                        			if ($units) {  ?>
                              <option value="<?=$units[0]['unit_id'];?>"><?=$units[0]['unit_name'];?></option>
                          <?php  }}} ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="log_date">Log Date</label>
                        <input type="date" class="form-control" id="log_date" name="log_date" required>
                      </div>
                    </div>
                    
                    <div class="col-md-1">
                      <button type="button" name="submitBtn" value="submit" class="btn btn-primary" style="margin-top:25px;" id="SearchBtn">Search</button>
                      
                    </div>
                    <div class="col-md-2">
                      
                      <button type="submit" name="downloadBtn" value="submit" class="btn bg-maroon btn-flat margin" style="margin-top:25px;" >Download</button>
                    </div>
                    </div>
                  </form> -->
                
                  <div class="col-lg-12" id="attendancetable">
                      <table id="" class="table table-condensed table-small-font table-bordered table-striped">
                      	<thead>
	                        <tr>
	                          <th>Sl#</th>
	                          <th>Unit Code</th>
	                          <th>Employee Code</th>
	                          <th>Employee Name</th>
	                          <th>Log Date</th>
	                          <th>Check in Time</th>
	                          <th>Check Out Time</th>
	                          <th>Hours</th>
	                          <th>Status</th>
	                        </tr>
                        </thead>
                        <tbody id="attendancedata">
                        	<?php 
                                $users = $this->Common_Model->FetchData("users as a LEFT JOIN employees as b on a.employee_tagged_id=b.employee_id LEFT JOIN designation as c on b.designation_id=c.designation_id","*","a.user_id=".$user_id." ");
                                $ndate = '01-'.$month.'-'.$year;
                                $fdate = date('Y-m-01',strtotime($ndate));
                                $ldate = date('Y-m-t',strtotime($ndate));
                                
                                $dates = $this->Common_Model->getBetweenDates($fdate,$ldate);
                            if (!empty($users)) {

                              if(!empty($dates)){
                                  foreach ($dates as $ke => $val) {

                                $rec1 = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id","a.*,b.employee_name,b.techno_emp_id","log_date='".$val."' AND unit_id=".$unit_id." AND user_id=".$user_id." AND status='1'");
                                 
                                $rec2 = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id","a.*,b.employee_name,b.techno_emp_id","log_date='".$val."' AND unit_id=".$unit_id." AND user_id=".$user_id." AND status='2'");
                                
                                
                                
                                if ($rec1 && $rec1[0]['log_datetime']) {
                                  $checkin = date('d-m-Y H:i:s',strtotime($rec1[0]['log_datetime']));
                                }else{
                                  $checkin = '--';
                                }

                                if ($rec2 && $rec2[0]['log_datetime']) {
                                  $checkout = date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime']));
                                }else{
                                  $checkout = '--';
                                }

                                if (!empty($rec1[0]['log_datetime']) && !empty($rec2[0]['log_datetime'])) {
                                  $datetime1 = new DateTime($rec1[0]['log_datetime']);
                                  $datetime2 = new DateTime($rec2[0]['log_datetime']);
                                  $interval = $datetime1->diff($datetime2);
                                  $workinghour = $interval->format('%h').".".$interval->format('%i')."";
                                  
                                  $status = 'Present';
                                }else{
                                  $status = 'Absent';
                                  $workinghour = '';
                                }
                                if($status=='Present'){
                                echo '<tr><td>'.($ke + 1).'</td><td>'.$unit_id.'</td><td>'.$users[0]['techno_emp_id'].'</td><td>'.$users[0]['employee_name'].'</td><td>'.date('d-m-Y',strtotime($val)).'</td><td>'.$checkin.'</td><td>'.$checkout.'</td><td>'.$workinghour.'</td><td>'.$status.'</td></tr>';
                              }
                                }
                              }else{
                                echo 'No records found !!';
                              }
                            }
                           ?>
                        </tbody>
                        
                      </table>
                      
                  </div>
          </div>
        </div>
        </form>
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
  /*$(document).on('click', '#SearchBtn', function(){
  
        var unit_id = $("#unit_id").val();
        var log_date = $("#log_date").val();
       if (log_date == '') {
       	alert('log date required for attendance');
       	return false;
       }

          $.ajax({
              url: '<?=site_url("users/get_unitAttendance");?>',
              data: {unit_id : unit_id,log_date:log_date},
              dataType:"HTML",
              type:"POST",
              success:function(data){
              if(data){
                $("#attendancedata").html(data);
                    
                  
              }else{
              	 $("#attendancedata").html('');
              }
          }
          }); 
            
});*/

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
