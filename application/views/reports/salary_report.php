<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Employee Salary Report</h3>
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
                <form role="form" action="" method="post" id="searchForm">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="session_id">Session</label>
                    <select class="form-control " id="session_id" name="session_id" readonly="readonly">
                      <?php if($sessions){ for($i=0;$i<count($sessions);$i++){if($sessions[$i]['active_session'] == 'Active'){?>
                      <option value="<?php echo $sessions[$i]['session_id'];?>" <?php echo $sessions[$i]['active_session'] == 'Active' ? 'selected="selected"' : '';?>><?php echo $sessions[$i]['session_name'];?></option>
                      <?php }}}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6" style="padding-top: 15px;">
                  <button type="submit" formaction="<?php echo site_url("reports/salary_report");?>" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin">Search</button>
                  <button type="submit" formaction="<?php echo site_url("reports/download_salary_report");?>" name="submitBtn1" value="submit" class="btn bg-navy btn-flat margin">Download</button>
                </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <?php
                  if(isset($employees) && $employees){
                    ?>
                  <table class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th>Sl No</th>
                      <th>Employee Names</th>
                      <?php
                      if($months){
                        foreach ($months as $month) {
                          echo '<th>'.$month['strmonth'].'</th>';
                        }
                      }
                      ?>
                    </tr>
                    <?php
                    $sl = 1;
                    for($i=0;$i<count($employees);$i++){
                      
                    ?>
                    <tr>
                      <th><?=$sl++;?></th>
                      <th><?php echo $employees[$i]['employee_name'];?></th>
                        <?php
                      
                      if($months){
                        foreach ($months as $month) {
                          $feelist = db_query("SELECT * FROM salary_transaction WHERE month = '".$month['month']."' AND year = '".$month['year']."' AND employee_id = ".$employees[$i]['employee_id']."");
                          if($feelist){
                            $tdclass = '';
                            $amount = 0;
                            $status = '';
                            if($feelist[0]['credit_status'] == '1'){
                              $tdclass = 'success';
                              $amount = (int)$feelist[0]['salary_credit'];
                              $status = 'Paid';
                            }
                            if($feelist[0]['credit_status'] == '0'){
                              $tdclass = 'danger';
                              $amount = (int)$employees[$i]['salary'];
                              $status = 'Pending';
                            }
                            
                      ?>
                      <td class="<?=$tdclass;?>"><?php echo $status.' - '.$amount;?></td>
                      <?php
                          }else{
                      ?>
                      <td class="info">-</td>
                      <?php
                          }
                        }
                      }
                      ?>
                    </tr>
                    <?php
                    }
                    ?>
                  </table>
                    <?php
                  }
                  ?>
                </div>
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

  function searchForm(){
    $.ajax({
      url:"<?php echo site_url('student/liststudents_ajax');?>",
      type:"POST",
      data: $("#searchForm").serialize(),
      dataType:"html",
      success: function(data){
        $('#dataTablediv').html(data);
      }
    });
  }
  $(document).ready(function(){
  
  });
</script>
</body>
</html>