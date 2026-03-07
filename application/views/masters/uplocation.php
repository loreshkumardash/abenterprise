<?php $this->load->view("common/meta"); ?> 
<div class="wrapper">

  <?php $this->load->view("common/sidebar"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Upcoming Property Locations</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(($accessar ? in_array('sessionsadd', $accessar) : 0) || $this->session->userdata('usertype') == 'Admin') { ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo isset($edit_record) ? 'Edit' : 'Add'; ?> Upcoming Property Locations</h3>
            </div>
            <!-- /.box-header -->

            <form role="form" action="<?php echo site_url("masters/uplocation"); ?>" method="post">
              <input type="hidden" name="uc_lid" value="<?php echo isset($edit_record[0]['uc_lid']) ? $edit_record[0]['uc_lid'] : ''; ?>">

              <div class="box-body">
                <?php if($this->session->flashdata('success')) { ?>
                <div class="alert alert-dismissable alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>

                <?php if($this->session->flashdata('error')) { ?>
                <div class="alert alert-dismissable alert-danger">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php } ?>

                <div class="form-group">
                  <label for="uplocation">Upcoming Location Name</label>
                  <input type="text" class="form-control" id="uplocation" name="uplocation" placeholder="Enter Upcoming Location Name"
                    value="<?php echo isset($edit_record[0]['uc_location']) ? $edit_record[0]['uc_location'] : ''; ?>" required>
                </div>

              </div>
              <div class="box-footer">
                <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">
                  <?php echo isset($edit_record) ? 'Update' : 'Submit'; ?>
                </button>
              </div>
            </form>
          </div>
        </div>
        <?php } ?>

        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Upcoming Locations</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-condensed table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Upcoming Location Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if($records) { foreach($records as $record) { ?>
                  <tr>
                    <td><?php echo $record['uc_lid']; ?></td>
                    <td><?php echo $record['uc_location']; ?></td>
                    <td>
                      <?php if($accessar) {  
                          if(in_array('sessionsdelete', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                        <a href="<?php echo site_url("masters/edituplocation/".$record['uc_lid']); ?>" class="btn btn-xs btn-warning">Edit</a>
                        <a href="<?php echo site_url("masters/deleteuplocation/".$record['uc_lid']); ?>" class="btn btn-xs btn-danger"
                          onclick="return confirm('Are you sure to delete this?');">Delete</a>
                      <?php }} ?>
                    </td>
                  </tr>
                  <?php }} else { ?>
                  <tr>
                    <td colspan="3" class="text-center">No records found.</td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer"); ?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script"); ?>
</body>
</html>
