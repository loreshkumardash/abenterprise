<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Transporter Details</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List</h3>
              <?php if(in_array('transporteradd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/add_transporter");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a>
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
              	<table class="table table-bordered table-condensed table-striped ">
              		<tr>
              			<th width="5%">Sl</th>
              			<th width="35%">Name</th>
              			<th width="15%">Transporter Id</th>
              			<th width="15%">Contact No</th>
              			<th width="20%" style="text-align: ;">Address</th>
              			<th width="10%" style="text-align: center;">Action</th>
              		</tr>
              		<?php if($_GET['page']>1){$sl=(($_GET['page']-1)*$_GET['per_page'])+1;}else{$sl=1;} if($records){for ($i=0; $i <count($records) ; $i++) { ?>
              			<tr>
	              			<td><?=$sl++;?></td>
	              			<td><?=$records[$i]['transporter_name'];?></td>
	              			<td><?=$records[$i]['transporter_no'];?></td>
	              			<td><?=$records[$i]['contactno'];?></td>
	              			<td><?=$records[$i]['transporter_address'];?></td>
	              			
	              			<td style="text-align: center;">
	              				<?php if(in_array('transporteredit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
			                    <a href="<?php echo site_url("masters/edit_transporter/".$records[$i]['transporter_id']);?>" class="btn btn-xs btn-warning">Edit</a>
			                    <?php }?>

			                    <?php if(in_array('transporterdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
			                    <a href="<?php echo site_url("masters/delete_transporter/".$records[$i]['transporter_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
			                    <?php }?>
	              			</td>
	              			
	              		</tr>
              		<?php }} ?>
              	</table>
              	<?php if($records){echo $sPages;} ?>
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