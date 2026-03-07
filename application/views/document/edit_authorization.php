<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Authorization Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Authorization Letter</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="" method="post" enctype="multipart/form-data">
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

              
              <div class="col-md-4 form-group">
                <label for="authorization_to">To The</label>
                <input type="text" class="form-control" id="authorization_to" name="authorization_to" placeholder="" value="<?=$authorization[0]['authorization_to']; ?>">
              </div>
              
              <div class="col-md-4 form-group">
                <label for="sitename">Site Name</label>
                <input type="text" class="form-control" id="sitename" name="sitename" placeholder=""  value="<?=$authorization[0]['sitename']; ?>">
              </div>

              <div class="col-md-3 form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="" value="<?=$authorization[0]['date']; ?>">
              </div>
              <div class="col-md-4 form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="" value="<?=$authorization[0]['address']; ?>">
              </div>
              <div class="col-md-4 form-group">
                <label for="from_dt">Sub</label>
                <input type="text" class="form-control" id="sub" name="sub" placeholder="" value="<?=$authorization[0]['sub']; ?>">
              </div>
              <div class="col-md-3 form-group">
                <label for="regards">Regards</label>
                <input type="text" class="form-control" id="regards" name="regards" placeholder="" value="<?=$authorization[0]['regards']; ?>">
              </div>
              <div class="col-md-11 form-group">
                <label for="description">Description</label>
                <textarea  class="form-control input-md" id="description" name="description" rows="3"><?=$authorization[0]['description']; ?></textarea>
              </div>
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
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

