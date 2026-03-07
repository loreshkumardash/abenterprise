<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Item</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Item</h3>
              <?php if(in_array('itemadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/add_item");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a>
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
              <form method="post">
                  <div class="col-md-12">
                    <div class="col-md-3 form-group">
                        <input type="text" name="itemsearch" class="form-control">
                    </div>
                    <button type="submit" class="btn bg-navy btn-flat" style="">Search</button>
                  </div>
                </form>
              <table class="table table-bordered table-condensed table-striped " >
                  <tr>
                    <th width="5%">Sl</th>
                    <th width="10%">Date</th>
                    <th width="10%">Part Code</th>
                    <th width="25%">Item Name</th>
                    <th width="25%">Item Print Name</th>
                    <th width="15%">Item Group</th>
                    <th width="10%">Action</th>
                  </tr>
                  <?php if($_GET['page']>1){$sl=(($_GET['page']-1)*$_GET['per_page'])+1;}else{$sl=1;} if($records){for ($i=0; $i <count($records) ; $i++) { ?>
                    <tr>
                      <td><?=$sl++;?></td>
                      <td><?=$records[$i]['date'];?></td>
                      <td><?=$records[$i]['code'];?></td>
                      <td><?=$records[$i]['name'];?></td>
                      <td><?=$records[$i]['print'];?></td>
                      <td><?=$records[$i]['group'];?></td>
      
                      <td>
                        <?php if(in_array('itemview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                          <a href="<?php echo site_url("masters/view_item/".$records[$i]['id']);?>" class="btn btn-xs btn-info" title="View"><i class="fa fa-eye"></i></a>
                        <?php }?>
                        <?php if(in_array('itemedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                          <a href="<?php echo site_url("masters/edit_item/".$records[$i]['id']);?>" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                        <?php }?>

                        <?php if(in_array('itemdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                          <a href="<?php echo site_url("masters/delete_item/".$records[$i]['id']);?>" class="btn btn-xs btn-danger" title="Delete" onclick="return confirm('Are you sure to delete this?');"><i class="fa fa-trash"></i></a>
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