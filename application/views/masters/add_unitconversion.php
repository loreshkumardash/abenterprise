<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Unit Conversion</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Unit Conversion</h3>
              <?php if(in_array('unitconversionview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/unitconversion");?>" class="btn btn-primary btn-sm" style="float:right;">List Unit Conversion</a>
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
              	<form method="post" action="<?=site_url("masters/add_unitconversion");?>">
              		<div class="col-md-4">
	                  <div class="row">
	                    
	                    <div class="col-md-12 form-group">
	                      <label for="main">Main Unit</label>
	                      <select name="main" id="main" class="form-control" required>
	                      	<option value="">Select</option>
	                      	<?php if($unit){ for ($i=0; $i < count($unit); $i++) { ?>
	                      		<option value="<?=$unit[$i]['name'];?>"><?=$unit[$i]['name'];?></option>
	                      	<?php }} ?>
	                      </select>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="sub">Sub Unit</label>
	                      <select name="sub" id="sub" class="form-control" required>
	                      	<option value="">Select</option>
	                      	<?php if($unit){ for ($i=0; $i < count($unit); $i++) { ?>
	                      		<option value="<?=$unit[$i]['name'];?>"><?=$unit[$i]['name'];?></option>
	                      	<?php }} ?>
	                      </select>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="factor">Con. Factor</label>
	                      <input type="number" name="factor" id="factor" class="form-control" placeholder="Enter con. factor" value="" required step="0.01">
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