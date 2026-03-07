<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Settings
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/settings");?>" method="post">
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
              
                  <?php 
                  if($records){
                    $sl=1;
                    for($i=0;$i<count($records);$i++){
                      ?>
                  <div>
                      <label for="<?php echo $records[$i]['setting_name'];?>"><?php echo ucwords(str_replace("_", " ", $records[$i]['setting_name']));?></label>
                      <textarea placeholder="" name="settings[<?php echo $records[$i]['setting_name'];?>]" id="<?php echo $records[$i]['setting_name'];?>" class="form-control"><?php echo $records[$i]['setting_value'];?></textarea>
                      <?php echo form_error('banner_description'); ?>
                  </div><br />
                      <?php
                    }
                  }
                  ?>
                                    
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
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

</body>
</html>
