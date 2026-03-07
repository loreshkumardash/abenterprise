<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pending Leave
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Action #<?=$rec[0]['leave_apply_id'];?> </h3>
                
              </div>
              <form method="post" action="<?=site_url("employee/approve_leave/".$leave_apply_id);?>">
              <div class="box-body">
                <div class="col-md-8">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Employee Name</label>
                      </div>
                      <div class="col-md-9">
                      : <?=$rec[0]['employee_name'];?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <label>Date From </label>
                      </div>
                      <div class="col-md-9">
                      : <?=$rec[0]['apply_from'];?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <label>Date To</label>
                      </div>
                      <div class="col-md-9">
                      : <?=$rec[0]['apply_to'];?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <label>Number of Leave</label>
                      </div>
                      <div class="col-md-9">
                      : <?=$rec[0]['no_of_days'];?> 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <label>Created On</label>
                      </div>
                      <div class="col-md-9">
                      : <?=date('d-m-Y H:iA',strtotime($rec[0]['created_on']));?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <label>Reason</label>
                      </div>
                      <div class="col-md-9">
                      : <?=$rec[0]['leavereason'];?>
                      </div>
                    </div>
                  <div class="row" style="margin-top:6px;">
                  <div class="col-md-3">
                    <label>Leave Type</label>
                  </div>
                  <div class="col-md-3">
                    <select class="form-control" name="leave_type" id="leave_type" required>
                      <option value="">select</option>
                        <?php if($leavetypes){ for($i=0;$i<count($leavetypes);$i++){?>
                        <option value="<?=$leavetypes[$i]['leave_id']?>" <?=$leavetypes[$i]['leave_id'] == $rec[0]['leave_type']?'selected':'';?>><?=$leavetypes[$i]['leave_type']?></option>
                        <?php }}?>
                    </select>
                    </div>
                  </div>
                
                  <div class="row" style="margin-top:6px;">
                  <div class="col-md-3">
                    <label>Status</label>
                  </div>
                  <div class="col-md-3">
                    <select class="form-control" name="leave_status" id="leave_status" required>
                      <option value="0" <?=$rec[0]['leave_status']=='0'?'selected':'';?>>Pending</option>
                      <option value="1" <?=$rec[0]['leave_status']=='1'?'selected':'';?>>Approved</option>
                      <option value="2" <?=$rec[0]['leave_status']=='2'?'selected':'';?>>Rejected</option>
                        
                    </select>
                    </div>
                  </div>
                </div>
              </div>
          <!-- /.box -->
              
              <div class="col-md-4">
                <label>Leave List</label>
                <table class="table table-striped table-condensed">
                  <tr>
                    <th>Sl</th>
                    <th>Leave type</th>
                    <th>Leave left</th>
                  </tr>

                  <?php if($leavetypes){ for($i=0;$i<count($leavetypes);$i++){

                    $totleave =  $this->Common_Model->db_query("SELECT SUM(no_of_days) AS totalleave FROM leave_application WHERE employee_id = ".$rec[0]['employee_id']." AND session = '".$curSession."' AND leave_type='".$leavetypes[$i]['leave_id']."' AND leave_status = '1' " );
                      if ($totleave[0]['totalleave']) {
                        $leave = $totleave[0]['totalleave'];
                      }else{
                        $leave = 0;
                      }
                     $opel_bal = $rec[0]['el_opbalance'] ?? 0;


                    if ($leavetypes[$i]['leave_type'] == 'EL') {
                      $records = $this->Common_Model->db_query("SELECT A.leave_type,((A.leave_count + $opel_bal)-$leave) AS leaveleft FROM leave_master A LEFT JOIN leave_application B ON (A.leave_id = B.leave_type AND B.employee_id = ".$rec[0]['employee_id']." AND B.session = '".$curSession."' AND B.leave_status = '1') WHERE A.leave_id = ".$leavetypes[$i]['leave_id']." GROUP BY leave_id");
                    }else{
                      $records = $this->Common_Model->db_query("SELECT A.leave_type,(A.leave_count-$leave) AS leaveleft FROM leave_master A LEFT JOIN leave_application B ON (A.leave_id = B.leave_type AND B.employee_id = ".$rec[0]['employee_id']." AND B.session = '".$curSession."' AND B.leave_status = '1') WHERE A.leave_id = ".$leavetypes[$i]['leave_id']." GROUP BY leave_id");
                    }



                    ?>
                  <tr>
                    <td><?=$i+1;?></td>
                    <td><?=$leavetypes[$i]['leave_type'];?></td>
                    <td><?=$records[0]['leaveleft'];?></td>
                  </tr>
                  <?php }} ?>
                </table>
              </div>
         
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary" name="submitBtn" value="Submit" onclick="return confirm('Are you sure to approve this leave?');">Submit</button>
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
  $(document).ready(function(){
      
  });



</script>
</body>
</html>
