<?php $this->load->view("common/meta");?>

<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Issue Accessories
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Issue Accessories </h3> 
              <a href="<?=site_url("employee/issue_accessories_client");?>" class="btn btn-xs btn-primary float-right"><i class="fa fa-list"></i> List Issue Accessories</a>             
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("employee/edit_issueaccessories/".$issue_id);?>" method="post" enctype="multipart/form-data">
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

                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-2 form-group">
                      <label for="employee_code">Employee Code</label>
                      <input type="text" name="employee_code" id="employee_code" class="form-control" placeholder="Employee Code" value="<?=$rec[0]['employee_code'];?>" required>
                    </div>
                    <div class="col-md-3 form-group">
                      <label for="employee_name">Employee Name</label>
                      <input type="text" name="employee_name" id="employee_name" class="form-control"  value="<?=$rec[0]['employee_name'];?>" readonly required>
                      <input type="hidden" name="employee_id" id="employee_id" class="form-control"  value="<?=$rec[0]['employee_id'];?>" readonly>
                    </div>
                    <div class="col-md-2 form-group">
                      <label for="issue_date">Issue Date</label>
                      <input type="date" name="issue_date" id="issue_date" class="form-control"  value="<?php echo $rec[0]['issue_date'];?>" required>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-md-7">
                        
                        <h5>Accessories</h5>
                      <table class="table table-bordered table-condensed " width="100%">
                        <tr>
                          <th width="40%">Item Name</th>
                          <th width="20%">Price</th>
                          <th width="15%">Qty</th>
                          <th width="20%">Subtotal</th>
                          <th width="5%"></th>
                        </tr>
                        <tbody class="itemslist">
                          <?php if ($recitems) { for ($a=0; $a <count($recitems) ; $a++) { ?>
                            
                         
                          <tr>
                            <td>
                              <select class="form-control input-sm item_name" name="item_name[]">
                                <option value="">Select</option>
                              <?php if($items){ for($i=0;$i<count($items);$i++){ ?> 
                              <option value="<?=$items[$i]['asset_id']?>" data-price="<?=$recitems[$a]['item_price']?>" <?=$recitems[$a]['item_id']==$items[$i]['asset_id']?'selected':'';?>><?=$items[$i]['item_name']?></option>
                              <?php  }} ?>
                              </select>
                            </td>
                            <td>
                              <input type="text" name="item_price[]" class="form-control input-sm item_price" readonly="readonly" value="<?=$recitems[$a]['item_price'];?>">
                            </td>
                            <td>
                              
                              <input type="number" name="item_quantity[]" class="form-control input-sm item_quantity" min="1" value="<?=$recitems[$a]['item_quantity'];?>">
                            </td>
                            <td>
                              <input type="text" name="item_total_price[]" class="form-control input-sm item_total_price" readonly="readonly" value="<?=$recitems[$a]['final_amount'];?>">
                              
                          </td>
                            <td>
                                <a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger pull-right">
                              <i class="fa fa-trash"></i>
                              </a>
                            </td>
                          </tr>
                           <?php }} ?>
                        </tbody>
                        
                      </table>
                      <a href="javascript:;" class="label label-warning btnAddMoreItem pull-right">Add More</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 form-group">
                      <label for="tot_amount">Total Amount</label>
                      <input type="text" name="tot_amount" id="tot_amount" class="form-control"  value="<?=$rec[0]['tot_amount'];?>" readonly step="0.01">
                    </div>
                    <div class="col-md-2 form-group">
                      <label for="issue_status">Status</label>
                      <select name="issue_status" id="issue_status" class="form-control"  >
                        <option value="Pending" <?=$rec[0]['issue_status']=='Pending'?'selected':'';?>>Pending</option>
                        <option value="Paid" <?=$rec[0]['issue_status']=='Paid'?'selected':'';?>>Paid</option>
                      </select>
                    </div>
                  </div>
                  
                </div>
               
              </div>
              
              
            </div>
                    <div class="col-md-12 form-group box-footer">
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
<?php $this->load->view("common/script");?>
<script type="text/javascript">
  $(document).on("click", ".btnRemoveItem", function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        calculate();
    });
  
  $(".btnAddMoreItem").click(function(e){
        $(".itemslist").append('<tr><td><select class="form-control item_name input-sm" name="item_name[]"><option value=""></option><?php if($items){ for($i=0;$i<count($items);$i++){ ?><option value="<?=$items[$i]['asset_id']?>" data-price="<?=$items[$i]['item_sale_price']?>"><?=$items[$i]['item_name']?></option><?php  }} ?></select></td><td><input type="text" name="item_price[]" class="form-control item_price input-sm" readonly="readonly"></td><td><input type="number" name="item_quantity[]" class="form-control item_quantity input-sm" min="1"></td><td><input type="text" name="item_total_price[]" class="form-control item_total_price input-sm" readonly="readonly"></td><td><a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger pull-right"><i class="fa fa-trash"></i></a></td></tr>');
        calculate();
      });

  $(document).on("keyup", ".item_quantity", function(e){
    e.preventDefault();
    var row = $(this).closest('tr');
    var price = parseFloat(row.find(".item_price").val());
    var qty = parseInt(row.find(".item_quantity").val());
    var total = price * qty;
    row.find(".item_total_price").val(total);
    calculate();
  });

  $(document).on("change", ".item_name", function(e){
    e.preventDefault();
    var row = $(this).closest('tr');
    var price = $('option:selected', this).attr('data-price');
    row.find(".item_price").val(price);
    row.find(".item_quantity").val(1);
    row.find(".item_total_price").val(price);
    calculate();
  });
      
    function calculate(){
    var inputs = $(".item_total_price");
    var itemtotalprice = 0;
    for(var i = 0; i < inputs.length; i++){
      if($(inputs[i]).val() != ''){
        itemtotalprice = itemtotalprice + parseInt($(inputs[i]).val());
      }
    }
    var totalValue = itemtotalprice;
    $("#tot_amount").val(totalValue.toFixed(2));
  }

  $(document).on("keyup","#employee_code",function(){
    var employee_code = $(this).val();
    $.ajax({
      url: '<?=site_url("employee/get_empData");?>',
      data: {employee_code : employee_code},
      dataType:"HTML",
      type:"POST",
      success:function(data){        
          $("#employee_id").val(data.split("@#,")[0]);
          $("#employee_name").val(data.split("@#,")[1]);
      }
    });
  })
  
</script>
</body>
</html>
