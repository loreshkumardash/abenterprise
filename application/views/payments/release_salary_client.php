<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Salary Release
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <?php
          function round_up($number, $precision = 2)
          {
              $fig = (int) str_pad('1', $precision, '0');
              return (ceil($number * $fig) / $fig);
          }
          if($this->session->flashdata('filename')){
          ?>
          <div class="alert alert-dismissable alert-info">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Download !</strong> <a href="<?php echo $this->session->flashdata('filename');?>" target="_blank">Release Salary List</a>
          </div>
          <?php
          }

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
        </div>
        
      </div>
      
      <div class="row">
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Change Month</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <form action="<?=site_url("payments/release_salary_client");?>">
                <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                      <select class="form-control form-control-sm" name="year">
                        <?php $yr = date("Y"); for ($y=0; $y < 6; $y++) { 
                          $yrr = $yr - $y;
                          $sel = $yrr == $year ? 'selected="selected"' : '';
                          echo '<option value="'.$yrr.'" '.$sel.'>'.$yrr.'</option>';
                        }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control form-control-sm" name="month">
                    <option value="01" <?=$month == '01' ? 'selected="selected"' : '';?>>Jan</option>
                    <option value="02" <?=$month == '02' ? 'selected="selected"' : '';?>>Feb</option>
                    <option value="03" <?=$month == '03' ? 'selected="selected"' : '';?>>Mar</option>
                    <option value="04" <?=$month == '04' ? 'selected="selected"' : '';?>>Apr</option>
                    <option value="05" <?=$month == '05' ? 'selected="selected"' : '';?>>May</option>
                    <option value="06" <?=$month == '06' ? 'selected="selected"' : '';?>>Jun</option>
                    <option value="07" <?=$month == '07' ? 'selected="selected"' : '';?>>Jul</option>
                    <option value="08" <?=$month == '08' ? 'selected="selected"' : '';?>>Aug</option>
                    <option value="09" <?=$month == '09' ? 'selected="selected"' : '';?>>Sept</option>
                    <option value="10" <?=$month == '10' ? 'selected="selected"' : '';?>>Oct</option>
                    <option value="11" <?=$month == '11' ? 'selected="selected"' : '';?>>Nov</option>
                    <option value="12" <?=$month == '12' ? 'selected="selected"' : '';?>>Dec</option>
                  </select>
                 </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Release Salary List</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <?php if($sfiles){ for($i=0;$i<count($sfiles);$i++){ ?>
              <button type="button" name="" class="btn btn-xs btn-default"><?php echo date('d-M-Y',strtotime($sfiles[$i]['last_modified']));?><a href="https://glosent.in/erp/uploads/<?php echo $sfiles[$i]['filename'];?>" target="_blank" class="btn btn-xs btn-success margin"><i class="fa fa-download"></i></a></button>
              <?php }} ?>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <form action="<?=site_url("payments/release_salary_client");?>" method="post">
            <input type="hidden" name="totalempwrkdays" value="<?=$no_of_working_days;?>">
            <input type="hidden" name="oremarks" value="Salary Release for the month of <?=date('F Y', strtotime($year."-".$month));?>">
            <input type="hidden" name="salmonth" value="<?=$month;?>">
            <input type="hidden" name="salyear" value="<?=$year;?>">            
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Salary Release for the month of <?=date('F', strtotime($year."-".$month));?></h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th><input type="checkbox" name="selectall" class="selectall"></th>
                      <th>Employee Details</th>
                      <th>Salary</th>
                      <th>Leaves</th>
                      <th>Advance</th>
                      <th width="22%">Final Salary Taken</th>
                    </tr>
                  </thead>
                  <tbody id="appendTr">
                    <?php if($employees){ 
                       
  							$actualworkingdays = $no_of_working_days;
                            $thismonth = $year."-".$month;

                              $start = new DateTime($monthStartDate);
                              $end = new DateTime($monthEndDate);
                              $end->modify('+1 day');
                              $interval = $end->diff($start);
                              $days = $interval->days; 
                              $period = new DatePeriod($start, new DateInterval('P1D'), $end);
                              foreach($period as $dt) {
                                $curr = $dt->format('D');
                                if ($curr == 'Sun') {
                                  $days--;
                                }

                              }
  					
  					for($i=0;$i<count($employees);$i++){ 
					if($employees[$i]['employee_id'] <= '0'){ continue;}

              //GET TRANSACTION       
               $saltr = $this->Common_Model->FetchData("salary_transaction_attribute","*","employee_id=".$employees[$i]['employee_id']." AND month='".$month."' AND year='".$year."'");
                if(!empty($saltr)){ continue;}
                    
                  //GET STRUCTURE   
                    $salarystr = getFetchData("salary_structure AS A ", "*", "A.employee_id = ".$employees[$i]['employee_id']."");

                  if(empty($salarystr)){ continue;}
                    $salarystr_items = getFetchData("salary_structure_items", "*", "salary_structure_id=".$salarystr[0]['salary_structure_id']."");

                  //GET ADVANCE PAYMENT    
                  $advance = getFetchData("adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id)", "A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment", "A.employee_id = ".$employees[$i]['employee_id']." AND A.adv_taken_status = 0 AND MONTH(A.adv_taken_date) <= '".$month."' AND YEAR(A.adv_taken_date) <= '".$year."' GROUP BY A.advsal_id");

                    
                    $installmentpaid = 0;
                    $employeesalary = 0;
                     
                  //GET ATTENDANCE
                      $empatten = $this->Common_Model->db_query("SELECT SUM(A.noatten) as empduty,SEC_TO_TIME(SUM(TIME_TO_SEC(working_hour))) AS empwhour FROM emp_attendance A WHERE A.employee_id='".$employees[$i]['employee_id']."' AND MONTH(A.attended_date)='".$monthtxt."' AND YEAR(A.attended_date)='".$year."'");  

                  if($empatten[0]['empduty'] == ''){ continue;}
                        
                        $bonuspercent = $salarystr[0]['bonuspercent'];
                        $grosssalary = $wagebasic[0]['amount'];
                        
                        if ($salarystr[0]['ctc_type'] == 2) {
                          $totalduty = $working_hour;
                        }else{
                          $totalduty = $empatten[0]['empduty']; 
                        }

                        $totalduty = $empatten[0]['empduty']; 
                        $montdays = $interval->days;
                      



                    ?>
                    <tr class="employee<?php echo $employees[$i]['employee_id'];?>">
                      <th><input type="checkbox" name="employee_id[<?=$i;?>]" value="<?php echo $employees[$i]['employee_id'];?>" class="employeeselect"></th>
                      <td>
                        
                        <table class="table table-condensed">
                          <tr>
                            <td colspan="2"><a href="<?php echo base_url();?>index.php/employee/viewemployee/<?php echo $employees[$i]['employee_id'];?>" class="btn btn-primary btn-xs" target="_blank"><b><?php echo $employees[$i]['employee_name'].'('.$employees[$i]['employee_id'].')';?></b></a></td>
                          </tr>
                          <tr>
                            <th>Designation</th>
                            <td><?php echo $employees[$i]['designation_name'];?></td>
                          </tr>
                          <tr>
                            <th>Aadhar Number</th>
                            <td><?php echo $employees[$i]['kyc_adharno'];?></td>
                          </tr>
                          <tr>
                            <th>Email</th>
                            <td><?php echo $employees[$i]['employee_email'];?></td>
                          </tr>
                          <tr>
                            <th>Phone Number</th>
                            <td><?php echo $employees[$i]['emp_mobile'];?></td>
                          </tr>
                          <tr>
                            <th>Bank Name</th>
                            <td><?php echo $employees[$i]['st_bankname'];?></td>
                          </tr>
                          <tr>
                            <th>Bank IFSC</th>
                            <td><?php echo $employees[$i]['st_ifsc'];?></td>
                          </tr>
                          <tr>
                            <th>Bank AC/No</th>
                            <td><?php echo $employees[$i]['st_acno'];?></td>
                          </tr>
                        </table>
                      </td>
                      <td>
                        
                        <table class="table table-condensed">
                          <?php if($salarystr_items){ $sl = 1;$grossWages=0;$basicamt=0;$hraamt=0;$conalamt=0;$spcalamt=0;$epfamt=0;$esiamt=0;$ptamt=0;$admnchrge=0;
                           for($j=0;$j<count($salarystr_items);$j++){ 
                            if ($salarystr_items[$j]['wages_id'] >= 1 && $salarystr_items[$j]['wages_id'] <= 4) {
                             $grossWages += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              if ($salarystr_items[$j]['wages_id'] == 1) {
                                $basicamt += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              }else if ($salarystr_items[$j]['wages_id'] == 2) {
                                $hraamt += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              }else if ($salarystr_items[$j]['wages_id'] == 3) {
                                $conalamt += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              }else if ($salarystr_items[$j]['wages_id'] == 4) {
                                $spcalamt += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              }
                            }else{
                              $deductionWages += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              if ($salarystr_items[$j]['wages_id'] == 5) {
                                $epfamt += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              }else if ($salarystr_items[$j]['wages_id'] == 6) {
                                $esiamt += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              }else if ($salarystr_items[$j]['wages_id'] == 7) {
                                $ptamt += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              }else if ($salarystr_items[$j]['wages_id'] == 8) {
                                $admnchrge += round(($salarystr_items[$j]['perday'] * $totalduty),2);
                              }
                              
                            }
                          ?>
                          
                          <tr>
                            <th><?=$salarystr_items[$j]['wages_name']?>
                              
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr_items[$j]['wages_id'];?>">
                            </th>
                            <td align="right"><?=round(($salarystr_items[$j]['perday'] * $totalduty),2);?>
                              
                              <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=round(($salarystr_items[$j]['amount'] * $totalduty),2);?>">
                            </td>
                          </tr>
                           
                          <?php }}?>
                          
                          <tr>
                            <th>Bonus</th>
                            <td align="right"><?=round($bonus,2)?>
                              <input type="hidden" name="bonus[<?=$i;?>]" value="<?=round($bonus,2)?>">
                            </td>
                          </tr>

                          <tr>
                            <th>Total Salary</th>
                            <td align="right"><?php echo $employeesalary = (round($grossWages,2));?>
                              
                            </td>
                          </tr>
                        </table>

                        <table class="table table-condensed">
                          <tr>
                            <th>Monthly Days</th>
                            <td align="right"><?=$montdays?></td>
                            <input type="hidden" name="monthdays[<?=$i;?>]" value="<?=$actualworkingdays?>">
                          </tr>
                          
                          <tr>
                            <th>Per <?=$salarystr[0]['ctc_type'] == 2?'Hour':'Day';?> Salary</th>
                            <td align="right"><?=$perDayamount = round($employeesalary / $totalduty,2);?></td>
                          </tr>
                          <tr>
                            <th>Actual Working <?=$salarystr[0]['ctc_type'] == 2?'Hours':'Days';?></th>
                          
                            <td align="right"><?php echo isset($totalduty)?$totalduty:'NA';?>
                              
                               <input type="hidden" name="totalduty[<?=$i;?>]" value="<?=$totalduty?>">
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td>
                        <table class="table table-condensed">
                          <tr>
                            <th>Total Leave</th>
                            <td><?=$leaves;?></td>
                          </tr>
                          <tr>
                            <th>Not Paid Leaves</th>
                            <td><?=$notpaidleaves;?></td>
                          </tr>
                          <?php
                          $notpaidleavesamt = 0;
                          ?>
                        </table>
                      </td>
                      <td>
                        <?php $totalpending = 0; if($advance){ $sl = 1; for($j=0;$j<count($advance);$j++){ if($advance[$j]['employee_id'] == ''){ continue;} 
                          //
                          $pending = $advance[$j]['total_amt_taken'] - $advance[$j]['paidInstallment'];
                          if($pending < $advance[$j]['per_month_instl']){
                            $installment = $pending;
                          }else{
                            $installment = (int)$advance[$j]['per_month_instl'];
                          }
                          $installmentpaid = $installmentpaid + (int)$installment;
                          $totalpending = $totalpending + ($advance[$j]['total_amt_taken'] - $advance[$j]['paidInstallment']);
                        ?>
                        
                        <table class="table table-condensed">
                          <tr>
                            <th>Advance Date</th>
                            <td><?=date("d/m/Y", strtotime($advance[$j]['adv_taken_date']));?></td>
                          </tr>
                          <tr>
                            <th>Advance Amount</th>
                            <td><?=$advance[$j]['total_amt_taken']?></td>
                          </tr>
                          <tr>
                            <th>Installment</th>
                            <td><?=$advance[$j]['per_month_instl']?></td>
                          </tr>
                          <tr>
                            <th>Paid</th>
                            <td><?=$advance[$j]['paidInstallment']?></td>
                          </tr>
                        </table>
                        <?php $sl++; }}?>
                        
                      </td>
                      <td>
                        <table class="table table-condensed">
                          <tr>
                            <th width="70%">
                              Pay Installment

                              <input type="hidden" name="epf_percentile[<?=$i;?>]" id="epf_percentile[<?=$i;?>]" class="epf_percentile" value="<?=$epfamt;?>" readonly>

                              <input type="hidden" name="esic_percentile[<?=$i;?>]" id="esic_percentile[<?=$i;?>]" class="esic_percentile" value="<?=$esiamt;?>" readonly>

                              <input type="hidden" name="pt[<?=$i;?>]" id="pt[<?=$i;?>]" class="pt" value="<?=$ptamt;?>" readonly>

                              <input type="hidden" name="admnchrge[<?=$i;?>]" id="admnchrge[<?=$i;?>]" class="admnchrge" value="<?=$admnchrge;?>" readonly>

                              <input type="hidden" name="basicamt[<?=$i;?>]" value="<?=$basicamt;?>" class="basicamt" readonly>

                              <input type="hidden" name="hraamt[<?=$i;?>]" value="<?=$hraamt;?>" class="hraamt" readonly>

                              <input type="hidden" name="conalamt[<?=$i;?>]" value="<?=$conalamt;?>" class="conalamt" readonly>
                              
                              <input type="hidden" name="spcalamt[<?=$i;?>]" value="<?=$spcalamt;?>" class="spcalamt" readonly>

                              <input type="hidden" name="employee_name[<?=$i;?>]" value="<?php echo $employees[$i]['employee_name'];?>" class="employee_name">
                              <input type="hidden" name="employee_mobile[<?=$i;?>]" value="<?php echo $employees[$i]['emp_mobile'];?>" class="employee_mobile">
                              <input type="hidden" name="ac_no[<?=$i;?>]" value="<?php echo $employees[$i]['st_acno'];?>" class="ac_no">
                              <input type="hidden" name="ifsc[<?=$i;?>]" value="<?php echo $employees[$i]['st_ifsc'];?>" class="ifsc">
                              <input type="hidden" name="bank_name[<?=$i;?>]" value="<?php echo $employees[$i]['st_bankname'];?>" class="bank_name">
                              <input type="hidden" name="saltranid[<?=$i;?>]" value="<?php echo $employees[$i]['transaction_id'];?>" class="saltranid">
                              <input type="hidden" name="salary[<?=$i;?>]" value="<?php echo $employeesalary;?>" class="actualsalary">
                              <input type="hidden" name="deductionWages[<?=$i;?>]" value="<?php echo $deductionWages;?>" class="deductionWages">
                              <input type="hidden" name="perdayamtforemp[<?=$i;?>]" class="perdayamtforemp" value="<?=$perDayamount?>">
                              <input type="hidden" name="totalpending[<?=$i;?>]" class="totalpending" value="<?=$totalpending?>">
                              <input type="hidden" name="actualinstallment[<?=$i;?>]" class="actualinstallment" value="<?=$installmentpaid?>">
                              <input type="hidden" name="notpaidleaves[<?=$i;?>]" class="notpaidleaves" value="<?=$notpaidleaves?>">
                              <input type="hidden" name="notpaidleavesamt[<?=$i;?>]" class="notpaidleavesamt" value="<?=$notpaidleavesamt?>">
                              <input type="hidden" name="totaldeduct[<?=$i;?>]" class="totaldeduct" value="<?=( (int)$deductionWages + (int)$notpaidleavesamt);?>">
                              <input type="hidden" name="advStatus[<?=$i;?>]" id="advStatus" value="<?php echo (!empty($advance)) ? 1 : 0;?>">
                              <select name="payinstallment[<?=$i;?>]" class="payinstallment pull-right">
                                <option value="1">Yes</option>
                                <?php if($this->session->userdata("usertype") == 'Admin'){?>
                                <option value="2">No</option>
                                <?php }?>
                              </select>
                            </th>
                            <td width="30%">
                              <input type="text" name="paidinstallment[<?=$i;?>]" class="paidinstallment form-control" value="<?=$installmentpaid?>" style="width:100px; text-align: right;" readonly="readonly">
                            </td>
                          </tr>
                          <tr>
                            <th>Allowances (+)</th>
                            <td align="right"><input type="text" name="allowances[<?=$i;?>]" id="allowances[<?=$i;?>]" class="allowances form-control-sm" value="0.00" style="width:100px; text-align: right;"></td>
                          </tr>
                          
                          <tr>
                            <th>Food</th>
                            <td align="right"><input type="text" name="food[<?=$i;?>]" id="food[<?=$i;?>]" class="food form-control-sm" value="0.00" style="width:100px; text-align: right;" ></td>
                          </tr>
                        
                          <tr>
                            <th>Uniform</th>
                            <td align="right"><input type="text" name="uniform[<?=$i;?>]" id="uniform[<?=$i;?>]" class="uniform form-control-sm" value="0.00" style="width:100px; text-align: right;" ></td>
                          </tr>
                        
                          <tr>
                            <th>Other Ded.</th>
                            <td align="right"><input type="text" name="other_ded[<?=$i;?>]" id="other_ded[<?=$i;?>]" class="other_ded form-control-sm" value="0.00" style="width:100px; text-align: right;" ></td>
                          </tr>
                        
                        <tr>
                            <th>Penalty</th>
                            <td align="right"><input type="text" name="penalty[<?=$i;?>]" id="penalty[<?=$i;?>]" class="penalty form-control-sm" value="0.00" style="width:100px; text-align: right;"></td>
                          </tr>
                        
                          <tr>
                            <th>Total Deduction</th>
                            <td align="right"><input type="text" name="" class="totaldeduct form-control-sm" value="<?=round(($deductionWages + $installmentpaid),2);?>" style="width:100px; text-align: right;" readonly></td>
                          </tr>
                          <tr>
                            <th>Final Salary</th>
                           
                  			<td>

                          <input type="hidden" class="finalsalaryy" value="<?=round(($employeesalary - ((int)$deductionWages + (int)$installmentpaid)));?>">

                          <input type="text" name="finalsalary[<?=$i;?>]" id="total_salary[<?=$i;?>]" class="finalsalary form-control" value="<?=round(($employeesalary - ((int)$deductionWages + (int)$installmentpaid)));?>" readonly="readonly"  style="width:100px; text-align: right;"></td>
                  			
                  			</tr>
                        
                        </table>
                        <textarea name="remarks[<?=$i;?>]" class="form-control" id="remarks" placeholder="Enter Remarks">Release Salary of <?=$monthtxt.' '.$year?></textarea>
                      </td>
                    </tr>
                    <?php }} ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4"></th>
                      <th>Grand Total</th>
                      <th class="grandtotal"></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <div class="radio">
                    <label for="optionsRadios1">
                      <input type="radio" name="voucher" id="optionsRadios1" value="option1" checked="checked">
                      Single Voucher
                    </label>
                  </div>
                  <div class="radio">
                    <!--<label for="optionsRadios2">
                      <input type="radio" name="voucher" id="optionsRadios2" value="option2">
                      Multiple Voucher
                    </label>-->
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="payment_mode">Payment Mode</label>
                  <select class="form-control " id="payment_mode" name="payment_mode" required="required">
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Net Banking">Net Banking</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="bank_id">Bank</label>
                  <select class="form-control" id="bank_id" name="bank_id">
                    <option>select</option>
                    <?php if($banks){ for($i=0;$i<count($banks);$i++){?>
                    <option value="<?php echo $banks[$i]['bank_id'];?>"><?php echo $banks[$i]['bank_name'].' ('.$banks[$i]['account_no'].')';?></option>
                    <?php }}?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cheque_no">Cheque/Receipt No</label>
                  <input type="text" class="form-control nocash" id="cheque_no" name="cheque_no" disabled="disabled" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="bank_name">Bank Name</label>
                  <input type="text" class="form-control nocash" id="bank_name" name="bank_name" disabled="disabled" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="bank_branch">Bank Branch</label>
                  <input type="text" class="form-control nocash" id="bank_branch" name="bank_branch" disabled="disabled" />
                </div>
              </div>
              <input type="hidden" name="month" value="<?=$month?>">
              <input type="hidden" name="year" value="<?=$year?>">
              <input type="submit" name="submitBtn" class="btn btn-primary" value="Proceed to Payment">
              <input type="submit" name="downloadBtn" class="btn btn-warning" value="Download Wage Sheet">
            </div>
          </div>
          </form>
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
<link href="<?=base_url();?>assets/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
<script src="<?=base_url();?>assets/RWD-Table-Patterns/dist/js/rwd-table.min.js"></script>
<script type="text/javascript">
$("#remarks").keydown(function(event){
    console.log(this.selectionStart);
    console.log(event);
    if(event.keyCode == 8){
        this.selectionStart--;
    }
    if(this.selectionStart < 26){
        this.selectionStart = 26;
        console.log(this.selectionStart);
        event.preventDefault();
    }
});

