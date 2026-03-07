<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Exam Type</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('examtypeadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Exam Type</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/examtype");?>" method="post">
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
                
                
              <div class="form-group">
                <label for="exam_name">Examination Term</label>
                <input type="text" class="form-control" id="exam_term" name="exam_term" placeholder="Enter Examination Term">
              </div>
              <div class="form-group">
                <label for="session">Session</label>
                <select class="form-control" name="session" id="session">

                  <option value="">select</option>
                  <?php if ($sessions) {for($i=0;$i<count($sessions);$i++){?>
                    <option value="<?=$sessions[$i]['session_id']?>"><?=$sessions[$i]['session_name']?></option>
                   
                <?php }} ?>
                </select>
              </div>
              <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date">
              </div>
              <div class="form-group">
                <label for="exam_description">Examination Remarks</label>
                <textarea type="text" class="form-control" id="exam_description" name="exam_description" placeholder="Enter Examination Remarks"></textarea>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        <?php }?>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Examinations</h3>
            </div>
            <div class="box-body">
              <form method="post" action="<?php echo site_url("masters/examtype");?>" id="frmSaveSession">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Active</th>
                  <th>ID</th>
                  <th>Exam Name</th>
                  <th>Session</th>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><input type="radio" name="active_exam_term" value="<?php echo $records[$i]['exam_term_id'];?>" onchange="this.form.submit()" <?php echo $records[$i]['active_exam_term'] == 'Active' ? 'checked="checked"' : '';?>></td>
                  <td><?php echo $records[$i]['exam_term_id'];?></td>
                  <td><?php echo $records[$i]['exam_term'];?></td>
                 <td><?php 
                  $rec = $this->Common_Model->FetchData("sessions", "*", "session_id = ".$records[$i]['session']."");
                 echo $rec[0]['session_name'];?></td>
                  <td><?php echo date("d/m/Y", strtotime($records[$i]['date']));?></td>
                  <td><?php echo $records[$i]['term_description'];?></td>
                  <td>
                    <?php if(in_array('examtermdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deleteexamterm/".$records[$i]['exam_term_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php }?>
                  </td>
                </tr>
                <?php }} ?>
              </table>
              </form>
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
