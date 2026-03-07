<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Relieving Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-5">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Relieving Letter</h3>
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

              <label for="relieving_name">Name</label>
              <input type="text" class="form-control" id="relieving_name" name="relieving_name" placeholder="" value="<?=$relieving[0]['relieving_name']; ?>">
              
                <label for="relieving_so">S/O</label>
              <input type="text" class="form-control" id="relieving_so" name="relieving_so" placeholder="" value="<?=$relieving[0]['relieving_so']; ?>">

               <label for="relieving_designation">Designation</label>
              <input type="text" class="form-control" id="relieving_designation" name="relieving_designation" placeholder="" value="<?=$relieving[0]['relieving_designation']; ?>">

              <label for="from_dt">Form Date</label>
              <input type="date" class="form-control" id="from_dt" name="from_dt" placeholder="" value="<?=$relieving[0]['from_dt']; ?>">

              <label for="to_dt">To Date</label>
              <input type="date" class="form-control" id="to_dt" name="to_dt" placeholder="" value="<?=$relieving[0]['to_dt']; ?>">
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

