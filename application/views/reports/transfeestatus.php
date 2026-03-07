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
              <h3 class="box-title">Transport Fee Status</h3>
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
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="class_id">Class</label>
                    <select class="form-control " id="class_id" name="class_id">
                      <option value=""></option>
                      <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                      <option value="<?php echo $classes[$i]['class_id'];?>" <?php echo set_value('class_id') == $classes[$i]['class_id'] ? 'selected="selected"' : '';?>><?php echo $classes[$i]['class_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6" style="padding-top: 15px;">
                  <button type="submit" formaction="<?php echo site_url("reports/transfeestatus");?>" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin">Search</button>
                  <button type="submit" formaction="<?php echo site_url("reports/download_transfee_list");?>" name="submitBtn2" formtarget="_blank" value="submit" class="btn bg-navy btn-flat margin">Download</button>
                </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <?php
                  if(isset($students) && $students){
                    ?>
                  <table class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th>Sl No</th>
                      <th>Student Name</th>
                      <th>Total Fee</th>
                      <th>Pending Fee</th>
                      <th>Student Email</th>
                      <th>Student Mobile</th>
                      <th>Father Name</th>
                      <th>Father Mobile</th>
                      <th>Mother Name</th>
                      <th>Mother Mobile</th>
                    </tr>
                    <?php
                    $sl = 1;
                    for($i=0;$i<count($students);$i++){
                        ?>
                    <tr>
                      <th><?=$sl++;?></th>
                      <th><?php echo $students[$i]['student_first_name'].' '.$students[$i]['student_last_name'];?></th>
                      <th><?php echo $students[$i]['total_transfee'];?></th>
                      <th><?php echo $students[$i]['pending_transfee'];?></th>
                      <th><?php echo $students[$i]['student_email'];?></th>
                      <th><?php echo $students[$i]['student_mobile'];?></th>
                      <th><?php echo $students[$i]['father_name'];?></th>
                      <th><?php echo $students[$i]['father_contact_no'];?></th>
                      <th><?php echo $students[$i]['mother_name'];?></th>
                      <th><?php echo $students[$i]['mother_contact_no'];?></th>
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