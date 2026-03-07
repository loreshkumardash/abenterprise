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
              <h3 class="box-title">Add Item Sub Group</h3>
              <?php if(in_array('itemsubgroupview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/itemsubgroup");?>" class="btn btn-primary btn-sm" style="float:right;">List Item Sub Group</a>
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
              	<form method="post" action="<?=site_url("masters/itemsubgroup_add");?>">
              		<div class="col-md-4">
	                  <div class="row">
	                    
	                    <div class="col-md-12 form-group">
	                      <label for="name">Main Group</label>
	                      <select name="maingroup" id="maingroup" class="form-control" required>
	                      	<option value="">--Select--</option>
	                      	<option value="Asset">Asset</option>
					        <option value="Consumable Materials">Consumable Materials</option>
					        <option value="INTERMEDIATE PRODUCT">INTERMEDIATE PRODUCT</option>
					        <option value="PRODUCTS">PRODUCTS</option>
					        <option value="Raw Materials">Raw Materials</option>
					        <option value="SERVICES">SERVICES</option>
	                      </select>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="alias">Item Group</label>
	                      <select name="itemgroup_id" id="itemgroup_id" class="form-control" >
	                      	<option value="">--Select--</option>
	                      </select>
	                    </div>
	                    <div class="col-md-12 form-group">
	                      <label for="alias">Item Group Name</label>
	                      <input type="text" name="itemsubgroup_name" id="itemsubgroup_name" class="form-control" placeholder="Enter Item Sub Group Name" value="">
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
<script type="text/javascript">
	$(document).on("change","#maingroup",function(){
		var maingroup = $(this).val();

		if (maingroup != '') {
			$.ajax({
              	type:'POST',
              	url:'<?=site_url("masters/get_itemgroup");?>',
              	data:{maingroup:maingroup},
             	cache:false,
              success:function(data)
              		{
          				$('#itemgroup_id').html(data);
        			}
            });
		}
	});
</script>
</body>
</html>