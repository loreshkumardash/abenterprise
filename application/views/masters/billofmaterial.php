<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Bill of Materials</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">All Bill of Material (s)</h3>
              <?php if(in_array('billofmaterialadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/add_billofmaterials");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a>
              <?php } ?>
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

      			<div class="table-responsive">
				              <table class="table table-hover table-bordered table-condensed table-striped" id="sampleTable">
				                <thead>
				                  <tr>
				                    <th>#Sl</th>
									<th>DATE</th>
				                   	<th>ALIAS</th>
									<th>BOM NAME </th>
									<th>ITEM TO PRODUCE </th>
				                    <th>QUANTITY </th>
									<th>UNIT</th>
				                    <th>EXPENSES / UNIT </th>
				                    <th style="text-align: center;">ACTION</th>
				                  </tr>
				                </thead>
				                <tbody>
								 <?php 
										$sl=0;
										$select=$this->Common_Model->db_query("select * from bill order by id DESC");
										foreach ($select as $key => $row) {
											$sl++;
										?>
				              	<tr>
				                	<td><?php echo $sl; ?></td>
									<td><?php echo date('d-M-Y',strtotime($row['date'])); ?></td>
									<td><?php echo $row['alias']; ?></td>
									<td><?php echo $row['bom']; ?></td>
									<td><?php echo $row['item']; ?></td>
									<td><?php echo $row['qty']; ?></td>
				                 	<td><?php echo $row['unit']; ?></td>
				                 	<td><?php echo $row['exp_unit']; ?></td>
				                	<td style="text-align: center;">
				                	    <?php if(in_array('billofmaterialview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
				            			<a href="<?=site_url("masters/billmaterial_view");?>?alias=<?php echo $row['alias']; ?>">  <i class="fa fa-eye" style="font-size: 20px;color: #1f892c"></i></a>
				            			&nbsp; &nbsp;
				            			<?php } ?> 
				            			<?php if(in_array('billofmaterialedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>

				              			<a href="<?=site_url("masters/billmaterial_edit");?>?id=<?php echo $row['id']; ?>" title="Edit"   style=" "><i class="fa fa-pencil" style="font-size: 20px;color:seagreen"></i></a>
				            			&nbsp; &nbsp;
				            			<?php } ?> 
				            			<?php if(in_array('billofmaterialdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
				 									              
				            			<a href="<?=site_url("masters/billmaterial_delete");?>?alias=<?php echo $row['alias']; ?>" onclick="return confirm('Are u sure want to delete')" title="Delete" ><i class="fa fa-trash" style="color: red;font-size: 20px"></i></a>
				            			<?php } ?> 
				            		</td>
                                </tr>
							<?php } ?> 
                 
                			</tbody>
              			</table>
			  </div>
              	
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