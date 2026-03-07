
<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Payment
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Fee Payment</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("payments/fee_payment");?>" method="post">
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

              if($this->session->flashdata('saveandprint')){
                ?>
              <script type="text/javascript">
                window.open('<?php echo site_url("payments/print_receipt/".$this->session->flashdata('saveandprint'))?>','winname');
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
              
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="session_id">Session</label>
                    <select class="form-control input-sm " id="session_id" name="session_id">
                      <?php if($sessions){ for($i=0;$i<count($sessions);$i++){//if($sessions[$i]['active_session'] == 'Active'){?>
                      <option value="<?php echo $sessions[$i]['session_id'];?>" <?php echo $sessions[$i]['active_session'] == 'Active' ? 'selected="selected"' : '';?>><?php echo $sessions[$i]['session_name'];?></option>
                      <?php }}//}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="class_id">Class</label>
                    <select class="form-control input-sm " id="class_id" name="class_id">
                      <option value=""></option>
                      <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                      <option value="<?php echo $classes[$i]['class_id'];?>"><?php echo $classes[$i]['class_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="student_id">Student</label>
                    <select class="form-control input-sm " id="student_id" name="student_id" required="required">
                      <option value="">select</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12" id="feedetails">
                  
                </div>
              </div>
              <div class="tutionfeesection" style="display: none;">
                <label>Tution Fees to be collected</label>
                <div class="row">
                  <div class="col-md-12 paymenthtml">
                    <table class="table table-condensed table-bordered">
                      <tr><th>#</th><th>Month/Year</th><th>Act. Fee</th><th>Disc(%)</th><th>Fee</th><th>Fine</th><th>Total</th></tr>
                      <tbody id="tutionfeelist"></tbody>
                      <tfoot>
                        <tr>
                          <td>&nbsp;</td>
                          <th colspan="3">Grand Total</th>
                          <th class="tutionfeetotal"></th>
                          <th class="tutionfinetotal"></th>
                          <th class="tutiongrandtotal"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class="transportfeesection" style="display: none;">
                <label>Transport Fees to be collected</label>
                <div class="row">
                  <div class="col-md-12 transportitem">
                    <table class="table table-condensed table-bordered">
                      <tr><th>#</th><th>Month/Year</th><th>Act. Fee</th><th>Disc(%)</th><th>Fee</th><th>Fine</th><th>Total</th></tr>
                      <tbody id="transportfeelist"></tbody>
                      <tfoot>
                        <tr>
                          <td>&nbsp;</td>
                          <th colspan="3">Grand Total</th>
                          <th class="transportfeetotal"></th>
                          <th class="transportfinetotal"></th>
                          <th class="transportgrandtotal"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class="hostelfeesection" style="display: none;">
                <label>Hostel Fees to be collected</label>
                <div class="row">
                  <div class="col-md-12 hostelitem">
                    <table class="table table-condensed table-bordered">
                      <tr><th>#</th><th>Month/Year</th><th>Act. Fee</th><th>Disc(%)</th><th>Fee</th><th>Fine</th><th>Total</th></tr>
                      <tbody id="hostelfeelist"></tbody>
                      <tfoot>
                        <tr>
                          <td>&nbsp;</td>
                          <th>Grand Total</th>
                          <th class="hostelfeetotal"></th>
                          <th class="hostelfinetotal"></th>
                          <th class="hostelgrandtotal"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class="dayboardingfeesection" style="display: none;">
                <label>Dayboarding Fees to be collected</label>
                <div class="row">
                  <div class="col-md-12 dayboardingitem">
                    <table class="table table-condensed table-bordered">
                      <tr><th>#</th><th>Month/Year</th><th>Act. Fee</th><th>Disc(%)</th><th>Fee</th><th>Fine</th><th>Total</th></tr>
                      <tbody id="dayboardingfeelist"></tbody>
                      <tfoot>
                        <tr>
                          <td>&nbsp;</td>
                          <th colspan="3">Grand Total</th>
                          <th class="dayboardingfeetotal"></th>
                          <th class="dayboardingfinetotal"></th>
                          <th class="dayboardinggrandtotal"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class="othersfeesection" style="display: none;">
                <label>Others Fees to be collected</label>
                <div class="row">
                  <div class="col-md-12 othersfeeitem">
                    <table class="table table-condensed table-bordered">
                      <tr><th>#</th><th>Month/Year</th><th>Act. Fee</th><th>Disc(%)</th><th>Fee</th><th>Fine</th><th>Total</th></tr>
                      <tbody id="othersfeelist"></tbody>
                      <tfoot>
                        <tr>
                          <td>&nbsp;</td>
                          <th colspan="3">Grand Total</th>
                          <th class="othersfeetotal"></th>
                          <th class="othersfinetotal"></th>
                          <th class="othersgrandtotal"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class="variablefeesection" style="display: none;">
                <label>Course Fees to be collected</label>
                <div class="row">
                  <div class="col-md-12 dayboardingitem">
                    <table class="table table-condensed table-bordered">
                      <tr><th>#</th><th>Plan Date</th><th>Act. Fee</th><th>Disc(%)</th><th>Fee</th><th>Fine</th><th>Total</th></tr>
                      <tbody id="variableitem"></tbody>
                      <tfoot>
                        <tr>
                          <td>&nbsp;</td>
                          <th colspan="3">Grand Total</th>
                          <th class="variablefeetotal"></th>
                          <th class="variablefinetotal"></th>
                          <th class="variablegrandtotal"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>

              <div class="transvariablefeesection" style="display: none;">
                <label>Transport Fees to be collected</label>
                <div class="row">
                  <div class="col-md-12 dayboardingitem">
                    <table class="table table-condensed table-bordered">
                      <tr><th>#</th><th>Plan Date</th><th>Act. Fee</th><th>Disc(%)</th><th>Fee</th><th>Fine</th><th>Total</th></tr>
                      <tbody id="transvariableitem"></tbody>
                      <tfoot>
                        <tr>
                          <td>&nbsp;</td>
                          <th colspan="3">Grand Total</th>
                          <th class="transvariablefeetotal"></th>
                          <th class="transvariablefinetotal"></th>
                          <th class="transvariablegrandtotal"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>

              <div class="libraryfinesection" style="display: none;">
                <label>Library fine to be collected</label>
                <div class="row">
                  <div class="col-md-12 libraryfineitems">
                    
                  </div>
                </div>
              </div>
              <div class="breakagefinesection" style="display: none;">
                <label>Breakage/Others fine to be collected</label>
                <div class="row">
                  <div class="col-md-12 breakagefineitems">
                    
                  </div>
                </div>
              </div>
              <label>Accessories</label>
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-condensed itemslist" width="100%">
                    <tr>
                      <th width="40%">Item Name</th>
                      <th>Price</th>
                      <th width="10%">Quantity</th>
                      <th>total</th>
                      <th></th>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control input-sm item_name" name="item_name[]">
                          <option value=""></option>
                        <?php if($items){ for($i=0;$i<count($items);$i++){ ?>
                        <option value="<?=$items[$i]['item_id']?>" data-price="<?=$items[$i]['item_price']?>"><?=$items[$i]['item_name']?></option>
                        <?php  }} ?>
                        </select>
                      </td>
                      <td><input type="text" name="item_price[]" class="form-control input-sm item_price" readonly="readonly"></td>
                      <td><input type="number" name="item_quantity[]" class="form-control input-sm item_quantity" min="1"></td>
                      <td><input type="text" name="item_total_price[]" class="form-control input-sm item_total_price" readonly="readonly"></td>
                      <td>
                        <a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                  </table>
                  <a href="javascript:;" class="label label-warning btnAddMoreItem pull-right">Add More</a>
                </div>
              </div>
              <label>Payment Details</label>
              <div class="row">
                <div class="col-md-12">
                <table class="table table-condensed table-bordered">
                  <!--<tr><th>Total Tution Fee to be collected</th><th class="tutionfeetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Tution fine to be collected</th><th class="tutionfinetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Transport Fee to be collected</th><th class="transportfeetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Transport fine to be collected</th><th class="transportfinetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Hostel Fee to be collected</th><th class="hostelfeetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Hostel fine to be collected</th><th class="hostelfinetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Dayboarding Fee to be collected</th><th class="dayboardingfeetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Dayboarding fine to be collected</th><th class="dayboardingfinetotal receiptamount moneydata" align="right"></th></tr>-->
                  <tr><th>Total Course Fee to be collected</th><th class="variablefeetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Course fine to be collected</th><th class="variablefinetotal receiptamount moneydata" align="right"></th></tr>

                  <tr><th>Total Transport Fee to be collected</th><th class="transvariablefeetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Transport fine to be collected</th><th class="transvariablefinetotal receiptamount moneydata" align="right"></th></tr>

                  <!--<tr><th>Total Others Fee to be collected</th><th class="othersfeetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total Others fine to be collected</th><th class="othersfinetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total accessories amount</th><th class="accessoriestotal receiptamount moneydata" align="right"></th></tr>-->
                  <tr><th>Total library fine amount</th><th class="libraryfinetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total breakage/Outstanding fine amount</th><th class="breakagefinetotal receiptamount moneydata" align="right"></th></tr>
                  <tr><th>Total CBSE Fee to be collected (if any)</th><th align="right" width="20%"><input type="number" name="cbse_fee" id="cbse_fee" class="form-control input-sm" value="0" min="0" style="text-align: right;"></th></tr>
                  <tr><th>Tution Fee to be collected (Yearly) <span id="feetobecollected"></span></th><th align="right" width="20%"><input type="number" name="yearlytution_fee" id="yearlytution_fee" class="form-control input-sm" value="0" min="0" style="text-align: right;"></th></tr>
                  <tr class="success"><th>Total payable amount</th><th class="gtotal moneydata"></th></tr>
                </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="amount_paid">Amount Paid</label>
                    <input type="hidden" name="gtotal" class="gtotal1" value="">
                    <input type="text" class="form-control input-sm " id="amount_paid" name="amount_paid" readonly="readonly">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="payment_mode">Payment Mode</label>
                    <select class="form-control  input-sm" id="payment_mode" name="payment_mode">
                      <option value="Cash" <?php echo set_value("payment_mode") == 'Cash' ? 'selected="selected"' : '';?>>Cash</option>
                      <option value="Cheque" <?php echo set_value("payment_mode") == 'Cheque' ? 'selected="selected"' : '';?>>Cheque</option>
                      <option value="Net Banking" <?php echo set_value("payment_mode") == 'Net Banking' ? 'selected="selected"' : '';?>>Net Banking</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="bank_id">Bank</label>
                    <select class="form-control input-sm nocash" id="bank_id" name="bank_id" disabled="disabled">
                      <option value="">select</option>
                      <?php if($banks){ for($i=0;$i<count($banks);$i++){ ?>
                      <option value="<?=$banks[$i]['bank_id']?>"><?=$banks[$i]['bank_name']?></option>
                      <?php  }} ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cheque_no">Cheque/Receipt No</label>
                    <input type="text" class="form-control input-sm nocash" id="cheque_no" name="cheque_no" disabled="disabled" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control input-sm nocash" id="bank_name" name="bank_name" disabled="disabled" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="bank_branch">Bank Branch</label>
                    <input type="text" class="form-control input-sm nocash" id="bank_branch" name="bank_branch" disabled="disabled" />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="payment_remarks">Remarks</label>
                    <select class="form-control input-sm payment_remarks" id="payment_remarks" name="payment_remarks[]" multiple="multiple">
                      <option value="Tution Fee">Tution Fee</option>
                      <option value="Transport Fee">Transport Fee</option>
                      <option value="Hostel Fee">Hostel Fee</option>
                      <option value="Dayboarding Fee">Dayboarding Fee</option>
                      <option value="Accessories Fee">Accessories Fee</option>
                      <option value="Library Fine">Library Fine</option>
                      <option value="Breakage Fine">Breakage Fine</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="saveandprint"><input type="checkbox" class="" name="saveandprint" value="Yes"> Save and Print the receipt</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <?php $cur = (int)date("H");  if($cur >= $opentime && $cur <= $closetime){?>
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
              <?php }else{ ?>
              Receipt can not be generated now please contact Admin. 
              <?php }?>
            </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Profile</a></li>
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Tution Fee</a></li>
              <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Transport Fee</a></li>
              <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false">Hostel Fee</a></li>
              <li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false">Day Boarding Fee</a></li>
              <li class=""><a href="#tab_12" data-toggle="tab" aria-expanded="false">Others Fee</a></li>
              <li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false">Course Fee</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Accessories</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Receipts</a></li>
        <!--<li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false">Booking Amount</a></li>
        <li class=""><a href="#tab_9" data-toggle="tab" aria-expanded="false">Pending Booking Amount</a></li>-->
            </ul>
            <div class="tab-content">
        <div class="tab-pane active studentBookingAmount" id="tab_8">

              </div>
        <div class="tab-pane active pendingBookingAmount" id="tab_9">

              </div>
              <div class="tab-pane " id="tab_5">

              </div>
              <div class="tab-pane active studentMonthlyFeePlan" id="tab_1">

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane studentMonthlytransportPlan" id="tab_4">

              </div>
              <div class="tab-pane studentMonthlyHostelPlan" id="tab_6">

              </div>
              <div class="tab-pane studentMonthlyDayboardingPlan" id="tab_7">

              </div>
              <div class="tab-pane studentCourseFeePlan" id="tab_8">

              </div>
              <div class="tab-pane studentTransFeePlan" id="tab_13">

              </div>
              <div class="tab-pane studentOthersFeePlan" id="tab_12">

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane " id="tab_2">

              </div>

              <div class="tab-pane " id="tab_3">
                <div class="" id="dataTablediv">

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
<?php $this->load->view("common/script");?>
<script src="<?=base_url();?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
  $(".payment_remarks").select2({
    tags: true
  });
  function calculate(){
    var f1 = $("#tutionfeelist .feeinclude");
    var g1 = 0;
    for(var i = 0; i < f1.length; i++){
      if($(f1[i]).val() != ''){
        g1 = g1 + parseFloat($(f1[i]).val());
      }
    }
    $(".tutionfeetotal").text(g1.toFixed(2));

    var fn1 = $("#tutionfeelist .fineinclude");
    var gn1 = 0;
    for(var i = 0; i < fn1.length; i++){
      if($(fn1[i]).val() != ''){
        gn1 = gn1 + parseFloat($(fn1[i]).val());
      }
    }
    $(".tutionfinetotal").text(gn1.toFixed(2));
    $(".tutiongrandtotal").text(parseFloat(g1+gn1).toFixed(2));

    var f2 = $("#transportfeelist .feeinclude");
    var g2 = 0;
    for(var i = 0; i < f2.length; i++){
      if($(f2[i]).val() != ''){
        g2 = g2 + parseFloat($(f2[i]).val());
      }
    }
    $(".transportfeetotal").text(g2.toFixed(2));

    var fn2 = $("#transportfeelist .fineinclude");
    var gn2 = 0;
    for(var i = 0; i < fn2.length; i++){
      if($(fn2[i]).val() != ''){
        gn2 = gn2 + parseFloat($(fn2[i]).val());
      }
    }
    $(".transportfinetotal").text(gn2.toFixed(2));
    $(".transportgrandtotal").text(parseFloat(g2+gn2).toFixed(2));

    var f3 = $("#hostelfeelist .feeinclude");
    var g3 = 0;
    for(var i = 0; i < f3.length; i++){
      if($(f3[i]).val() != ''){
        g3 = g3 + parseFloat($(f3[i]).val());
      }
    }
    $(".hostelfeetotal").text(g3.toFixed(2));

    var fn3 = $("#hostelfeelist .fineinclude");
    var gn3 = 0;
    for(var i = 0; i < fn3.length; i++){
      if($(fn3[i]).val() != ''){
        gn3 = gn3 + parseFloat($(fn3[i]).val());
      }
    }
    $(".hostelfinetotal").text(gn3.toFixed(2));
    $(".hostelgrandtotal").text(parseFloat(g3+gn3).toFixed(2));

    var f4 = $("#dayboardingfeelist .feeinclude");
    var g4 = 0;
    for(var i = 0; i < f4.length; i++){
      if($(f4[i]).val() != ''){
        g4 = g4 + parseFloat($(f4[i]).val());
      }
    }
    $(".dayboardingfeetotal").text(g4.toFixed(2));

    var fn4 = $("#dayboardingfeelist .fineinclude");
    var gn4 = 0;
    for(var i = 0; i < fn4.length; i++){
      if($(fn4[i]).val() != ''){
        gn4 = gn4 + parseFloat($(fn4[i]).val());
      }
    }
    $(".dayboardingfinetotal").text(gn4.toFixed(2));
    $(".dayboardinggrandtotal").text(parseFloat(g4+gn4).toFixed(2));

    var f5 = $("#othersfeelist .feeinclude");
    var g5 = 0;
    for(var i = 0; i < f5.length; i++){
      if($(f5[i]).val() != ''){
        g5 = g5 + parseFloat($(f5[i]).val());
      }
    }
    $(".othersfeetotal").text(g5.toFixed(2));

    var fn5 = $("#othersfeelist .fineinclude");
    var gn5 = 0;
    for(var i = 0; i < fn5.length; i++){
      if($(fn5[i]).val() != ''){
        gn5 = gn5 + parseFloat($(fn5[i]).val());
      }
    }
    $(".othersfinetotal").text(gn5.toFixed(2));
    $(".othersgrandtotal").text(parseFloat(g5+gn5).toFixed(2));
    
    var f6 = $("#variableitem .feeinclude");
    var g6 = 0;
    for(var i = 0; i < f6.length; i++){
      if($(f6[i]).val() != ''){
        g6 = g6 + parseFloat($(f6[i]).val());
      }
    }
    $(".variablefeetotal").text(g6.toFixed(2));

    var fn6 = $("#variableitem .fineinclude");
    var gn6 = 0;
    for(var i = 0; i < fn6.length; i++){
      if($(fn6[i]).val() != ''){
        gn6 = gn6 + parseFloat($(fn6[i]).val());
      }
    }
    $(".variablefinetotal").text(gn6.toFixed(2));
    $(".variablegrandtotal").text(parseFloat(g6+gn6).toFixed(2));



    /*......transport variable start.......*/

    var ft6 = $("#transvariableitem .feeinclude");
    //alert(ft6);
    var gt6 = 0;
    for(var i = 0; i < ft6.length; i++){
      if($(ft6[i]).val() != ''){
        gt6 = gt6 + parseFloat($(ft6[i]).val());
      }
    }
    $(".transvariablefeetotal").text(gt6.toFixed(2));

    var fnt6 = $("#transvariableitem .fineinclude");
    var gnt6 = 0;
    for(var i = 0; i < fnt6.length; i++){
      if($(fnt6[i]).val() != ''){
        gnt6 = gnt6 + parseFloat($(fnt6[i]).val());
      }
    }
    $(".transvariablefinetotal").text(gnt6.toFixed(2));
    $(".transvariablegrandtotal").text(parseFloat(gt6+gnt6).toFixed(2));

    /*..............transport variable end...............*/

    var libfine = $("#libraryfine .fineinclude");
    var libf = 0;
    for(var i = 0; i < libfine.length; i++){
      if($(libfine[i]).val() != ''){
        libf = libf + parseFloat($(libfine[i]).val());
      }
    }
    $(".libraryfinetotal").text(libf.toFixed(2));

    var brkgfine = $("#breakageshtml .fineinclude");
    var brkgtot = 0;
    for(var i = 0; i < brkgfine.length; i++){
      if($(brkgfine[i]).val() != ''){
        brkgtot = brkgtot + parseFloat($(brkgfine[i]).val());
      }
    }
    $(".breakagefinetotal").text(brkgtot.toFixed(2));

    var inputs = $(".item_total_price");
    var itemtotalprice = 0;
    for(var i = 0; i < inputs.length; i++){
      if($(inputs[i]).val() != ''){
        itemtotalprice = itemtotalprice + parseFloat($(inputs[i]).val());
      }
    }
    $(".accessoriestotal").text(itemtotalprice.toFixed(2));
    var inputs1 = $(".receiptamount");
    var gtotal = 0;
    for(var i = 0; i < inputs1.length; i++){
      if($(inputs1[i]).text() != ''){
        gtotal = gtotal + parseFloat($(inputs1[i]).text());
      }
    }
    var cbse_fee = parseFloat($("#cbse_fee").val());
    gtotal = gtotal + cbse_fee;
    var yearlytution_fee = parseFloat($("#yearlytution_fee").val());
    gtotal = gtotal + yearlytution_fee;
    $(".gtotal").text(gtotal.toFixed(2));
    $(".gtotal1").val(gtotal.toFixed(2));
    $("#amount_paid").val(gtotal.toFixed(2));
  }
  $(document).on("click", ".btnRemoveItem", function(e){
    e.preventDefault();
    $(this).closest('tr').remove();
    calculate();
  });
  $(document).on("change keyup", ".finetotal", function(e){
    
    var obj = $(this);
    var v = obj.val() == '' ? 0 : obj.val();
    var fine = parseFloat(v);
    var fee = parseFloat(obj.closest('tr').find(".feefinal").val());
    var total = fine + fee;
    obj.closest('tr').find(".totaltd").text(total.toFixed(2));
    calculate();
  });
  $(document).on("change keyup", ".discountpercentage", function(e){
    
    var obj = $(this);
    var discount = parseFloat(obj.val());
    var fine = parseFloat(obj.closest('tr').find(".finetotal").val());
    var fee = parseFloat(obj.closest('tr').find(".feetotal").val());
    var disc = (discount / 100) * fee;
    var feefinal = fee - disc;
    obj.closest('tr').find(".feefinal").val(feefinal.toFixed(2))
    var total = fine + feefinal;
    obj.closest('tr').find(".totaltd").text(total.toFixed(2));
    calculate();
  });
  $(document).on("change keyup", ".advancetutionfee", function(e){
    var id = $(this).val();
    if($(this).prop("checked") == true){
      $.ajax({
        url: '<?php echo site_url("student/getAdvanceTutionfeeItem");?>',
        data : {fee_id : $(this).val()},
        dataType: "HTML",
        type : "POST",
        success: function(data){
          $(".tutionfeesection").show();
          $("#tutionfeelist").append(data);
          calculate();
        }
      });
    }
    else if($(this).prop("checked") == false){
      $("#tutionitem"+id).remove();
      calculate();
    }
    calculate();
  });

  $(document).on("change keyup", ".advancetransportfee", function(e){
    var id = $(this).val();
    if($(this).prop("checked") == true){
      $.ajax({
        url: '<?php echo site_url("student/getAdvanceTransportfeeItem");?>',
        data : {fee_id : $(this).val()},
        dataType: "HTML",
        type : "POST",
        success: function(data){
          $(".transportfeesection").show();
          $("#transportfeelist").append(data);
          calculate();
        }
      });
    }
    else if($(this).prop("checked") == false){
      $("#transportitem"+id).remove();
      calculate();
    }
    calculate();
  });


  $(document).on("change keyup", ".advancehostelfee", function(e){
    var id = $(this).val();
    if($(this).prop("checked") == true){
      $.ajax({
        url: '<?php echo site_url("student/getAdvanceHostelfeeItem");?>',
        data : {fee_id : $(this).val()},
        dataType: "HTML",
        type : "POST",
        success: function(data){
          $(".hostelfeesection").show();
          $("#hostelfeelist").append(data);
          calculate();
        }
      });
    }
    else if($(this).prop("checked") == false){
      $("#hostelitem"+id).remove();
      calculate();
    }
    calculate();
  });

  $(document).on("change keyup", ".advancedayboardingfee", function(e){
    var id = $(this).val();
    if($(this).prop("checked") == true){
      $.ajax({
        url: '<?php echo site_url("student/getAdvanceDayboardingfeeItem");?>',
        data : {fee_id : $(this).val()},
        dataType: "HTML",
        type : "POST",
        success: function(data){
          $(".dayboardingfeesection").show();
          $("#dayboardingfeelist").append(data);
          calculate();
        }
      });
    }
    else if($(this).prop("checked") == false){
      $("#dayboardingitem"+id).remove();
      calculate();
    }
    calculate();
  });

  $(document).on("change keyup", ".advanceothersfee", function(e){
    var id = $(this).val();
    if($(this).prop("checked") == true){
      $.ajax({
        url: '<?php echo site_url("student/getAdvanceOthersfeeItem");?>',
        data : {fee_id : $(this).val()},
        dataType: "HTML",
        type : "POST",
        success: function(data){
          $(".othersfeesection").show();
          $("#othersfeelist").append(data);
          calculate();
        }
      });
    }
    else if($(this).prop("checked") == false){
      $("#othersfeeitem"+id).remove();
      calculate();
    }
    calculate();
  });

  $(document).on("change keyup", ".advancevariablefee", function(e){
    var id = $(this).val();
    if($(this).prop("checked") == true){
      $.ajax({
        url: '<?php echo site_url("student/getAdvanceCoursefeeItem");?>',
        data : {fee_id : $(this).val()},
        dataType: "HTML",
        type : "POST",
        success: function(data){
          $(".variablefeesection").show();
          $("#variableitem").append(data);
          calculate();
        }
      });
    }
    else if($(this).prop("checked") == false){
      $("#variableitem"+id).remove();
      calculate();
    }
    calculate();
  });

  $(document).on("click", ".btndeleteitemrow", function(e){
    if(confirm("Are you sure to remove this?")){
      $(this).closest('tr').remove();
      calculate();
    }
  });
  $(document).on("change keyup", ".tutionfeeitem", function(e){
    if($(this).prop("checked") == true){
      $(this).closest('tr').find(".feefinal").addClass("feeinclude");
      $(this).closest('tr').find(".finetotal").addClass("fineinclude");
    }
    else if($(this).prop("checked") == false){
      $(this).closest('tr').find(".feefinal").removeClass("feeinclude");
      $(this).closest('tr').find(".finetotal").removeClass("fineinclude");
    }
    calculate();
  });

  $(document).on("change keyup", ".item_name", function(e){
    e.preventDefault();
    var row = $(this).closest('tr');
    var price = parseFloat($('option:selected', this).attr('data-price'));
    row.find(".item_price").val(price.toFixed(2));
    row.find(".item_quantity").val(1);
    row.find(".item_total_price").val(price.toFixed(2));
    calculate();
  });

  $(document).on("change keyup", ".item_quantity", function(e){
    e.preventDefault();
    var row = $(this).closest('tr');
    var price = parseFloat(row.find(".item_price").val());
    var qty = parseFloat(row.find(".item_quantity").val());
    var total = price * qty;
    row.find(".item_total_price").val(total.toFixed(2));
    calculate();
  });

  $(document).on("change keyup", "#cbse_fee", function(e){
    e.preventDefault();
    var row = $(this).val();
    calculate();
  });

  $(document).on("change keyup", "#yearlytution_fee", function(e){
    e.preventDefault();
    var row = $(this).val();
    calculate();
  });

  $(document).ready(function(){
      $("#class_id").change(function(e){
        e.preventDefault();
        if($(this).val() != ''){
          $.ajax({
            url: '<?php echo site_url("masters/getStudentListBySessionClass");?>',
            data : {class_id : $(this).val(), session_id : $("#session_id").val()},
            dataType: "HTML",
            type : "POST",
            success: function(data){
              $("#student_id").html(data);
            }
          });
          $.ajax({
            url: '<?php echo site_url("masters/getAccessoriesListByClass");?>',
            data : {class_id : $(this).val()},
            dataType: "HTML",
            type : "POST",
            success: function(data){
              $("#tab_2").html(data);
            }
          });
        }else{
          $("#student_id").html('<option value="">select</option>');
        }
      });

      $(".btnAddMoreItem").click(function(e){
        $(".itemslist").append('<tr><td><select class="form-control input-sm item_name" name="item_name[]"><option value=""></option><?php if($items){ for($i=0;$i<count($items);$i++){ ?><option value="<?=$items[$i]['item_id']?>" data-price="<?=$items[$i]['item_price']?>"><?=$items[$i]['item_name']?></option><?php  }} ?></select></td><td><input type="text" name="item_price[]" class="form-control input-sm item_price" readonly="readonly"></td><td><input type="number" name="item_quantity[]" class="form-control input-sm item_quantity" min="1"></td><td><input type="text" name="item_total_price[]" class="form-control input-sm item_total_price" readonly="readonly"></td><td><a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td></tr>');
        calculate();
      });
      
      $("#student_id").change(function(e){
        e.preventDefault();
        if($(this).val() != ''){
          $.ajax({
            url: '<?php echo site_url("student/getStudentMonthlyFeePlan");?>',
            data : {student_id : $(this).val(), class_id : $("#class_id").val(), session_id : $("#session_id").val()},
            dataType: "JSON",
            type : "POST",
            success: function(data){
              $(".studentMonthlyFeePlan").html(data.html);
              $(".studentMonthlytransportPlan").html(data.transporthtml);
              $(".studentMonthlyHostelPlan").html(data.hostelhtml);
              $(".studentMonthlyDayboardingPlan").html(data.dayboardinghtml);
              $(".studentOthersFeePlan").html(data.othershtml);
              $(".studentCourseFeePlan").html(data.variablehtml);
              $(".studentTransFeePlan").html(data.transvariablehtml);
              $("#tab_5").html(data.profilehtml);
              $("#tutionfeelist").html(data.itemhtml);
              $("#transportfeelist").html(data.transportitem);
              $("#hostelfeelist").html(data.hostelitem);
              $("#dayboardingfeelist").html(data.dayboardingitem);
              $("#othersfeelist").html(data.othersitem);
              $("#variableitem").html(data.variableitem);
              $("#transvariableitem").html(data.transvariableitem);
              $(".tutionfee").text(data.totalfee);
              $(".totalfine").text(data.fine);
              $("#feedetails").html(data.html1);
              $(".libraryfineitems").html(data.libfine);
              $(".breakagefineitems").html(data.breakageshtml);
              if(data.itemhtml != ''){
                $(".tutionfeesection").show();
              }else{
                $(".tutionfeesection").hide();
              }
              if(data.transportitem != ''){
                $(".transportfeesection").show();
              }else{
                $(".transportfeesection").hide();
              }
              if(data.hostelitem != ''){
                $(".hostelfeesection").show();
              }else{
                $(".hostelfeesection").hide();
              }
              if(data.dayboardingitem != ''){
                $(".dayboardingfeesection").show();
              }else{
                $(".dayboardingfeesection").hide();
              }
              if(data.othersitem != ''){
                $(".othersfeesection").show();
              }else{
                $(".othersfeesection").hide();
              }
              if(data.variableitem != ''){
                $(".variablefeesection").show();
              }else{
                $(".variablefeesection").hide();
              }
              if(data.transvariableitem != ''){
                $(".transvariablefeesection").show();
              }else{
                $(".transvariablefeesection").hide();
              }
              if(data.libfine != ''){
                $(".libraryfinesection").show();
              }else{
                $(".libraryfinesection").hide();
              }

              if(data.breakageshtml != ''){
                $(".breakagefinesection").show();
              }else{
                $(".breakagefinesection").hide();
              }
              calculate();
            }
          });
           $.ajax({
            url: '<?php echo site_url("student/list_receipts_ajax");?>',
            data : {student_id : $(this).val()},
            dataType: "HTML",
            type : "POST",
            success: function(data){
              $("#dataTablediv").html(data);
            }
          });
        }else{
          $(".studentMonthlyFeePlan").html('');
          $(".paymenthtml").html('');
          $(".tutionfee").text('');
          $(".totalfine").text('');
          $("#feedetails").html('');
          calculate();
        }
      });
  });
</script>
<script type="text/javascript">
  $("#payment_mode").change(function(e){
    e.preventDefault();
    if($(this).val() == 'Cash'){
      $(".nocash").attr("disabled", "disabled");
    }else{
      $(".nocash").removeAttr("disabled");

    }
  });
</script>
</body>
</html>