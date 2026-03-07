<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Commercial Terms</small>
      </h1> 
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Commercial Terms</h3>
            <?php if(in_array('commercialtermview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              	<a href="<?=site_url("masters/commercialterm");?>" class="btn btn-sm btn-primary float-right"> <i class="fa fa-list"></i> List All</a>
          	<?php } ?>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/add_commercialterm");?>" method="post">
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
	            <div class="row">  
	                <div class="col-md-3">
	                	<label for="term_type">Term Type</label>
	                	<select class="form-control" name="term_type" required>
	                		<option value="">-Select-</option>
	                		<option value="DELIVERY PERIOD">DELIVERY PERIOD</option>
	                		<option value="PRICE">PRICE</option>
	                		<option value="GST">GST</option>
	                		<option value="PACKING & FORWARDING">PACKING & FORWARDING</option>
	                		<option value="TRANSIT INSURANCE">TRANSIT INSURANCE</option>
                      <option value="LOADING & UNLOADING">LOADING & UNLOADING</option>
                      <option value="MISCELLANEOUS">MISCELLANEOUS</option>
	                		<option value="FREIGHT">FREIGHT</option>
	                		<option value="PAYMENT TERMS">PAYMENT TERMS</option>
	                		<option value="QUOTATION VALIDITY">QUOTATION VALIDITY</option>
	                		<option value="WARRANTY">WARRANTY</option>
	                	</select>
	                </div>
	                <div class="col-md-3">
	                	<label for="term_for">Term For</label>
	                	<select class="form-control" name="term_for" required>
	                		<option value="">-Select-</option>
	                		<option value="Supplier">Supplier</option>
	                		<option value="Customer">Customer</option>
	                	</select>
	                </div>
	            </div>
	            <div class="row" style="margin-top:10px;">
	            	<div class="col-md-12">
	            		<label for="term_description">Term Description</label>
	                	<textarea class="form-control" name="term_description" required></textarea>
	            	</div>
	            </div>    
        		
      		</div>
      		<div class="box-footer">
      			<button type="submit" class="btn  btn-success" name="submitBtn" value="Submit">Submit</button>
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
<script type="text/javascript">

</script>
</body>
</html>
