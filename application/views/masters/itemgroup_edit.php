<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Item Group</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Item Group</h3>
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
              	<form method="post" action="<?=site_url("masters/itemgroup_edit/".$rec[0]['itemgroup_id']);?>">
              		<div class="col-md-4">
	                  <div class="row">
	                    
	                    <div class="col-md-12 form-group">
	                      <label for="name">Main Group</label>
	                      <select name="maingroup" id="maingroup" class="form-control" required>
	                      	<option value="">--Select--</option>
	                      	<option value="Asset" <?=$rec[0]['maingroup']=='Asset'?'selected':'';?>>Asset</option>
									        <option value="Consumable Materials" <?=$rec[0]['maingroup']=='Consumable Materials'?'selected':'';?>>Consumable Materials</option>
									        <option value="INTERMEDIATE PRODUCT" <?=$rec[0]['maingroup']=='INTERMEDIATE PRODUCT'?'selected':'';?>>INTERMEDIATE PRODUCT</option>
									        <option value="PRODUCTS" <?=$rec[0]['maingroup']=='PRODUCTS'?'selected':'';?>>PRODUCTS</option>
									        <option value="Raw Materials" <?=$rec[0]['maingroup']=='Raw Materials'?'selected':'';?>>Raw Materials</option>
									        <option value="SERVICES" <?=$rec[0]['maingroup']=='SERVICES'?'selected':'';?>>SERVICES</option>
	                      </select>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="alias">Item Group Name</label>
	                      <input type="text" name="itemgroup_name" id="itemgroup_name" class="form-control" placeholder="Enter Item Group Name" value="<?=$rec[0]['itemgroup_name'];?>">
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