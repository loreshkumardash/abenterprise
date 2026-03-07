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
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Accessories</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/edit_accessories/".$item[0]['item_id']);?>" method="post">
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
                <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo $item[0]['item_name'];?>">
              </div>
              <!--<div class="form-group">
                <label for="item_price">Item Price</label>
                <input type="text" class="form-control" id="item_price" name="item_price" value="<?php echo $item[0]['item_price'];?>">
              </div>-->
              <div class="form-group">
                <label for="item_quantity">Item Quantity</label>
                <input type="text" class="form-control" id="item_quantity" name="item_quantity" value="<?php echo $item[0]['item_quantity'];?>">
              </div>
              <div class="form-group">
                <label for="details">Item Details</label>
                <textarea type="text" class="form-control" id="item_description" name="item_description" placeholder=""><?php echo stripslashes($item[0]['item_description']);?></textarea>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
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
</body>
</html>
