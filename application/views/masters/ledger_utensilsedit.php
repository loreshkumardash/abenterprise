<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Legder Master
        <small>Utensils</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Utensils </h3>
              <a href="<?php echo site_url("masters/view_ledger/".$ledger_id);?>" class="btn btn-xs btn-primary float-right" style="margin-left:2px;width: 6rem;">Back</a>
              
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/ledger_utensilsedit?ledger_id=".$ledger_id."&did=".$rec[0]['utensil_id']);?>" method="post">
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
              <div class="col-md-6" style="margin-top:15px;border : 1px solid #ddd;padding: 15px;">
                <div class="icon icon-lg icon-shape" style="margin-top: -28px!important;">
                    <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Utensils Details</span>
                </div>
               <div class="row form-group"> 
                      <div class="col-md-4">
                          <label for="ledger_name">Ledger Name : </label>
                      </div>
                      <div class="col-md-8">
                          <p><b><?=$ledger[0]['ledger_name'];?></b></p>
                      </div>
                </div>
                <div class="row form-group">
                      <div class="col-md-4">
                          <label for="excisereg_no">Account Group : </label>
                      </div>
                      <div class="col-md-8">
                          <p><b style="color:blue;"><?=$ledger[0]['group_name'];?></b></p>
                      </div>
                </div> 
                 <div class="row form-group">
                      <div class="col-md-4">
                          <label for="utensiladded_on">Date : </label>
                      </div>
                      <div class="col-md-8">
                          <input type="date" class="form-control form-control-sm" name="utensiladded_on" id="utensiladded_on" value="<?php echo $rec[0]['utensiladded_on']?>" required> 
                             
                      </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-4">
                          <label for="remarks">Remarks : </label>
                      </div>
                      <div class="col-md-8">
                          <input type="text" class="form-control form-control-sm" name="remarks" id="remarks" value="<?php echo $rec[0]['remarks']?>" placeholder="Remarks"> 
                             
                      </div>
                </div>
 
              </div>
               <div class="col-md-6">
                  <table class="table table-bordered table-condensed table-striped">
                    <thead>
                    <tr>
                      <th width="10%">Sl</th>
                      <th width="30%">Items</th>
                      <th width="15%">Quantity</th>
                      <th width="15%">Rate</th>
                      <th width="20%">Amount</th>
                      <th width="10%">Action</th>
                    </tr>
                  </thead>
                  <tbody class="otheritemslist">
                    <?php if ($items) { for ($i=0; $i < count($items); $i++) { ?>
                      <tr>
                        <td width="10%"><?=$i+1;?></td>
                        <td width="30%">
                          <select class="form-control input-sm item_id" name="item_id[]" >
                            <option value="">Select</option>
                           <?php if ($assets) {for ($a=0; $a <count($assets) ; $a++) { ?>
                            <option value="<?=$assets[$a]['asset_id'];?>" <?=$assets[$a]['asset_id']==$items[$i]['item_id']?'selected':'';?>><?=$assets[$a]['item_name'];?></option>
                          <?php }} ?>
                          </select>

                          
                        </td>
                        <td width="15%">
                          <input type="number" class="form-control input-sm item_quantity" name="item_quantity[]" value="<?=$items[$i]['item_quantity'];?>"></td>
                        <td width="15%">
                          <input type="number" class="form-control input-sm item_rate" name="item_rate[]" value="<?=$items[$i]['item_rate'];?>" step="0.01">
                        </td>
                        <td width="20%">
                          <input type="number" class="form-control input-sm item_amount" name="item_amount[]" value="<?=$items[$i]['item_amount'];?>" step="0.01">
                        </td>
                        <td width="10%">
                            <a href="javascript:;" class="btnRemoveItm btn btn-xs btn-danger">
                              <i class="fa fa-trash"></i>
                            </a>
                        </td>
                      </tr>
                      <?php }} ?>
                  </tbody>
                  </table>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Total Amount</label>
                      <input type="number" name="totalamount" class="form-control totalamount" value="<?=$rec[0]['totalamount'];?>" step="0.01" readonly>
                    </div>
                  </div>
                  <div class="col-md-8">
                      <a href="javascript:;" class="label label-warning btnAddMoreItm pull-right p-4 " style="margin-top: 30px;">Add More</a>
                    </div>
                  </div>
                  
               
                
              <input type="hidden" class="form-control form-control-sm" name="ledger_id" id="ledger_id" value="<?=$ledger_id;?>">
              
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
<script type="text/javascript">
  $(".btnAddMoreItm").click(function(e){
    var slot = parseInt($(".otheritemslist tr").length) + 1;
    if (slot > 15) {
        alert("You can't add more than 15 items!");
        return false;
    }
    
    $(".otheritemslist").append('<tr><td width="10%">'+slot+'</td><td width="30%"><select class="form-control input-sm item_id" name="item_id[]"><option value="">Select</option></select></td><td width="15%"><input type="number" class="form-control input-sm item_quantity" name="item_quantity[]" value="0"></td><td width="15%"><input type="number" class="form-control input-sm item_rate" name="item_rate[]" value="0.00" step="0.01"></td><td width="20%"><input type="number" class="form-control input-sm item_amount" name="item_amount[]" value="0.00" step="0.01"></td><td width="10%"><a href="javascript:;" class="btnRemoveItm btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td></tr>');
  });

  $(document).on("click", ".btnRemoveItm", function(e){
    
      $(this).closest('tr').remove();
      calculate();
    
  });

$(document).on('click','.item_id',function(){
    var obj = $(this).closest("tr");

    if ($(this).val()=='') {
        $.ajax({
              url: '<?=site_url("masters/get_utensils");?>',
              data: {utensil_id : $(this).val()},
              dataType:"HTML",
              type:"POST",
              success:function(data){
                if (data) {
                  obj.find(".item_id").html(data);
                  
                }else{
                  
                }
              }
            });
    }else{

    }
});

$(document).on('change','.item_id',function(){
    var obj = $(this).closest("tr");
    var asset_id = $(this).val();

    if (asset_id!='') {
        $.ajax({
              url: '<?=site_url("masters/get_utensilsRate");?>',
              data: {asset_id : asset_id},
              dataType:"HTML",
              type:"POST",
              success:function(data){
                if (data) {
                  obj.find(".item_rate").val(data);
                  
                }else{
                  
                }
              }
            });
    }

  });

$(document).on('keyup','.item_quantity',function(){
    var obj = $(this).closest("tr");
    var quantity = parseFloat($(this).val());
    var rate = parseFloat(obj.find(".item_rate").val());
      let amount = rate * quantity;

      obj.find(".item_amount").val(amount.toFixed(2));

      calculate();
  });

function calculate(){
  var inputs1 = $(".item_amount");
        var itmtotal = 0;
        for(var i = 0; i < inputs1.length; i++){
            if($(inputs1[i]).val() != ''){
                itmtotal = itmtotal + parseFloat($(inputs1[i]).val());
            }
        }
    itmtotal = itmtotal;

    $('.totalamount').val(itmtotal.toFixed(2));
}
</script>
</body>
</html>