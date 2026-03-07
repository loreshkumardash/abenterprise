<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Unit</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Unit</h3>
              <?php if(in_array('unitview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/unit");?>" class="btn btn-primary btn-sm" style="float:right;">List Unit</a>
              <?php }?>
            </div>
            <div class="box-body">
              	<form method="post" action="<?=site_url("masters/edit_unit/".$rec[0]['id']);?>">
              		<div class="col-md-4">
	                  <div class="row">
	                    
	                    <div class="col-md-12 form-group">
	                      <label for="name">Unit Name</label>
	                      <input type="text" name="name" id="name" class="form-control" placeholder="Enter Unit Name" value="<?=$rec[0]['name'];?>" required>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="alias">Alias</label>
	                      <input type="text" name="alias" id="alias" class="form-control" placeholder="Enter Unit Alias" value="<?=$rec[0]['alias'];?>">
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="print">Print Name</label>
	                      <input type="text" name="print" id="print" class="form-control" placeholder="Enter Print Name" value="<?=$rec[0]['print'];?>" required>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Save</button>
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