<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Document Heads</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit</h3>
              <?php if(in_array('documentheadsview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/documentheads");?>" class="btn btn-primary btn-sm" style="float:right;">List All</a>
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
              	<form method="post" action="<?=site_url("masters/edit_documenthead/".$rec[0]['dochead_id']);?>" enctype="multipart/form-data">
              		<div class="col-md-4">
	                  <div class="row">
	                    
	                    <div class="col-md-12 form-group">
	                      <label for="dochead">Document Head</label>
	                      <input type="text" name="dochead" id="dochead" class="form-control" placeholder="Enter Document Name" value="<?=$rec[0]['dochead'];?>" required>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="docfile">Document File</label>
	                      <input type="file" name="docfile" id="docfile" class="form-control" >
	                      ( <small style="color:red;">Select file if changes required.</small> )
	                      <br>
	                      <?php if ($rec[0]['docfile'] && file_exists(FCPATH.'uploads/docfiles/'.$rec[0]['docfile'])) { ?>
	                      		<a href="<?php echo base_url("uploads/docfiles/".$rec[0]['docfile']);?>" download class="float-right"><i class="fa fa-download"></i></a>
	                    	<?php } ?>
	                    </div>
	                    
	                    <div class="col-md-12 form-group">
	                      <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Update</button>
	                    </div>
	                  </div>
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