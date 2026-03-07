<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee
        <small>Material</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Material</h3>
              <a href="<?=site_url("employee/addstudymaterial");?>" class="btn btn-primary btn-sm pull-right">Add Material</a>
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
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Chapter</th>
                    <th>File</th>
                    <th>Remark</th>
                    <th>Action</th>
                  </tr>
                  <?php if($records){
                    $cnt = 0;
                     for($i=0;$i<count($records);$i++){ 
                      $cnt++;
                  ?>
                      <tr>
                        <td><?=$cnt;?></td>
                        <td><?=$records[$i]['class_name'];?></td>
                        <td><?=$records[$i]['subject_name'];?></td>
                        <td><?=$records[$i]['chapter_name'];?></td>
                        <th><?=($records[$i]['material_file'])?'<a target="_blank" href="'.base_url().'uploads/material/'.$records[$i]['material_file'].'">File</a>':'--';?></th>
                        <td><?=$records[$i]['material_remark'];?></td> 

                        <td>
                          <a href="<?=site_url('employee/addstudymaterial/'.$records[$i]['material_id']);?>" class="btn btn-warning btn-xs">Edit</a>
                          <a href="<?=site_url('employee/delete_material/'.$records[$i]['material_id'].'/'.$records[$i]['material_file']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                        </td>
                      </tr>
                  <?php } } ?>
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