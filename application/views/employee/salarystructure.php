<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Salary Structure
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">Structure</a></li>
              <li><a href="#receipts" data-toggle="tab">Salary Slips</a></li>
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
                </table>

                <table id="" class="table table-bordered table-condensed table-striped" cellpadding="4" style="margin-bottom: 0;">
                  <tr>
                    <td width="50%" colspan="2" style="text-align:center;"><b>EARNING</b></td>
                    <td width="50%" colspan="2" style="text-align:center;"><b>DEDUCTION</b></td>
                  </tr>
                </table>
                <table id="" class="table table-bordered table-condensed table-striped" cellpadding="4" >
                  <tr>
                    <td width="50%">
                      <table>
                        <tr>
                          <th width="6%" class="text-center">#SlNo</th>
                          <th width="22%">Salary Head</th>
                          <th class="text-right" width="22%">Amount On Head</th>
                        </tr>
                        <?php $grosssalary = 0;  if($employeeSalary){for($i=0;$i<count($employeeSalary);$i++){?>
                        <tr>
                          <td class="text-center"><?=($i+1);?></td>
                          <td><?php echo $employeeSalary[$i]['wages_name'];?></td>
                          <td class="text-right"><?php echo $employeeSalary[$i]['salary_value'];?></td>
                        </tr>
                        <?php $grosssalary +=$employeeSalary[$i]['salary_value']; } ?>
                        <tr>
                          <td colspan="2" class="text-right"><b>GROSS SALARY</b></td>
                          <td class="text-right"><b><?php echo round($grosssalary,2);?></b></td>
                        </tr>

                      <?php }else{ echo '<tr><td colspan = "3"><center>Sorry!! No data found.</center></td></tr>';} ?>
                      </table>
                    </td>
                    <td width="50%">
                      <table>
                        <tr>
                          <th width="6%" class="text-center">#SlNo</th>
                          <th width="22%">Salary Head</th>
                          <th class="text-right" width="22%">Amount On Head</th>
                        </tr>
                        <tr>
                          <td width="6%" class="text-center">1</td>
                          <td width="22%"><?php echo 'EPF';?></td>
                          <td width="22%" class="text-right"><?php echo ($employee[0]['epf_status']>0)?$employee[0]['epf_percentile']:'--';?></td>
                        </tr>
                        <tr>
                          <td width="6%" class="text-center">2</td>
                          <td width="22%"><?php echo 'TDS';?></td>
                          <td width="22%" class="text-right"><?php echo ($employee[0]['tds_status']>0)?$employee[0]['tds_percentile']:'--';?></td>
                        </tr>
                        <tr>
                          <td width="6%" class="text-center">3</td>
                          <td width="22%"><?php echo 'Professional Tax';?></td>
                          <td width="22%" class="text-right"><?php echo ($employee[0]['ptax_status']>0)?$employee[0]['ptax_percentile']:'--';?></td>
                        </tr>
                        <tr>
                          <td width="6%" class="text-center">4</td>
                          <td width="22%"><?php echo 'Cable TV';?></td>
                          <td width="22%" class="text-right"><?php echo ($employee[0]['tv_status']>0)?$employee[0]['tv_percentile']:'--';?></td>
                        </tr>
                        <tr>
                          <td width="6%" class="text-center">5</td>
                          <td width="22%"><?php echo 'Internet';?></td>
                          <td width="22%" class="text-right"><?php echo ($employee[0]['internet_status']>0)?$employee[0]['internet_percentile']:'--';?></td>
                        </tr>
                        <tr>
                          <td width="6%" class="text-center">6</td>
                          <td width="22%"><?php echo 'Electricity';?></td>
                          <td width="22%" class="text-right"><?php echo ($employee[0]['electricity_status']>0)?$employee[0]['electricity_percentile']:'--';?></td>
                        </tr>
                        <tr>
                          <td width="6%" class="text-center">7</td>
                          <td width="22%"><?php echo 'Medical';?></td>
                          <td width="22%" class="text-right"><?php echo ($employee[0]['medical_status']>0)?$employee[0]['medical_percentile']:'--';?></td>
                        </tr>
                        <tr>
                          <td width="6%" class="text-center">8</td>
                          <td width="22%"><?php echo 'Other Dedn. Fee';?></td>
                          <td width="22%" class="text-right"><?php echo ($employee[0]['otherfee_status']>0)?$employee[0]['otherfee_percentile']:'--';?></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="text-right"><b>Total Deduction</b></td>
                          <td class="text-right"><b><?php $totdeduction = $employee[0]['otherfee_percentile']+$employee[0]['medical_percentile']+$employee[0]['electricity_percentile']+$employee[0]['internet_percentile']+$employee[0]['tv_percentile']+$employee[0]['tds_percentile']+$employee[0]['epf_percentile'];echo round($totdeduction,2);?></b></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="text-right"><b>NET SALARY</b></td>
                          <td class="text-right"><b><?php $netsalary = $grosssalary-$totdeduction;$grandtotal = round($netsalary,2);echo $grandtotal;?></b></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
                <table id="" class="table table-bordered table-condensed table-striped" cellpadding="6" >
                    <tr>
                      <td>Net Salary (in words) :<b> <?php echo strtoupper(translateToWords(floatval($grandtotal)));?>ONLY</b></td>
                    </tr>
                </table>


















                <!-- <table id="" class="table table-bordered table-condensed table-striped">
                  <tr>
                    <th>#SlNo</th>
                    <th>Salary Head</th>
                    <th>Amount On Head</th>
                  </tr>
                  <?php if($employeeSalary){ for($i=0;$i<count($employeeSalary);$i++){?>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo $employeeSalary[$i]['wages_name'];?></td>
                    <td><?php echo $employeeSalary[$i]['salary_value'];?></td>
                  </tr>
                  <?php }}else{ echo '<tr><td colspan = "3"><center>Sorry!! No data found.</center></td></tr>';} ?>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo 'EPF';?></td>
                    <td><?php echo ($employee[0]['epf_status']>0)?$employee[0]['epf_percentile']:'--';?></td>
                  </tr>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo 'TDS';?></td>
                    <td><?php echo ($employee[0]['tds_status']>0)?$employee[0]['tds_percentile']:'--';?></td>
                  </tr>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo 'Professional Tax';?></td>
                    <td><?php echo ($employee[0]['ptax_status']>0)?$employee[0]['ptax_percentile']:'--';?></td>
                  </tr>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo 'Cable TV';?></td>
                    <td><?php echo ($employee[0]['tv_status']>0)?$employee[0]['tv_percentile']:'--';?></td>
                  </tr>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo 'Internet';?></td>
                    <td><?php echo ($employee[0]['internet_status']>0)?$employee[0]['internet_percentile']:'--';?></td>
                  </tr>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo 'Electricity';?></td>
                    <td><?php echo ($employee[0]['electricity_status']>0)?$employee[0]['electricity_percentile']:'--';?></td>
                  </tr>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo 'Medical';?></td>
                    <td><?php echo ($employee[0]['medical_status']>0)?$employee[0]['medical_percentile']:'--';?></td>
                  </tr>
                  <tr>
                    <td><?=($i+1);?></td>
                    <td><?php echo 'Other Dedn. Fee';?></td>
                    <td><?php echo ($employee[0]['otherfee_status']>0)?$employee[0]['otherfee_percentile']:'--';?></td>
                  </tr>
                </table> -->

              </div>

              <div class="tab-pane" id="receipts">
                <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>#Sl No</th>
                  <th>Month</th>
                  <th>Year</th>
                  <th>Session</th>
                  <th>Action</th>
                </tr>
                <?php if($SalaryDtls){ for($i=0;$i<count($SalaryDtls);$i++){?>
                <tr>
                  <td><?php echo ($i+1);?></td>
                  <td><?php echo date('F',strtotime(date('Y-'.$SalaryDtls[$i]['month'].'-d')));;?></td>
                  <td><?php echo $SalaryDtls[$i]['year'];?></td>
                  <td><?php echo $SalaryDtls[$i]['session'];?></td>
                  <td><?php if($SalaryDtls[$i]['credit_status'] == 1){ ?>
                      <a class="btn btn-xs btn-warning">Paid</a> | <a href="<?php echo site_url("employee/viewsalaryreceipt/".$SalaryDtls[$i]['transaction_id'].'/'.$SalaryDtls[$i]['employee_id'].'/'.$SalaryDtls[$i]['month'].'/'.$SalaryDtls[$i]['year']);?>" class="btn btn-xs btn-default">View Receipt</a>
                   <?php }else{ echo '---';} ?></td>
                </tr>
                <?php }} ?>
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
      
  });


