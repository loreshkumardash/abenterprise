<?php $this->load->view("common/meta");?>

<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bulk Assign Student to Route
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <!-- /.box-header -->
            <form role="form" method="post">
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

                <div class="col-md-5">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="registration_no">Select Session</label>
                      <select class="form-control loadstudent" id="session_id" name="session_id">
                        <?php if($sessions){ for($i=0;$i<count($sessions);$i++){
                          ?>
                        <option value="<?php echo $sessions[$i]['session_id'];?>" <?php echo $sessions[$i]['active_session'] == 'Active' ? 'selected="selected"' : '';?>><?php echo $sessions[$i]['session_name'];?></option>
                        <?php }}//}?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="description">Selelct Class</label>
                      <select class="form-control loadstudent" id="class_id" name="class_id">
                      <option value="">-Select-</option>
                      <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                      <option value="<?php echo $classes[$i]['class_id'];?>"><?php echo $classes[$i]['class_name'];?></option>
                      <?php }}?>
                    </select>
                    </div>


                    <div class="col-md-6">
                      <label for="description">Selelct Stoppage</label>
                      <select class="form-control" id="stoppage_id" name="stoppage_id" required="">
                      <option value="">-Select-</option>
                    </select>
                    </div>

                  </div>
                </div>
              </div>
              
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" onclick="return checkonecheckbox();" class="btn btn-primary">Submit</button>
            </div>
              <table class="table table-striped">
                <tr>
                  <th>#ID</th>
                  <th>&nbsp;</th>
                  <th>Student Name</th>
                  <th>Gender</th>
                  <th>Mobile</th>
                  <th>Father's Name</th>
                  <th>Mother's Name</th>
                  <th>Guardian Details</th>
                </tr>
                <tbody id="appendTr"></tbody>
              </table>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>
<script type="text/javascript">
$(document).ready(function(){
  loadStoppage('stoppage_id',<?php echo $routeId;?>);
});
$('.loadstudent').change(function(){
  var session_id = $('#session_id').val();
  var class_id   = $('#class_id').val();
  loadstudentagainstclass('appendTr',class_id,session_id);
});

function checkonecheckbox(){
  if($('.stud_ids:checkbox:checked').length == 0){
    alert('Check atleast one student to assign.');
    return false;
  }else{
    return true;
  }
}
</script>
</body>
</html>
