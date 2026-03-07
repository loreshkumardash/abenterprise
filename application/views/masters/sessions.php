<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Sessions</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if($accessar) {  if(in_array('sessionsadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Sessions</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/sessions");?>" method="post">
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
                <label for="session_name">Session Name</label>
                <input type="text" class="form-control" id="session_name" name="session_name" placeholder="Enter Session Name">
              </div>
              <div class="form-group">
                <label for="session_start_date">Session start Date</label>
                <input type="date" class="form-control" id="session_start_date" name="session_start_date">
              </div>
              <div class="form-group">
                <label for="session_end_date">Session End Date</label>
                <input type="date" class="form-control" id="session_end_date" name="session_end_date">
              </div>
              <div class="form-group">
                <label for="session_description">Session Remarks</label>
                <textarea type="text" class="form-control" id="session_description" name="session_description" placeholder="Enter Session Remarks"></textarea>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        <?php }}?>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Sessions</h3>
            </div>
            <div class="box-body">
              <form method="post" action="<?php echo site_url("masters/sessions");?>" id="frmSaveSession">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Active</th>
                  <th>ID</th>
                  <th>Session</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><input type="radio" name="active_session" value="<?php echo $records[$i]['session_id'];?>" onchange="this.form.submit()" <?php echo $records[$i]['active_session'] == 'Active' ? 'checked="checked"' : '';?>></td>
                  <td><?php echo $records[$i]['session_id'];?></td>
                  <td><?php echo $records[$i]['session_name'];?></td>
                  <td><?php echo date("d/m/Y", strtotime($records[$i]['session_start_date']));?></td>
                  <td><?php echo date("d/m/Y", strtotime($records[$i]['session_end_date']));?></td>
                  <td><?php echo $records[$i]['session_description'];?></td>
                  <td>
                    <?php if(in_array('sessionsdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deletesession/".$records[$i]['session_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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