function disableBtn(){
  $('#submitBtn').attr('disabled',true);
}

function checkLeaveavail(){
    if($('#leave_type').val() == ''){
      alert('Please select Leave Type.');
      $('#leave_type').focus();
      return false;
    }

    if($('#apply_from').val() == ''){
      alert('Please select Leave From Date');
      $('#apply_from').focus();
      return false;
    }

    if($('#apply_to').val() == ''){
      alert('Please select Leave To Date');
      $('#apply_to').focus();
      return false;
    }


    var leave_type = $('#leave_type').val();
    var employeeId = '<?=$employeeId?>';
    var curSession = '<?=$curSession?>';
    var apply_from = $('#apply_from').val();
    var apply_to   = $('#apply_to').val();
    $.ajax({
      method:'post',
      url: appUrl+'/Ajax_requests/checkLeaveavail',
      dataType:'json',
      data:{leave_type:leave_type,employeeId:employeeId,curSession:curSession,apply_from:apply_from,apply_to:apply_to},
      success:function(res){
        if(res.status === 500){
          alert(res.msg);
          $('#apply_from').focus();
        }else{
          var result     = res.result;
          var leaveType  = result[0]['leave_type'];
          var leaveCount = result[0]['leaveleft'];
          var dayDiffer  = res.daysDiff;
          $('#no_of_days').val(dayDiffer);
          $('.leavecount').html('<b><i>You have '+leaveCount+' leave left for '+leaveType+' Category</i></b>');

          if(parseInt(dayDiffer) > parseInt(leaveCount)){
            alert('Sorry You do not have sufficient leave for the selected Category and date range.');
          }else{
            $('#submitBtn').attr('disabled',false);
          }
        }
      }
    }); 
}
</script>
</body>
</html>