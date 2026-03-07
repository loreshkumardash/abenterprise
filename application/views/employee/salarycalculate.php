<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h4>
        <i>Salary Statement Of </i> <b><?php echo $employee[0]['employee_name'];?></b>
        <small>For the month of <b><?=date("F", mktime(0, 0, 0, $salmonth, 10))?> </b> - <?=$curSession;?></small>
      </h4>
    </section>

    <!-- Main content -->
    <form method="post">
      <section class="content">
        <div class="row">
          <div class="col-md-9">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#profile" data-toggle="tab">Salary Calculation</a></li>
              </ul>
              <div class="tab-content">
                <div class="active tab-pane" id="profile">
                  <table class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th colspan="2">Employee Name</th>
                    </tr>
                    <tr>
                      <td colspan="2"><?php echo $employee[0]['employee_name'];?></td>
                    </tr>
                    <tr>
                      <th>Father's/Husband's Name</th>
                      <th>Aadhar Number</th>
                    </tr>
                    <tr>
                      <td><?php echo $employee[0]['emp_fathername'];?></td>
                      <td><?php echo $employee[0]['aadhar_number'];?></td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <th>Phone Number</th>
                    </tr>
                    <tr>
                      <td><?php echo $employee[0]['employee_email'];?></td>
                      <td><?php echo $employee[0]['emp_mobile'];?></td>
                    </tr>
                    <tr>
                      <th colspan="2">Employee Address</th>
                    </tr>
                    <tr>
                      <td colspan="2"><?php echo $employee[0]['employee_address'];?></td>
                    </tr>



                    <tr>
                      <th colspan="2">Salary Structure</th>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table class="table table-bordered table-condensed table-striped">
                          <tr>
                            <td>Wages Head</td>
                            <td>Wages Value</td>
                          </tr>
                          <?php if(!empty($empSalary)){ 
                                  $totalSal = array();
                                  foreach ($empSalary as $a => $b) {
                                    array_push($totalSal, $b['salary_value']);
                          ?>
                          <tr>
                            <td><?=$b['wages_name'];?></td>
                            <td><?=$b['salary_value'];?></td>
                          </tr>
                          <?php }
                            //echo '<tr><td>Total</td><td>'.$totalSalary = array_sum($totalSal).'</td></tr>';
                        }?>  
                        <?php if($employee[0]['epf_status'] > 0){?>
                          <tr><td>EPF</td><td><?=$employee[0]['epf_percentile']?></td></tr>
                        <?php }?>  
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="2">Holiday(s) Of the Month</th>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table class="table table-bordered table-condensed table-striped">
                          <tr>
                            <td>Date</td>
                            <td>Description</td>
                          </tr>
                          <?php if(!empty($getAllholidays)){ 
                                  foreach ($getAllholidays as $c => $d) {
                          ?>
                          <tr>
                            <td><?=date('d-M-Y',strtotime($d['from_date']));?></td>
                            <td><?=$d['name'];?></td>
                          </tr>
                          <?php }
                        }else{
                          echo '<tr><td>No Holidays in the month.</td></tr>';
                        }?>    
                        </table>
                      </td>
                    </tr>


                    <tr>
                      <th colspan="2">Leave(s) History of the month</th>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table id="" class="table table-bordered table-condensed table-striped">
                          <tr>
                            <th>ID</th>
                            <th>Leave Type</th>
                            <th>Applied From</th>
                            <th>Applied To</th>
                            <th>Number Of Leave Taken</th>
                            <th>Leave Payment Type</th>
                          </tr>
                          <?php $notpaidleave = array(); if($leave_taken){ for($i=0;$i<count($leave_taken);$i++){ if($leave_taken[$i]['is_paid'] == 0){ array_push($notpaidleave, $leave_taken[$i]['no_of_days']); }?>
                          <tr>
                            <td><?php echo $leave_taken[$i]['leave_apply_id'];?></td>
                            <td><?php echo $leave_taken[$i]['leave_type'];?></td>
                            <td><?php echo date("d/m/Y", strtotime($leave_taken[$i]['apply_from']));?></td>
                            <td><?php echo date("d/m/Y", strtotime($leave_taken[$i]['apply_to']));?></td>
                            <td><?php echo $leave_taken[$i]['no_of_days'];?></td>
                            <td><?php echo ($leave_taken[$i]['is_paid'] == 0)?'Not Paid Leave':'Paid Leave';?></td>
                          </tr>
                          <?php }}else{ echo '<tr><td colspan = "6"><center>Sorry!! No data found.</center></td></tr>';} ?>
                        </table>
                      </td>
                    </tr>


                    <tr>
                      <th colspan="2">Pending Installment Of Advance Salary</th>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table id="" class="table table-bordered table-condensed table-striped">
                          <tr>
                            <th>#Sl No.</th>
                            <th>Advance Amount Taken</th>
                            <th>Advance Taken On</th>
                            <th>Per Month Installment</th>
                            <th>Paid Installment amount</th>
                          </tr>
                          <?php if(!empty($adv_salary)){
                                  foreach ($adv_salary as $e => $f) {
                          ?>
                          <tr>
                            <td><?=($e+1)?></td>
                            <td><?php echo $f['total_amt_taken'];?><input type="hidden" name="advsalId" id="advsalId" value="<?php echo $f['advsal_id'];?>"></td>
                            <td><?php echo date("d/m/Y", strtotime($f['adv_taken_date']));?></td>
                            <td><?php echo $f['per_month_instl'];?></td>
                            <td><?php echo $f['paidInstallment'];?></td>
                          </tr>
                          <?php }}else{ echo '<tr><td colspan = "4"><center>Sorry!! No data found.</center></td></tr>';} ?>
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <th colspan="2">Total Calculation</th>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <?php 
                            $totalincwages     = array_sum($totalSal);
                            $epfAmount         = ($employee[0]['epf_status'] > 0)?$employee[0]['epf_percentile']:0;
                            $totalLeavetake    = (!empty($leave_taken))?count($leave_taken):0;
                            $totalnotpaidleave = array_sum($notpaidleave);
                            $totalWorkingDays  = $no_of_working_days-$totalLeavetake;
                            $perDayamount      = round($totalincwages/$totalWorkingDays,2);
                            $totalNotPaidlvamt = $totalnotpaidleave*$perDayamount;

                            if(!empty($adv_salary)){
                              $totaladvPending   = ($adv_salary[0]['total_amt_taken']-$adv_salary[0]['paidInstallment']);
                            }else{
                              $totaladvPending = 0;
                            }

                        ?>

                        <table id="" class="table table-bordered table-condensed table-striped">
                          <tr>
                            <th>Head</th>
                            <th>Values</th>
                          </tr>
                          <tr>
                            <td>Total Working Day Of the month<br><small><i class="text-danger">(Total working day of the month exclude holidays and Sunday - number of leave taken by the employee)</i></small></td>
                            <td><?=$totalWorkingDays?><input type="hidden" name="totalempwrkdays" id="totalempwrkdays" value="<?=$totalWorkingDays?>"></td>
                          </tr>
                          <tr>
                            <td>Per Day Salary<br><small><i class="text-danger">(Number Of Working Days By Employee (<?=$totalWorkingDays?>) / Total Wages Head (<?=$totalincwages?>))</i></small></td>
                            <td><?=$perDayamount?><input type="hidden" name="perdayamtforemp" id="perdayamtforemp" value="<?=$perDayamount?>"></td>
                          </tr>
                          <tr>
                            <td>(A) Total Amount (Wages head)</td>
                            <td><?=$totalincwages?><input type="hidden" name="totalempwages" id="totalempwages" value="<?=$totalincwages?>"></td>
                          </tr>
                          <tr>
                            <td>(B) EPF Amount</td>
                            <td><?=$epfAmount;?><input type="hidden" name="empepfamt" id="empepfamt" value="<?=$epfAmount?>"></td>
                          </tr>
                          <tr>
                            <td>(C) No. Of Not Paid Leave Taken By the Employee</td>
                            <td><?=$totalnotpaidleave;?><input type="hidden" name="empnotpaidleave" id="empnotpaidleave" value="<?=$totalnotpaidleave?>"></td>
                          </tr>
                          <?php if(!empty($adv_salary)){?>
                          <tr>
                            <td>Want to pay the advance amount this month ? </td>
                            <td><input type="radio" name="advpaystatus" class="radval" value="1">Yes | <input type="radio" name="advpaystatus" checked="" class="radval" value="2">No</td>
                          </tr>

                          <tr style="display: none;" id="advpayrow">
                            <td>(D) Enter Advance Installment Amount </td>
                            <td><input type="text" name="installamt" onkeypress="return isDecimal(event);" maxlength="8" id="installamt" value="<?=$adv_salary[0]['per_month_instl']?>">
                              <input type="hidden" name="pendingadvamt" id="pendingadvamt" value="<?=$totaladvPending;?>">
                            </td>
                          </tr>
                          <?php }?>
                          <tr id="totalcalc" style="display: none;">
                            <td id="totcalc">Total In Hand (A-(B+C+D))</td>
                            <td id="totAmt"><input type="hidden" name="totalpaid" id="totalpaid" value="0.00"><input type="hidden" name="totaldeduct" id="totaldeduct" value="0.00"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <a href="javascript:void(0);" id="verifypay" onclick="return calculateTotal();" class="btn btn-success">Calculate Final Total</a>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="2">
                        Voucher Details
                      </th>
                    </tr>
                    <tr>
                      <td>
                        <div class="form-group">
                          <label for="payment_mode">Payment Mode</label>
                          <select class="form-control " id="payment_mode" name="payment_mode" required="required">
                            <option value="Cash">Cash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Net Banking">Net Banking</option>
                            <!--<option value="Bank Deposite">Bank Deposite</option>
                            <option value="Bank Withdraw">Bank Withdraw</option>-->
                          </select>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <label for="bank_id">Bank</label>
                          <select class="form-control" id="bank_id" name="bank_id">
                            <option>select</option>
                            <?php if($banks){ for($i=0;$i<count($banks);$i++){?>
                            <option value="<?php echo $banks[$i]['bank_id'];?>"><?php echo $banks[$i]['bank_name'].' ('.$banks[$i]['account_no'].')';?></option>
                            <?php }}?>
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table class="table table-bordered table-condensed table-striped">
                          <tr>
                            <td>
                              <div class="form-group">
                                <label for="cheque_no">Cheque/Receipt No</label>
                                <input type="text" class="form-control nocash" id="cheque_no" name="cheque_no" disabled="disabled" />
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="form-control nocash" id="bank_name" name="bank_name" disabled="disabled" />
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <label for="bank_branch">Bank Branch</label>
                                <input type="text" class="form-control nocash" id="bank_branch" name="bank_branch" disabled="disabled" />
                              </div>
                            </td>
                          </tr>
                        </table>
                        <div class="form-group">
                          <label for="saveandprint"><input type="checkbox" class="" name="saveandprint" value="Yes"> Save and Print the voucher</label>
                        </div>
                        <div class="form-group">
                          <label for="remarks">Remarks</label>
                          <textarea class="form-control " id="remarks" name="remarks" required="required"></textarea>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <input type="submit" onclick="return finalFormsubmit();" name="submitBtn" id="finalsubmit" value="Verified & Pay" class="btn btn-success" style="display: none;">
                        <a href="javascript:void(0);" id="recalculate" onclick="return window.location.reload();" class="btn btn-danger" style="display: none;">Re-Calculate</a>
                        <input type="hidden" name="advStatus" id="advStatus" value="<?php echo (!empty($adv_salary))?1:0;?>">
                      </td>
                    </tr>

                  </table>

                </div>
                
              </div>
            </div>
          </div>
        </div>
        

      </section>
    </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
