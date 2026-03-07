<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Voucher
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
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
        <form role="form" action="<?php echo site_url("payments/add_voucher");?>" method="post">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Voucher</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="payment_date">Payment Date</label>
                    <input type="date" class="form-control input-sm"  id="payment_date" name="payment_date" required="required" <?=$this->session->userdata("usertype") != 'Admin' ? 'readonly="readonly" value="'.date("Y-m-d").'"' : 'value=""';?>>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" class="form-control input-sm" id="amount" name="amount" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="purpose">Purpose</label>
                    <select class="form-control input-sm" id="purpose" name="purpose" required="required">
                      <option value="Expense">Expense</option>
                      <option value="Salary">Salary</option>
                      <option value="Deposite">Deposite</option>
                      <option value="Withdraw">Withdraw</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="expense_type">Expense Type</label>
                    <select class="form-control input-sm" id="expense_type" name="expense_type">
                      <option>select</option>
                      <?php if($expense_types){ for($i=0;$i<count($expense_types);$i++){?>
                      <option value="<?php echo $expense_types[$i]['id'];?>"><?php echo $expense_types[$i]['expense_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="payment_mode">Payment Mode</label>
                    <select class="form-control input-sm" id="payment_mode" name="payment_mode" required="required">
                      <option value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Net Banking">Net Banking</option>
                      <option value="Bank Deposite">Bank Deposite</option>
                      <option value="Bank Withdraw">Bank Withdraw</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bank_id">Bank</label>
                    <select class="form-control input-sm" id="bank_id" name="bank_id">
                      <option>select</option>
                      <?php if($banks){ for($i=0;$i<count($banks);$i++){?>
                      <option value="<?php echo $banks[$i]['bank_id'];?>"><?php echo $banks[$i]['bank_name'].' ('.$banks[$i]['account_no'].')';?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cheque_no">Cheque/Receipt No</label>
                    <input type="text" class="form-control nocash input-sm" id="cheque_no" name="cheque_no" disabled="disabled" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control nocash input-sm" id="bank_name" name="bank_name" disabled="disabled" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bank_branch">Bank Branch</label>
                    <input type="text" class="form-control nocash input-sm" id="bank_branch" name="bank_branch" disabled="disabled" />
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="employee_id">Employee</label>
                    <select class="form-control input-sm" id="employee_id" name="employee_id" required="required">
                      <option>select</option>
                      <?php if($employees){ for($i=0;$i<count($employees);$i++){?>
                      <option value="<?php echo $employees[$i]['employee_id'];?>"><?php echo $employees[$i]['employee_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="mobile">Mobile No</label>
                    <input type="text" class="form-control  input-sm" id="mobile" name="mobile" />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="saveandprint"><input type="checkbox" class="" name="saveandprint" value="Yes"> Save and Print the voucher</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control input-sm" id="remarks" name="remarks" required="required"></textarea>
                  </div>
                </div>
              </div>
              
              
            </div>
            <div class="box-footer">
              <?php $cur = date("h"); if($cur >= $opentime && $cur <= $closetime){?>
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
              <?php }else{ ?>
              Voucher can not be generated now please contact Admin.
              <?php }?>
            </div>
            
          </div>
        </div>
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Assets/Vehicles Data entry Form</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              
              <table class="table">
                <tr>
                  <td>
                    <div class="form-group">
                      <div class="radio">
                        <label for="assetsdata">
                          <input type="radio" name="otherdata" id="assetsdata" value="assets">
                          Assets Data
                        </label>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <div class="radio">
                        <label for="fueldata">
                          <input type="radio" name="otherdata" id="fueldata" value="fuel">
                          Fuel Log
                        </label>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <div class="radio">
                        <label for="repairdata">
                          <input type="radio" name="otherdata" id="repairdata" value="repair">
                          Repair Log
                        </label>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
              <div class="row assetsdata otherdata" style="display: none;">
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="item_name">Item Name</label>
                  <input type="text" name="item_name" id="item_name" class="form-control input-sm" value="">
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="quantity">Quantity.</label>
                  <input type="text" name="quantity" id="quantity" class="form-control input-sm" value="">
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="purchase_from">Purchase From</label>
                  <input type="text" name="purchase_from" id="purchase_from" class="form-control input-sm" value="">
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="purchase_date">Purchase To</label>
                  <input type="date" name="purchase_date" id="purchase_date" class="form-control input-sm input-sm" value="">
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="bill_no">Bill No.</label>
                  <input type="text" name="bill_no" id="bill_no" class="form-control input-sm" value="">
                </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                  <label for="uses">Asset Uses</label>
                  <textarea name="uses" id="uses" class="form-control input-sm"></textarea>
                </div>
                </div>
              </div>
              <div class="row fueldata otherdata" style="display: none;">
                <div class="col-md-12">
                  <table class="table table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th width="30%">Vehicle</th>
                        <th width="30%">Fuel Filled</th>
                        <th width="30%">Amount</th>
                        <th></th>
                      </tr>  
                    </thead> 
                    <tbody id="vehicle_list">
                      <tr>
                        <td>
                          <select class="form-control input-sm registration_no" name="registration_no[]">
                            <option value="">select</option>
                            <?php if($vehicles){ for($i=0;$i<count($vehicles);$i++){?>
                            <option value="<?=$vehicles[$i]['vehicle_id']?>"><?=$vehicles[$i]['registration_no']?></option>
                            <?php }}?>
                          </select>
                        </td>
                        <td>
                          <input type="number" class="form-control input-sm fuel_filled" name="fuel_filled[]">
                        </td>
                        <td>
                          <input type="number" class="form-control input-sm fuel_amount" name="fuel_amount[]" value="">
                        </td>
                        <td>
                          <a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger">
                            <i class="fa fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <a href="javascript:;" class="label label-warning btnAddMoreItem pull-right">Add More</a>
                </div>
                
              </div>
              <div class="row repairdata otherdata" style="display: none;">
                <div class="col-md-12">
                  <a href="javascript:;" class="label label-warning btnAddMoreItem1 pull-right">Add More</a>
                </div>
                <div class="col-md-12 repairdataitems">
                  <div class="row repairitem">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="registration_no">Vehicle No</label>
                      <select class="form-control input-sm registration_nor" name="registration_nor[]">
                        <option value="">select</option>
                        <?php if($vehicles){ for($i=0;$i<count($vehicles);$i++){?>
                        <option value="<?=$vehicles[$i]['vehicle_id']?>"><?=$vehicles[$i]['registration_no']?></option>
                        <?php }}?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="repair_date">Repair Date</label>
                      <input type="date" class="form-control input-sm" name="repair_date[]">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="repair_amount">Repair Amount</label>
                      <input type="text" class="form-control input-sm repair_amount" name="repair_amount[]">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="repair_work">Repair Work</label>
                      <textarea class="form-control input-sm" name="repair_work[]"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="garage_name">Garage Name</label>
                      <input type="text" class="form-control input-sm" name="garage_name[]">
                    </div>
                    <a href="javascript:;" class="btnRemoveItem1 btn btn-xs btn-danger pull-right">
                      <i class="fa fa-trash"></i>
                    </a>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>
<script type="text/javascript">
  $("#purpose").change(function(e){
    e.preventDefault();
    if($(this).val() == 'Expense'){
      $("#expense_type").removeAttr("disabled").attr("required", "required");
    }else{
      $("#expense_type").attr("disabled", "disabled").removeAttr("required");
    }

    if($(this).val() == 'Deposite'){
      $('#payment_mode option[value="Bank Deposite"]').prop('selected', true);
      $("#payment_mode").trigger("change");
    }

    if($(this).val() == 'Withdraw'){
      $('#payment_mode option[value="Bank Withdraw"]').prop('selected', true);
      $("#payment_mode").trigger("change");
    }
  });
  $("#payment_mode").change(function(e){
    e.preventDefault();
    if($(this).val() == 'Cheque' || $(this).val() == 'Net Banking' || $(this).val() == 'Bank Deposite' || $(this).val() == 'Bank Withdraw'){
      $(".nocash").removeAttr("disabled");
    }else{
      $(".nocash").attr("disabled", "disabled");
    }
  });
  $("#assetsdata").change(function(e){
    e.preventDefault();
    if ($(this).prop('checked')==true){ 
      $(".otherdata").hide();
      $(".assetsdata").show();
    }
  });

  $(document).on("change keyup", ".fuel_amount", function(e){
    var inputs = $(".fuel_amount");
    var fueltotal = 0;
    for(var i = 0; i < inputs.length; i++){
      if($(inputs[i]).val() != ''){
        fueltotal = fueltotal + parseInt($(inputs[i]).val());
      }
    }
    $("#amount").val(fueltotal);
  });

  $(document).on("change keyup", ".repair_amount", function(e){
    var inputs = $(".repair_amount");
    var repairtotal = 0;
    for(var i = 0; i < inputs.length; i++){
      if($(inputs[i]).val() != ''){
        repairtotal = repairtotal + parseInt($(inputs[i]).val());
      }
    }
    $("#amount").val(repairtotal);
  });

  $("#fueldata").change(function(e){
    e.preventDefault();
    if ($(this).prop('checked')==true){ 
      $(".otherdata").hide();
      $(".fueldata").show();
    }
  });

  $("#repairdata").change(function(e){
    e.preventDefault();
    if ($(this).prop('checked')==true){ 
      $(".otherdata").hide();
      $(".repairdata").show();
    }
  });

  $(".btnAddMoreItem").click(function(e){
    $("#vehicle_list").append('<tr> <td> <select class="form-control input-sm registration_no" name="registration_no[]"> <option value="">select</option> <?php if($vehicles){ for($i=0;$i<count($vehicles);$i++){?> <option value="<?=$vehicles[$i]['vehicle_id']?>"><?=$vehicles[$i]['registration_no']?></option> <?php }}?> </select> </td> <td> <input type="number" class="form-control input-sm fuel_filled" name="fuel_filled[]"> </td> <td> <input type="number" class="form-control input-sm fuel_amount" name="fuel_amount[]" value=""> </td> <td> <a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger pull-right"> <i class="fa fa-trash"></i> </a> </td> </tr>');
    calculate();
  });

  $(".btnAddMoreItem1").click(function(e){
    $(".repairdataitems").append('<div class="row repairitem"> <div class="col-md-4"> <div class="form-group"> <label for="registration_no">Vehicle No</label> <select class="form-control input-sm registration_nor" name="registration_nor[]"> <option value="">select</option> <?php if($vehicles){ for($i=0;$i<count($vehicles);$i++){?> <option value="<?=$vehicles[$i]['vehicle_id']?>"><?=$vehicles[$i]['registration_no']?></option> <?php }}?> </select> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="repair_date">Repair Date</label> <input type="date" class="form-control input-sm" name="repair_date[]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="repair_amount">Repair Amount</label> <input type="text" class="form-control input-sm repair_amount" name="repair_amount[]"> </div> </div> <div class="col-md-6"> <div class="form-group"> <label for="repair_work">Repair Work</label> <textarea class="form-control input-sm" name="repair_work[]"></textarea> </div> </div> <div class="col-md-6"> <div class="form-group"> <label for="garage_name">Garage Name</label> <input type="text" class="form-control input-sm" name="garage_name[]"> </div> <a href="javascript:;" class="btnRemoveItem1 btn btn-xs btn-danger pull-right"> <i class="fa fa-trash"></i> </a> </div> </div>');
    calculate();
  });

  $(document).on("click", ".btnRemoveItem", function(e){
    if(confirm("Are you sure to remove this?")){
      $(this).closest('tr').remove();
      //calculate();
    }
  });

  $(document).on("click", ".btnRemoveItem1", function(e){
    if(confirm("Are you sure to remove this?")){
      $(this).closest('.repairitem').remove();
      //calculate();
    }
  });
  $('#expense_type').select2();
</script>
</body>
</html>