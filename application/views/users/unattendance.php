<?php $this->load->view("common/meta");?>
<style type="text/css">
	.hovernow:hover {
  transform: scale(1)!important;
  -webkit-transform: scale(1)!important;
  -moz-transform: scale(1)!important;
  
  cursor: pointer;
  font-weight: 600;
}
</style>
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
              <h3 class="box-title">Attendance</h3>
              
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
                
              
                  
                 
                
                  <div class="col-lg-12">
                    <form method="post" action="<?=site_url("users/unattendance");?>">
                        <div class="row">
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
                              <label for="year">Year</label>
                              <select class="form-control form-control-sm" name="year" id="year" required="required">
                                  
                                <?php $yr = date("Y"); for ($y=0; $y < 6; $y++) { 
                                  $yrr = $yr - $y;
                                  $sel = $yrr == $year ? 'selected="selected"' : '';
                                  echo '<option value="'.$yrr.'" '.$sel.'>'.$yrr.'</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-md-2">
                                <label for="month">Month</label>
                              <select class="form-control form-control-sm" name="month" id="month" required="required" >
                                <option value="">Select</option>
                                <option value="01" >Jan</option>
                                <option value="02" >Feb</option>
                                <option value="03" >Mar</option>
                                <option value="04" >Apr</option>
                                <option value="05" >May</option>
                                <option value="06" >Jun</option>
                                <option value="07" >Jul</option>
                                <option value="08" >Aug</option>
                                <option value="09" >Sept</option>
                                <option value="10" >Oct</option>
                                <option value="11" >Nov</option>
                                <option value="12" >Dec</option>
                              </select>
                            </div>
                            <div class="col-md-4" style="margin-top:25px;">
                                <button type="submit" class="btn bg-navy btn-flat" name="searchBtn" value="searchBtn">Searech</button>
                               <?php if ($unit_id >0 && $month >0 && $year >0) { ?>
                                <button type="button" class="btn bg-maroon btn-flat" value="downloadBtn" name="downloadBtn" onclick="printDiv('attendancetable')">Print</button>
                              <?php } ?>
                            </div>
                          </div>
                        </form>
                        <div  id="attendancetable">
                          <h4 style="text-decoration: underline;">Unit Attendance</h4>
                      <table class="table" cellpadding="2" >
                      	<thead>
	                        <tr>
	                          <th width="5%">Sl#</th>
	                          <th>Unit Code</th>
                            <th>Employee Code</th>
                            <th>Employee Name</th>
                            <th width="15%">Designation</th>
                            <th width="15%">Month-Year</th>
                            <th width="15%">Number of Attendance</th>
	                          
	                        </tr>
                        </thead>
                        
                        <tbody>
                        	<?php 
                          if ($unit_id >0 && $month >0 && $year >0) {

                            $rec = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id LEFT JOIN designation as c on b.designation_id=c.designation_id","a.*,b.employee_name,b.techno_emp_id,c.designation_name","MONTH(log_date)='".$month."' AND YEAR(log_date)='".$year."' AND unit_id=".$unit_id." AND status='1' GROUP BY employee_id");
                            //print_r($rec1);exit;


                          
                        			
                        			if ($rec) {

                                $ndate = '01-'.$month.'-'.$year;
                                $fdate = date('Y-m-01',strtotime($ndate));
                                $ldate = date('Y-m-t',strtotime($ndate));
                                
                                $dates = $this->Common_Model->getBetweenDates($fdate,$ldate);
                                //print_r($dates);
                               for ($i=0; $i <count($rec) ; $i++) { 
                                $totattn=0;






                                if(!empty($dates)){
                                  foreach ($dates as $ke => $val) {
                                  $rec1 = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id","a.*,b.employee_name,b.techno_emp_id","log_date='".$val."' AND unit_id=".$unit_id." AND user_id=".$rec[$i]['user_id']." AND status='1' GROUP BY employee_id");

                                  $rec2 = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id","a.*,b.employee_name,b.techno_emp_id","log_date='".$val."' AND unit_id=".$unit_id." AND user_id=".$rec[$i]['user_id']." AND status='2' GROUP BY employee_id");
                                  if (!empty($rec1) && !empty($rec2)) {
                                      $status='Present';
                                      $totattn +=1;
                                    }else{
                                      $status='Absent';

                                    }
                                  }
                                }
                                 ?>
                        				
                        			
                        	<tr style="border: hidden;margin-top:8px;box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;border-radius: 9px;" class="hovernow" data-id="<?=$rec[$i]['user_id'];?>">
		                      <td width="5%" class="text-center"><span class="circle"><?=$i + 1;?></span></td>
		                      <td width="10%"><?=$rec[$i]['unit_id'];?></td>
                          <td width="10%"><?=$rec[$i]['techno_emp_id'];?></td>
		                      <td width="40%" class=""><?=$rec[$i]['employee_name'];?></td>
                          <td width="15%"><?=$rec[$i]['designation_name'];?></td>
                          <td width="15%"><?=$month.'-'.$year;?></td>
                          <td width="15%"><?=$totattn;?></td>
		                      
		                      
		                    </tr>
		                   <?php } }else{
                                echo '<tr><td colspan="7">No records found !!</td></tr>';
                              }
                        		}
                        	 ?>
                        </tbody>
                        
                      </table>
                      </div>
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
	$(document).on('click','.hovernow',function(){
		var user_id= $(this).attr('data-id');
    var month= '<?=$month;?>';
    var year= '<?=$year;?>';
    var unit_id= '<?=$unit_id;?>';
		var appUrl = '<?=site_url();?>';
		document.location.href=appUrl+'/users/unitattendance/'+user_id+'/'+month+'/'+year+'/'+unit_id;
	});

	if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

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