<script type="text/javascript">
 
$("#payment_mode").change(function(e){
  e.preventDefault();
  if($(this).val() == 'Cheque' || $(this).val() == 'Net Banking' || $(this).val() == 'Bank Deposite' || $(this).val() == 'Bank Withdraw'){
    $(".nocash").removeAttr("disabled");
  }else{
    $(".nocash").attr("disabled", "disabled");
  }
});

$("input[name='advpaystatus']").change(function(){
  if(this.value == '1'){
    $('#advpayrow').show();
  }else{
    $('#advpayrow').hide();
  }
});

  function calculateTotal(){
    //return confirm('Are You Sure to calculate final value');
    var r = confirm("Are You Sure to calculate final value!");
    if (r == true) {
      var totalempwrkdays = $('#totalempwrkdays').val();
      var perdayamtforemp = $('#perdayamtforemp').val();
      var totalempwages   = $('#totalempwages').val();
      var empepfamt       = $('#empepfamt').val();
      var empnotpaidleave = $('#empnotpaidleave').val();
      <?php if(!empty($adv_salary)){?>
        var advpaystatus    = $("input[name='advpaystatus']:checked").val();
        var pendingadvamt   = $("#pendingadvamt").val();
        var installamt      = $("#installamt").val();
        if(advpaystatus == 1){
            if(parseInt(installamt) > parseInt(pendingadvamt)){
              alert('Sorry!! Installment Amount Can not be more than pending installment amount');
              $('#installamt').focus();
              return false;
            }
            var leavededuct = parseInt(perdayamtforemp)*parseInt(empnotpaidleave);
            var finalTotal  = parseInt(totalempwages)-(parseInt(empepfamt)+parseInt(leavededuct)+parseInt(installamt));
            var finalDeduct = (parseInt(empepfamt)+parseInt(leavededuct)+parseInt(installamt));
            $('#totalcalc').show();
            $('#totcalc').html("Total In Hand (A-(B+C+D))");
            $('#installamt').attr('readonly',true);
            $('.radval').attr('disabled',true);
            $('#totAmt').append(finalTotal);
            $('#totalpaid').val(finalTotal);
            $('#totaldeduct').val(finalDeduct);
            $('#verifypay').hide();
            $('#finalsubmit').show();
            $('#recalculate').show();
        }else if(advpaystatus == 2){
            var leavededuct = parseInt(perdayamtforemp)*parseInt(empnotpaidleave);
            var finalTotal  = parseInt(totalempwages)-(parseInt(empepfamt)+parseInt(leavededuct));
            var finalDeduct = (parseInt(empepfamt)+parseInt(leavededuct));
            $('#totalcalc').show();
            $('#totcalc').html("Total In Hand (A-(B+C))");
            $('#totAmt').append(finalTotal);
            $('#totalpaid').val(finalTotal);
            $('#totaldeduct').val(finalDeduct);
            $('#verifypay').hide();
            $('#finalsubmit').show();
            $('#recalculate').show();
        }
      <?php }else{?>
            var leavededuct = parseInt(perdayamtforemp)*parseInt(empnotpaidleave);
            var finalTotal  = parseInt(totalempwages)-(parseInt(empepfamt)+parseInt(leavededuct));
            var finalDeduct = (parseInt(empepfamt)+parseInt(leavededuct));
            $('#totalcalc').show();
            $('#totcalc').html("Total In Hand (A-(B+C))");
            $('#totAmt').append(finalTotal);
            $('#totalpaid').val(finalTotal);
            $('#totaldeduct').val(finalDeduct);
            $('#verifypay').hide();
            $('#finalsubmit').show();
            $('#recalculate').show();
      <?php }?>  
    }
  }


  function finalFormsubmit(){
    $('.radval').attr('disabled',false);
  }
</script>
</body>
</html>