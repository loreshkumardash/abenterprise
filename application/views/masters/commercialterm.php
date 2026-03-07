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
              <h3 class="box-title">List Commercial Terms</h3>
            <?php if(in_array('commercialtermadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              	<a href="<?=site_url("masters/add_commercialterm");?>" class="btn btn-sm btn-primary float-right"> <i class="fa fa-plus"></i> Add New</a>
          	<?php } ?>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/commercialterm");?>" method="post">
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
	                <div class="col-md-12">
	                	<table id="" class="table table-list dataTable no-footer dtr-inline collapsed" width="100%" >
			                <tr style="background-color: #498f55;color:white;">
			                  <th width="5%">Sl</th>
			                  <th width="15%">Terms Type</th>
			                  <th width="10%">Terms For</th>
			                  <th width="60%">Terms Description</th>
			                  <th width="10%">Action</th>
			                </tr>
			                <?php if($records){ for($i=0;$i<count($records);$i++){ ?>
			                <tr style="background-color:<?php echo $records[$i]['term_for']=='Customer'?'#efdff8':'#dff8e3';?>">
			                  <td><?php echo ($i+1);?></td>
			                  <td><?php echo $records[$i]['term_type'];?></td>
			                  <td><?php echo $records[$i]['term_for'];?></td>
			                  <td><?php echo $records[$i]['term_description'];?></td>
			                  <td>
			                  	<a href="<?=site_url("masters/edit_commercialterm/".$records[$i]['commercialterm_id']);?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>

			                  	<a href="<?=site_url("masters/delete_commercialterm/".$records[$i]['commercialterm_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure for delete this?');"><i class="fa fa-trash"></i></a>
			                  </td>
			                </tr>
			                <?php }} ?>
			              </table>
	                </div>
	            </div>    
        
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
