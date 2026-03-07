<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee
        <small>Feedback</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Feedback</h3>
              <a href="<?=site_url("employee/addstudentfeedback");?>" class="btn btn-primary btn-sm pull-right">Add New</a>
            </div>
            <div class="box-body">
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
              <table class="table table-striped">
                  <tr>
                    <th>Sl No</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <!--<th>Subject</th>-->
                    <!--<th>Subject Remark</th>-->
                    <th>Feedback</th>
                    <th>Action</th>
                  </tr>
                  <?php if($records){
                    $cnt = 0;
                     for($i=0;$i<count($records);$i++){ 
			$t = explode(" ",$records[$i]['student_id']);
                      foreach ($t as $key => $vl) {
                        $sel = $this->Common_Model->db_query("SELECT * FROM students WHERE student_id = $vl");
                        foreach ($sel as $k => $v) {
                      $cnt++;
                  ?>
                      <tr>
                        <td><?=$cnt;?></td>
                        <td><?=$v['student_first_name'].' '.$v['student_first_name'];?></td>
                        <td><?=$records[$i]['class_name'];?></td>
                        <!--<td><?=$records[$i]['subject_name'];?></td>-->
                        <td><?=$records[$i]['remark'];?></td>
                        <td><?=$records[$i]['other_remark'];?></td> 
                        <td>
                          <a href="<?=site_url('employee/addstudentfeedback/'.$records[$i]['feed_id']);?>" class="btn btn-warning btn-xs">Edit</a>
                          <a href="<?=site_url('employee/delete_feedback/'.$records[$i]['feed_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                        </td>
                      </tr>
                  <?php } } } }?>
                </table>
            </div>
            <div class="card-footer">
              <?php if($records){echo $sPages; }?>
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
</body>
</html>