$("#clientunit").change(function(){
  var unit = $(this).val();
  $.ajax({
    url: '<?=site_url("Ajax_requests/get_UnitBydesignation");?>',
    data: {unit : unit},
    dataType:"HTML",
    type:"POST",
    success:function(data){        
        $("#designation").html(data);
    }
  });
});

$("#clientunit").keyup(function(){
  var unit = $(this).val();
  $.ajax({
    url: '<?=site_url("reports/get_UnitNameByUnitCode");?>',
    data: {unit : unit},
    dataType:"HTML",
    type:"POST",
    success:function(data){        
        $("#unitname").val(data);
    }
  });
});

  function getgrandtotal(){
    var grandtotal = 0;
    $(".employeeselect").each(function () {
      if ($(this).prop("checked")){
        var empid = $(this).val();
        var finalsal = parseInt($(".employee"+empid).find(".finalsalary").val());
        grandtotal = grandtotal + finalsal;
      }
    });
    $(".grandtotal").text(grandtotal);
  }

    $(".payinstallment").change(function(){
      var obj = $(this);
      if(obj.val() == '1'){
        //obj.closest('table').find(".paidinstallment").removeAttr("readonly");
        var asalary = parseFloat(obj.closest('table').find(".actualsalary").val());
        var ainstall = parseFloat(obj.closest('table').find(".actualinstallment").val());
        var notpaidleavesamt = parseFloat(obj.closest('table').find(".notpaidleavesamt").val());
        parseFloat(obj.closest('table').find(".paidinstallment").val(ainstall));
       var deductionWages = parseFloat(obj.closest('table').find(".deductionWages").val());
         var food = parseFloat(obj.closest('table').find(".food").val());
         var uniform = parseFloat(obj.closest('table').find(".uniform").val());
         var other_ded = parseFloat(obj.closest('table').find(".other_ded").val());
         var penalty = parseFloat(obj.closest('table').find(".penalty").val());
         var allowances = parseFloat(obj.closest('table').find(".allowances").val());

        var finalsalary = (asalary + allowances) - (ainstall + deductionWages +food+uniform+other_ded+penalty);
        var totaldeduct = ainstall + deductionWages +food+uniform+other_ded+penalty;
        obj.closest('table').find(".totaldeduct").val(totaldeduct.toFixed(2));
        obj.closest('table').find(".finalsalary").val(finalsalary.toFixed(0));
        obj.closest('table').find(".finalsalaryy").val(finalsalary.toFixed(0));
      }else{
        ///obj.closest('table').find(".paidinstallment").attr("readonly", "readonly");
        var asalary = parseFloat(obj.closest('table').find(".actualsalary").val());
        var deductionWages = parseFloat(obj.closest('table').find(".deductionWages").val());
        var ainstall = 0;
       
         var food = parseFloat(obj.closest('table').find(".food").val());
         var uniform = parseFloat(obj.closest('table').find(".uniform").val());
         var other_ded = parseFloat(obj.closest('table').find(".other_ded").val());
         var penalty = parseFloat(obj.closest('table').find(".penalty").val());
         var allowances = parseFloat(obj.closest('table').find(".allowances").val());

        var finalsalary = (asalary + allowances) - (ainstall + deductionWages +food+uniform+other_ded+penalty);
        var totaldeduct = ainstall + deductionWages +food+uniform+other_ded+penalty;
        obj.closest('table').find(".totaldeduct").val(totaldeduct.toFixed(2))
        obj.closest('table').find(".finalsalary").val(finalsalary.toFixed(0));
        obj.closest('table').find(".finalsalaryy").val(finalsalary.toFixed(0));
      }
      getgrandtotal();
    });

    $(".paidinstallment").change(function(){
      var obj = $(this);
      if(obj.closest('table').find(".payinstallment").val() == '1'){
        //obj.closest('table').find(".paidinstallment").removeAttr("readonly");
        var asalary = parseFloat(obj.closest('table').find(".actualsalary").val());
        var ainstall = parseFloat(obj.closest('table').find(".paidinstallment").val());
        var deductionWages = parseFloat(obj.closest('table').find(".deductionWages").val());
         
         var food = parseFloat(obj.closest('table').find(".food").val());
         var uniform = parseFloat(obj.closest('table').find(".uniform").val());
         var other_ded = parseFloat(obj.closest('table').find(".other_ded").val());
         var penalty = parseFloat(obj.closest('table').find(".penalty").val());
         var allowances = parseFloat(obj.closest('table').find(".allowances").val());

        var finalsalary = (asalary + allowances) - (ainstall + deductionWages +food+uniform+other_ded+penalty);
        var totaldeduct = ainstall + deductionWages +food+uniform+other_ded+penalty;
        obj.closest('table').find(".totaldeduct").val(totaldeduct.toFixed(2));
        obj.closest('table').find(".finalsalary").val(finalsalary.toFixed(0));
        obj.closest('table').find(".finalsalaryy").val(finalsalary.toFixed(0));
      }else{
        //obj.closest('table').find(".paidinstallment").attr("readonly", "readonly");
        var asalary = parseFloat(obj.closest('table').find(".actualsalary").val());
        var deductionWages = parseFloat(obj.closest('table').find(".deductionWages").val());
        var ainstall = 0;
        
         var food = parseFloat(obj.closest('table').find(".food").val());
         var uniform = parseFloat(obj.closest('table').find(".uniform").val());
         var other_ded = parseFloat(obj.closest('table').find(".other_ded").val());
         var penalty = parseFloat(obj.closest('table').find(".penalty").val());
         var allowances = parseFloat(obj.closest('table').find(".allowances").val());
         
         
        var finalsalary = (asalary + allowances) - (ainstall + deductionWages +food+uniform+other_ded+penalty);
        var totaldeduct = ainstall + deductionWages +food+uniform+other_ded+penalty;
        obj.closest('table').find(".totaldeduct").val(totaldeduct.toFixed(2));
        obj.closest('table').find(".finalsalary").val(finalsalary.toFixed(0));
        obj.closest('table').find(".finalsalaryy").val(finalsalary.toFixed(0));
      }
      getgrandtotal();
    });
    $("#payment_mode").change(function(e){
      e.preventDefault();
      if($(this).val() == 'Cheque' || $(this).val() == 'Net Banking' || $(this).val() == 'Bank Deposite' || $(this).val() == 'Bank Withdraw'){
        $(".nocash").removeAttr("disabled");
        $("#bank_id").attr("required", "required");
      }else{
        $(".nocash").attr("disabled", "disabled");
        $("#bank_id").removeAttr("required");
      }

    });
    $(".selectall").click(function () {
        $(".employeeselect").prop('checked', $(this).prop('checked'));
        getgrandtotal();
    });
    
    $(".employeeselect").change(function(){
        if (!$(this).prop("checked")){
            $(".selectall").prop("checked",false);
        }
        var grandtotal = 0;
        $(".employeeselect").each(function () {
          if ($(this).prop("checked")){
            var empid = $(this).val();
            var finalsal = parseInt($(".employee"+empid).find(".finalsalary").val());
            grandtotal = grandtotal + finalsal;
          }
        });
        $(".grandtotal").text(grandtotal);
    });
</script>

<script type="text/javascript">


$("#appendTr tr").keyup(function(i) {
 
    var food = parseFloat($(this).find(".food").val());
    var uniform = parseFloat($(this).find(".uniform").val());
    var other_ded = parseFloat($(this).find(".other_ded").val());
    var penalty = parseFloat($(this).find(".penalty").val());
    var allowances = parseFloat($(this).find(".allowances").val());
    
    var sal = parseFloat($(this).find(".actualsalary").val());
    var deductionWages = parseFloat($(this).find(".deductionWages").val());

    finalTot = (sal + allowances) - (deductionWages+food+uniform+other_ded+penalty);
     var totded = (deductionWages+food+uniform+other_ded+penalty);
     $(this).find(".totaldeduct").val(totded.toFixed(2));
    $(this).find(".finalsalary").val(finalTot.toFixed(0));
     getgrandtotal();
});


</script>

</body>
</html>







