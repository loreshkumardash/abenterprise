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
              <h3 class="box-title">Edit Assets </h3>              
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/edit_assets/".$rec[0]['asset_id']);?>" method="post" enctype="multipart/form-data">
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
                  if($this->session->flashdata('saveandprint')){
                    ?>
                  <script type="text/javascript">
                    window.open('<?php echo site_url("payments/print_voucher/".$this->session->flashdata('saveandprint'))?>','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=650');
                  </script>
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

                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="item_name">Item Name</label>
                      <input type="text" name="item_name" id="item_name" class="form-control" value="<?=$rec[0]['item_name'];?>">
                    </div>
                   <div class="col-md-12 form-group">
                      <label for="item_type">Item Type</label>
                      <select name="item_type" id="item_type" class="form-control" >
                        <option value="Asset" <?=$rec[0]['item_type']=='Asset'?'Selected':'';?>>Asset</option>
                        <option value="Utensil" <?=$rec[0]['item_type']=='Utensil'?'Selected':'';?>>Utensil</option>
                      </select>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="item_unit">Unit</label>
                      <input type="text" name="item_unit" id="item_unit" class="form-control" value="<?=$rec[0]['item_unit'];?>">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="item_price">Item Price</label>
                      <input type="text" name="item_price" id="item_price" class="form-control" placeholder="Enter Item Price" value="<?=$rec[0]['item_price'];?>" step="0.01">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="item_price">Sale Price</label>
                      <input type="number" name="item_sale_price" id="item_sale_price" class="form-control" placeholder="Enter Sale Price" value="<?=$rec[0]['item_sale_price'];?>" step="0.01">
                    </div>
                    <div class="col-md-12 form-group">
                      <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Save</button>
                    </div>

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
<?php $this->load->view("common/script");?>
<script type="text/javascript">

</script>
</body>
</html>
