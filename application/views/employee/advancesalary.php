<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Salary Advance
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <!--<img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">-->
              <h3 class="profile-username text-center"><?php echo $employee[0]['employee_name'];?></h3>

              <p class="text-muted text-center">#ID : <?php echo $employee[0]['employee_id'];?></p>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">Add Advance</a></li>
              <li><a href="#receipts" data-toggle="tab">Advance Salary History</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="profile">
                <form role="form" action="<?php echo site_url("employee/advancesalary/").$employeeId;?>" method="post">
                  <div class="row">
                    <div class="box-body">
                      <div class=" col-md-6">
                        <div class="form-group">
                          <label for="total_amt_taken">Advance Amount</label>
                          <input type="text" class="form-control" onkeypress="return isDecimal(event);" maxlength="10" id="total_amt_taken" onkeyup="return calculatePermonth();" name="total_amt_taken" placeholder="Advance Amount Taken" required="">
                        </div>

                        <div class="form-group">
                          <label for="no_of_installment">Total Number Of Installment</label>
                          <input type="text" maxlength="2" onkeyup="return calculatePermonth();" onkeypress="return isNumberKey(event);" class="form-control" id="no_of_installment" name="no_of_installment" placeholder="Total Number Of Installment" required="">
                        </div>

                        <div class="form-group">
                          <label for="per_month_instl">Per Month Installment</label>
                          <input type="text" readonly="" class="form-control" id="per_month_instl" name="per_month_instl" placeholder="Per Month Installment">
                        </div>

                        <div class="form-group">
                          <label for="adv_taken_date">Advance Salary Taken Date</label>
                          <input type="date" class="form-control" id="adv_taken_date" name="adv_taken_date" placeholder="Advance Salary Taken Date" required="">
                        </div>
                      </div>
                      <div class=" col-md-6">
                        <table class="table table-bordered table-condensed table-striped">
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
                                <label for="remarks">Voucher Remarks</label>
                                <textarea class="form-control " id="remarks" name="remarks">Advance Salary</textarea>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>

              </div>

              <div class="tab-pane" id="receipts">
                <table id="" class="table table-bordered table-condensed table-striped">
                  <tr>
                    <th>ID</th>
                    <th>Amount Taken</th>
                    <th>Taken On</th>
                    <th>Per Month Installment</th>
                    <th>Number Of Installment</th>
                    <th>Session</th>
                    <th>Status</th>
                  </tr>
                  <?php if($records){ for($i=0;$i<count($records);$i++){?>
                  <tr>
                    <td><?php echo $records[$i]['advsal_id'];?></td>
                    <td><?php echo $records[$i]['total_amt_taken'];?></td>
                    <td><?php echo date("d/m/Y", strtotime($records[$i]['adv_taken_date']));?></td>
                    <td><?php echo $records[$i]['per_month_instl'];?></td>
                    <td><?php echo $records[$i]['no_of_installment'];?></td>
                    <td><?php echo $records[$i]['session'];?></td>
                    <td><?php echo ($records[$i]['adv_taken_status'] == 0)?'Pending':'Cleared';?></td>
                  </tr>
                  <?php }}else{ echo '<tr><td colspan = "7"><center>Sorry!! No data found.</center></td></tr>';} ?>
                </table>
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
    $("#payment_mode").change(function(e){
      e.preventDefault();
      if($(this).val() == 'Cheque' || $(this).val() == 'Net Banking' || $(this).val() == 'Bank Deposite' || $(this).val() == 'Bank Withdraw'){
        $(".nocash").removeAttr("disabled");
      }else{
        $(".nocash").attr("disabled", "disabled");
      }
    });
  });

  function calculatePermonth(){
    var totalTaken = $('#total_amt_taken').val();
    var noOfinst   = $('#no_of_installment').val();
    if(parseInt(totalTaken) > 0 && parseInt(noOfinst) > 0){
      var permonth   = parseInt(totalTaken)/parseInt(noOfinst);
      $('#per_month_instl').val(parseFloat(permonth).toFixed(2));
    }
  }
</script>
</body>
</html>