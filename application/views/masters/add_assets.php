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
              <h3 class="box-title">Add Assets </h3>              
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/add_assets");?>" method="post" enctype="multipart/form-data">
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
                      <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Enter Item Name" value="">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="item_type">Item Type</label>
                      <select name="item_type" id="item_type" class="form-control" >
                        <option value="Asset">Asset</option>
                        <option value="Utensil">Utensil</option>
                      </select>
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="item_unit">Unit</label>
                      <input type="text" name="item_unit" id="item_unit" class="form-control" placeholder="Enter Item Unit" value="">
                    </div>
                    <div class="col-md-12 form-group">
                      <label for="item_price">Item Price</label>
                      <input type="text" name="item_price" id="item_price" class="form-control" placeholder="Enter Item Price" value="0.00" step="0.01">
                    </div>
                     <div class="col-md-12 form-group">
                      <label for="item_price">Sale Price</label>
                      <input type="number" name="item_sale_price" id="item_sale_price" class="form-control" placeholder="Enter Sale Price" value="0.00" step="0.01">
                    </div>
                    <div class="col-md-12 form-group">
                      <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                  
                </div>
                <div class=" col-md-8">
                  <table class="table table-bordered table-condensed table-striped">
                      <thead>
                        <tr>
                          <th >#Sl</th>
                          <th >Item Name</th>
                          <th >Item Type</th>
                          <th >Item Price</th>
                          <th >Sale Price</th>
                          <th  class="text-center" width="15%">Unit</th>
                          <th  colspan="2" class="text-center" >Avl.Quantity</th>
                          <th width="15%" class="text-center" width="15%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($assets) { for ($i=0; $i < count($assets); $i++) { ?>
                        <tr>
                          <td ><?=$i+1;?></td>
                          <td ><?=$assets[$i]['item_name'];?></td>
                          <td ><?=$assets[$i]['item_type'];?></td>
                          <td ><?=$assets[$i]['item_price'];?></td>
                          <td ><?=$assets[$i]['item_sale_price'];?></td>
                          <td class="text-center" width="10%"><?=$assets[$i]['item_unit'];?></td>
                          <td class="text-center available_qty" width="10%"><?=$assets[$i]['item_qty'];?></td>
                          <td class="text-center" width="5%">
                            <?php echo $assets[$i]['item_type']=='Utensil'?'
                            <a href="javascript:void(0);" title="Add Stock" class="addstockbtn"><i class="fa fa-plus"></i></a>':'';?>
                            <!--modal-->
                            <div class="modal addstockModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                              <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top:14%;padding: 40px;margin-right: 15% !important;">
                                <div class="modal-content">
                                  <div class="modal-body">
                                    <input type="number" class="form-control input-sm stock" placeholder="Add stock"><br>
                                    <input type="hidden" class="form-control input-sm asset_id" value="<?=$assets[$i]['asset_id'];?>">
                                    <button type="button"  class="btn btn-primary btn-sm stocksubmitBtn">Add</button>
                                    <button type="button"  class="btn btn-warning btn-sm" data-dismiss="modal">Cancel</button>
                                  </div>
                                  
                                  
                                </div>
                              </div>
                            </div>
                            <td class="text-center" width="15%">
                            <a href="<?=site_url("masters/edit_assets/".$assets[$i]['asset_id']);?>" class="btn btn-warning btn-xs" >Edit</a>
                            <a href="<?=site_url("masters/delete_assets/".$assets[$i]['asset_id']);?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure for delete?');">Delete</a>
                          </td>
                        </tr>
                      <?php }} ?>
                      </tbody>
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
<?php $this->load->view("common/script");?>
<script type="text/javascript">
  $(document).on('click','.addstockbtn',function(){
    var obj = $(this).closest("tr");
      obj.find(".addstockModal").modal('toggle');
      obj.find(".addstockModal").modal('show');
  });
  $(document).on('click','.stocksubmitBtn',function(){
    var obj = $(this).closest("tr");
    var asset_id = obj.find('.asset_id').val();
    var stock = obj.find('.stock').val();
    //alert(asset_id)

      if (stock != '') {
          $.ajax({
              url: '<?=site_url("masters/addStocks");?>',
              data: {asset_id : asset_id,stock:stock},
              dataType:"HTML",
              type:"POST",
              success:function(data){
                if (data) {
                  obj.find(".available_qty").html(data);
                  obj.find('.stock').val('0');
                  obj.find(".addstockModal").modal('toggle');
                  obj.find(".addstockModal").modal('hide');
                }else{
                  
                }
              }
            });
        }



      
  });
  
</script>
</body>
</html>
