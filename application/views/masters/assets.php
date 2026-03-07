<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Assets
              
              </h3>
              <?php if(in_array('assetsadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/add_assets");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a>
              <?php }?>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
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
                </div>
                <form role="form" action="<?php echo site_url("masters/assets");?>" method="get" id="searchForm">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="item_name">Item Name</label>
                      <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo set_value("item_name");?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="purchase_from">Purchase From</label>
                      <input type="text" class="form-control" id="purchase_from" name="purchase_from" value="<?php echo set_value("purchase_from");?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="bill_no">Bill No</label>
                      <input type="text" class="form-control" id="bill_no" name="bill_no" value="<?php echo set_value("bill_no");?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="purchase_date_from">Purchase Date From</label>
                      <input type="date" class="form-control" id="purchase_date_from" name="purchase_date_from" value="<?php echo set_value("purchase_date_from");?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="purchase_date_to">Purchase Date To</label>
                      <input type="date" class="form-control" id="purchase_date_to" name="purchase_date_to" value="<?php echo set_value("purchase_date_to");?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin">Search</button>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <?php if($records){?>
                  <table id="" class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th width="5%">ID</th>
                      <th>Item Name</th>
                      <th>Quantity</th>
                      <th>Purchase From</th>
                      <th>Purchase Date</th>
                      <th>Bill No</th>
                      <th>Uses</th>
                      <th width="10%">Action</th>
                    </tr>
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?php echo $records[$i]['asset_id'];?></td>
                      <td><?php echo $records[$i]['item_name'];?></td>
                      <td><?=$records[$i]['quantity'];?></td>
                      <td><?=$records[$i]['purchase_from'];?></td>
                      <td><?=$records[$i]['purchase_date'];?></td>
                      <td><?=$records[$i]['bill_no'];?></td>
                      <td><?=stripslashes($records[$i]['uses']);?></td>
                      <td>
                        <?php if(in_array('assetsedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                        <a href="<?php echo site_url("masters/edit_assets/".$records[$i]['asset_id']);?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                        <?php }
                        if(in_array('assetsdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                        <a href="<?php echo site_url("masters/delete_assets/".$records[$i]['asset_id']);?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                        <?php }?>
                      </td>
                    </tr>
                    <?php }} ?>
                  </table>
                  <?php echo $sPages; }else{echo 'No records found';}?>
                </div>
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

<script type="text/javascript">
  $(document).ready(function(){
    
  });
</script>
</body>
</html>