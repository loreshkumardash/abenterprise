<?php $this->load->view("common/meta");?>
<style type="text/css">
	.hovernow:hover {
  transform: scale(1)!important;
  -webkit-transform: scale(1)!important;
  -moz-transform: scale(1)!important;
  
  cursor: pointer;
  font-weight: 600;
  background: #D6DBDF;
}
</style>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Attendance
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
                    <form method="post" action="<?=site_url("employee/uattendance");?>">
                    <div class="row">
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
                                <button type="button" class="btn bg-maroon btn-flat" value="downloadBtn" name="downloadBtn" onclick="printDiv('attendancetable')">Print</button>
                            </div>
                          </div>
                        </form>
                        <div  id="attendancetable">
                          <h4 style="text-decoration: underline;">User Attendance</h4>
                      <table class="table" cellpadding="3" >
                      	<thead>
	                        <tr>
	                          <th width="5%">Sl#</th>
	                          <th width="10%">Employee Id</th>
                            <th width="40%">User Name</th>
                            <th width="15%">Designation</th>
                            <th width="15%">Month-Year</th>
                            <th width="15%">Number of Attendance</th>
	                          
	                        </tr>
                        </thead>
                        
                        <tbody>
                        	<?php 
                        			if ($this->session->userdata('usertype') =='Admin') {
                            $employees = $this->Common_Model->FetchData("employees as a LEFT JOIN designation as b on a.designation_id=b.designation_id","*","1 ORDER BY a.employee_name ASC");
                          }else{
                            $tracking = $this->Common_Model->FetchData("access_tracking","*","access_userid=".$this->session->userdata('user_id'));
                            if ($tracking) {
                                $access = json_decode($tracking[0]['tracking_access']);
                            
                                  if ($access) { for ($j=0; $j <count($access) ; $j++) { 
                                      if(!empty($access[$j]) && $access[$j] > 0){
                                        if ($j==0) {
                                          $eassign = $access[$j]."";
                                        }else{
                                         $eassign = $eassign . ",'".$access[$j]."' ";
                                        }
                                      }
                                    }}
                                  }else{
                                    $eassign ='';
                                  }
                               $employees = $this->Common_Model->FetchData("employees as a LEFT JOIN designation as b on a.designation_id=b.designation_id","*","a.user_id IN (" .$eassign. ") ORDER BY a.employee_name ASC");   
                          }
                        			if ($employees) {

                                $ndate = '01-'.$month.'-'.$year;
                                $fdate = date('Y-m-01',strtotime($ndate));
                                $ldate = date('Y-m-t',strtotime($ndate));
                                
                                $dates = $this->Common_Model->getBetweenDates($fdate,$ldate);
                                //print_r($dates);
                               for ($i=0; $i <count($employees) ; $i++) { 
                                $totattn=0;
                                if(!empty($dates)){
                                  foreach ($dates as $ke => $val) {
                                  $rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$employees[$i]['user_id']." AND status='1'");

                                  $rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$employees[$i]['user_id']." AND status='2'");
                                  if (!empty($rec1) && !empty($rec2)) {
                                      $status='Present';
                                      $totattn +=1;
                                    }else{
                                      $status='Absent';

                                    }
                                  }
                                }
                                 ?>
                        				
                        			
                        	<tr style="border: hidden;margin-top:8px;border-radius: 9px;" class="hovernow" data-id="<?=$employees[$i]['user_id'];?>">
		                      <td width="5%" class="text-center"><span class="circle"><?=$i + 1;?></span></td>
		                      <td width="10%"><?=$employees[$i]['employee_id'];?></td>
		                      <td width="40%" class=""><?=$employees[$i]['employee_name'];?></td>
                          <td width="15%"><?=$employees[$i]['designation_name'];?></td>
                          <td width="15%"><?=$month.'-'.$year;?></td>
                          <td width="15%"><?=$totattn;?></td>
		                      
		                      
		                    </tr>
		                   <?php } }
                        		
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
		var appUrl = '<?=site_url();?>';
		document.location.href=appUrl+'employee/usersattendance/'+user_id+'/'+month+'/'+year;
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