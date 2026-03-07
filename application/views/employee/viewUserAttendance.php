<?php $this->load->view("common/meta");?>
<style type="text/css">
  .hovernow:hover {
  transform: scale(1)!important;
  -webkit-transform: scale(1)!important;
  -moz-transform: scale(1)!important;
  box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px!important;
  -webkit-box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px!important;
  -moz-box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px!important;
  cursor: pointer; 
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
              <h3 class="box-title">User Attendance</h3>
              
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
                <form method="post" action="<?=site_url('users/viewUserAttendance/'.$rec[0]['user_id']);?>" >
                  <div class="col-md-12 row">
                    
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="log_date">Log Date</label>
                        <input type="date" class="form-control" id="log_date" name="log_date" required>
                      </div>
                    </div>
                    
                    <div class="col-md-1">
                      <button type="submit" name="submitBtn" value="submit" class="btn btn-primary" style="margin-top:25px;" id="SearchBtn">Search</button>
                      
                    </div>
                    
                    </div>
                  </form>
                
                  <div class="col-lg-12">
                    <table style="font-size: 14px;font-family: serif;">
                      <tr>
                        <td width="10%">User Id </td>
                        <td width="90%">: <b><?=$rec[0]['user_id'];?></b></td>
                      </tr>
                      <tr>
                        <td width="10%">Name </td>
                        <td width="90%">: <b><?=$rec[0]['firstname'];?> <?=$rec[0]['lastname'];?></b></td>
                      </tr>
                    </table>
                      <table id="" class="table table-condensed table-small-font table-bordered table-striped">
                      	<thead>
	                        <tr>
	                          <th>Sl#</th>
	                          <th>User Id</th>
	                          
	                          <th>Log Date</th>
	                          <th>Check in Time</th>
	                          <th>Check Out Time</th>
	                          <th>Status</th>
	                        </tr>
                        </thead>
                        <tbody id="attendancedata">
                        	<?php
                              $dates = $this->Common_Model->getBetweenDates($ldate,$fdate);
                              //print_r($dates);exit;
                           if(!empty($dates)){

                            $dtcnt=0;
                            foreach ($dates as $ke => $val) {
                              $dtcnt +=1;
                              $rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$rec[0]['user_id']." AND status='1'");

                              $rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$rec[0]['user_id']." AND status='2'");

                              $recusr = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$rec[0]['user_id']."");
                              if ($recusr) {
                                
                              
                              if ($rec1) {
                                $checkin = date('d-m-Y H:i:s',strtotime($rec1[0]['log_datetime']));
                              }else{
                                $checkin = '';
                              }
                              

                                if (!empty($rec1) && !empty($rec2)) {
                                  $status='Present';
                                }else{
                                  $status='Absent';
                                }

                                if (!empty($rec2)) {
                                  $clockouttime = date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime']));
                                }else{
                                  $clockouttime = 0;
                                } ?>

                               

                                <tr style="border: hidden;margin-top:8px;box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;border-radius: 9px;" class="hovernow" data-id="<?=$rec[0]['user_id'];?>" data-date="<?=$val;?>">
                                  <td><?=$dtcnt;?></td>
                                  <td><?=$rec[0]['user_id'];?></td>
                                  <td><?=$val;?></td>
                                  <td><?=$checkin;?></td>
                                  <td><?=$clockouttime;?></td>
                                  <td><?=$status;?></td>
                                </tr>
                          <?php  
                          } } }?>
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
  $(document).on('click','.hovernow',function(){
    var user_id= $(this).attr('data-id');
    var user_date= $(this).attr('data-date');
    var appUrl = '<?=site_url();?>';
    document.location.href=appUrl+'/users/viewRecordonMap/'+user_id+'/'+user_date;
  });

  if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</body>
</html>