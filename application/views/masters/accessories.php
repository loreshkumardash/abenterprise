<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Accessories</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('accessoriesadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Accessories</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/add_accessories");?>" method="post">
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
                
                
              
              <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" class="form-control" id="item_name" name="item_name" placeholder="">
              </div>
              <!--<div class="form-group">
                <label for="item_price">Item Price</label>
                <input type="text" class="form-control" id="item_price" name="item_price" placeholder="">
              </div>-->
              <div class="form-group">
                <label for="item_quantity">Item Quantity</label>
                <input type="text" class="form-control" id="item_quantity" name="item_quantity" placeholder="">
              </div>
              <div class="form-group">
                <label for="details">Item Details</label>
                <textarea type="text" class="form-control" id="item_description" name="item_description" placeholder=""></textarea>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        <?php }?>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Accessories</h3>
            </div>
            <div class="box-body" id="dataTablediv">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Item Name</th>
                  <!--<th>Price</th>-->
                  <th>Quantity</th>
                  <th>Details</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['item_name'];?></td>
                  <!--<td><?php echo $records[$i]['item_price'];?></td>-->
                  <td><?php echo $records[$i]['item_quantity'];?></td>
                  <td><?php echo $records[$i]['item_description'];?></td>
                  <td>
                    <?php if(in_array('accessoriesedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/edit_accessories/".$records[$i]['item_id']);?>" class="btn btn-xs btn-info">Edit</a>
                    <?php }?>
                    <?php if(in_array('accessoriesdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/delete_accessories/".$records[$i]['item_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php }?>
                  </td>
                </tr>
                <?php }} ?>
              </table>
              <?php echo $this->ajax_pagination->create_links(); ?>
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
