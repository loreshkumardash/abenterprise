<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Add Transporter</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add</h3>
              <?php if(in_array('transporterview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/transporter");?>" class="btn btn-primary btn-sm" style="float:right;">List All</a>
              <?php }?>
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
	              <strong>Error !</strong> <?php echo $this->session->flashdata('error');?>
	              </div>
	              <?php
	              }
	              ?>
              	<form method="post" action="<?=site_url("masters/edit_transporter/".$rec[0]['transporter_id']);?>" enctype="multipart/form-data">
              		<div class="col-md-4">
	                  <div class="row">
	                    
	                    <div class="col-md-12 form-group">
	                      <label for="transporter_name">Transporter Name</label>
	                      <input type="text" name="transporter_name" id="transporter_name" class="form-control" placeholder="Enter Transporter Name" value="<?=$rec[0]['transporter_name'];?>" required>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="contactno">Contact No.</label>
	                      <input type="text" name="contactno" id="contactno" class="form-control" placeholder="Enter Contact No." value="<?=$rec[0]['contactno'];?>">
	                    </div>
	                    <!-- <div class="col-md-12 form-group">
	                      <label for="docdate">Document Date</label>
	                      <input type="date" name="docdate" id="docdate" class="form-control" value="<?=$rec[0]['docdate'];?>">
	                    </div> -->
	                    
	                   </div>
                	</div>
                	<div class="col-md-4">
	                  <div class="row">
	                    
	                    <div class="col-md-12 form-group">
	                      <label for="transporter_no">Transporter Id</label>
	                      <input type="text" name="transporter_no" id="transporter_no" class="form-control" placeholder="Enter Transporter Id" value="<?=$rec[0]['transporter_no'];?>" required>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="transporter_address">Address</label>
	                      <textarea name="transporter_address" id="transporter_address" class="form-control" rows="1" placeholder="Enter Address"><?=$rec[0]['transporter_address'];?></textarea>
	                    </div>
	                    <!-- <div class="col-md-12 form-group">
	                      <label for="transporter_doc">Document File</label>
	                      <input type="file" name="transporter_doc" id="transporter_doc" class="form-control" >
	                      ( <small style="color:red;">Select file if changes required.</small> )
	                      <br>
	                      <?php if ($rec[0]['transporter_doc'] && file_exists(FCPATH.'uploads/transporter_docfile/'.$rec[0]['transporter_doc'])) { ?>
	                      		<a href="<?php echo base_url("uploads/transporter_docfile/".$rec[0]['transporter_doc']);?>" download class="float-right"><i class="fa fa-download"></i></a>
	                    	<?php } ?>
	                    </div> -->
	                  </div>
                	</div>
                	<div class="col-md-12 form-group">
	                      <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
	                    </div>
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