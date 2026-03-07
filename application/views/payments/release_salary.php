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
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Change Month</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <form action="<?=site_url("payments/release_salary");?>">
                <div class="col-md-4">
                  <select class="form-control form-control-sm" name="year">
                    <?php $yr = date("Y"); for ($y=0; $y < 6; $y++) { 
                      $yrr = $yr - $y;
                      $sel = $yrr == $year ? 'selected="selected"' : '';
                      echo '<option value="'.$yrr.'" '.$sel.'>'.$yrr.'</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
                  <input type="submit" class="btn btn-primary" value="Submit">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Holiday List</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($holidays){ for($i=0;$i<count($holidays);$i++){ ?>
                    <tr>
                      <td><?php echo date('d-M-Y',strtotime($holidays[$i]['from_date']));?></td>
                      <td><?php echo $holidays[$i]['name'];?></td>
                    </tr>
                    <?php }} ?>
                  </tbody>
                </table>
              </div>
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
              <button type="button" name="" class="btn btn-xs btn-default"><?php echo date('d-M-Y',strtotime($sfiles[$i]['last_modified']));?><a href="https://technofacility.org.in/erp/uploads/<?php echo $sfiles[$i]['filename'];?>" target="_blank" class="btn btn-xs btn-success margin"><i class="fa fa-download"></i></a></button>
              <?php }} ?>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <form action="<?=site_url("payments/release_salary");?>" method="post">
            <input type="hidden" name="totalempwrkdays" value="<?=$no_of_working_days;?>">
            <input type="hidden" name="oremarks" value="Salary Release for the month of <?=date('F Y', strtotime($year."-".$month));?>">
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
                    <?php if($employees){ for($i=0;$i<count($employees);$i++){ if($employees[$i]['salary'] == ''){ continue;}


                      /*$leaves = getFetchRows("`leave_application` A LEFT JOIN leave_master B ON (A.leave_type = B.leave_id)", "A.*,B.leave_type,B.is_paid", "A.employee_id = ".$employees[$i]['employee_id']." AND A.leave_status = 1 AND MONTH(A.apply_from) = '".$month."' AND YEAR(A.apply_from) = '".$year."'");
                      $notpaidleaves = getFetchRows("`leave_application` A LEFT JOIN leave_master B ON (A.leave_type = B.leave_id)", "A.*,B.leave_type,B.is_paid", "B.is_paid != 1 AND A.employee_id = ".$employees[$i]['employee_id']." AND A.leave_status = 1 AND MONTH(A.apply_from) = '".$month."' AND YEAR(A.apply_from) = '".$year."'");*/
                      $totalleaves = $this->Common_Model->db_query("SELECT SUM(no_of_days) AS totleaves FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE a.employee_id = ".$employees[$i]['employee_id']." AND a.leave_status = 1 AND MONTH(a.apply_from) = '".$month."' AND YEAR(a.apply_from) = '".$year."' ");
                      $leaves = $totalleaves[0]['totleaves'];

                      $totalnotpaidleaves = $this->Common_Model->db_query("SELECT SUM(no_of_days) AS totnotpaidleaves FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE a.employee_id = ".$employees[$i]['employee_id']." AND a.leave_status = 1 AND MONTH(a.apply_from) = '".$month."' AND YEAR(a.apply_from) = '".$year."' AND b.is_paid != 1 ");
                      $notpaidleaves = $totalnotpaidleaves[0]['totnotpaidleaves'];
/*deduct enr AMT*/
                      /*$deductenrAmt = getFetchData("employees","*", "employee_id = ".$employees[$i]['employee_id']." AND MONTH(emp_doj) <= '".$month."' AND YEAR(emp_doj) <= '".$year."'");*/
                     

                      $advance = getFetchData("adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id)", "A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment", "A.employee_id = ".$employees[$i]['employee_id']." AND A.adv_taken_status = 0 AND MONTH(A.adv_taken_date) <= '".$month."' AND YEAR(A.adv_taken_date) <= '".$year."' GROUP BY A.advsal_id");
                      $salarystr = getFetchData("`salary_config` A LEFT JOIN wages B ON (A.`salary_head` = B.wages_id)", "A.*,B.wages_name, B.deduction, B.sequence, B.wages_id", "A.`employee_id` = ".$employees[$i]['employee_id']." order by B.sequence asc");
                      $installmentpaid = 0;
                      $employeesalary = 0;
                      /*if($salarystr){ $sl = 1; $plus = 0; $minus = 0; for($j=0;$j<count($salarystr);$j++){

                        if($salarystr[$j]['deduction'] == '0'){
                          $plus = $plus + (int)$salarystr[$j]['salary_value'];
                        }else{
                          $minus = $minus + (int)$salarystr[$j]['salary_value'];
                        }
                      }$employeesalary = $plus - $minus;}
                      $perDayamount      = round($employeesalary/$no_of_working_days,2);*/
                      $actualworkingdays = $no_of_working_days;
                      $thismonth = $year."-".$month;
                      if(date("Y-m", strtotime($employees[$i]['emp_doj'])) == $thismonth){
                        $start = new DateTime($employees[$i]['emp_doj']);
                        $end = new DateTime($monthEndDate);
                        $end->modify('+1 day');
                        $interval = $end->diff($start);
                        $days = $interval->days;
                        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
                        foreach($period as $dt) {
                          $curr = $dt->format('D');
                          /*if ($curr == 'Sun') {
                            $days--;
                          }
                          elseif (in_array($dt->format('Y-m-d'), $holidayArr)) {
                            $days--;
                          }*/
                        }
                        $actualworkingdays = $days;
                      } 
                      $notpaidleaves = $notpaidleaves + ($no_of_working_days - $actualworkingdays);
                      $empworkingdays = $actualworkingdays - $notpaidleaves;
                      //echo $empworkingdays;
                    ?>
                    <tr class="employee<?php echo $employees[$i]['employee_id'];?>">
                      <th><input type="checkbox" name="employee_id[<?=$i;?>]" value="<?php echo $employees[$i]['employee_id'];?>" class="employeeselect"></th>
                      <td>
                        
                        <table class="table table-condensed">
                          <tr>
                            <td colspan="2"><a href="<?php echo base_url();?>index.php/employee/viewemployee/<?php echo $employees[$i]['employee_id'];?>" class="btn btn-primary btn-xs" target="_blank"><b><?php echo $employees[$i]['employee_name'].'('.$employees[$i]['employee_id'].')';?></b></a></td>
                          </tr>
                          <tr>
                            <th>Aadhar Number</th>
                            <td><?php echo $employees[$i]['aadhar_number'];?></td>
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
                            <td><?php echo $employees[$i]['bank_name'];?></td>
                          </tr>
                          <tr>
                            <th>Bank IFSC</th>
                            <td><?php echo $employees[$i]['ifsc'];?></td>
                          </tr>
                          <tr>
                            <th>Bank AC/No</th>
                            <td><?php echo $employees[$i]['ac_no'];?></td>
                          </tr>
                        </table>
                      </td>
                      <td>
                        
                        <table class="table table-condensed">
                          <?php if($salarystr){ $sl = 1; for($j=0;$j<count($salarystr);$j++){ 
                          ?>
                          <?php if ($salarystr[$j]['wages_id'] == 6 ) { ?>
                          <tr>
                            <th><?=$salarystr[$j]['wages_name']?>(<?php echo $salarystr[$j]['deduction'] == '0' ? '+' : '-';?>)
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr[$j]['wages_id'];?>">
                            </th>
                            <td align="right">
                                  
                              <?php if($salarystr[$j]['salary_value'] > 0){echo $basic = round($salarystr[$j]['salary_value']/$actualworkingdays*$empworkingdays);}else{echo $basic = 0;}?>.00

                              <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=$basic?>">
                            </td>
                          </tr>
                           <?php }?>
                           <?php if ($salarystr[$j]['wages_id'] == 7) { ?>
                          <tr>
                            <th><?=$salarystr[$j]['wages_name']?>(<?php echo $salarystr[$j]['deduction'] == '0' ? '+' : '-';?>)
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr[$j]['wages_id'];?>">
                            </th>
                            <td align="right">
                                  

                              <?php if($salarystr[$j]['salary_value'] > 0){echo $gradepay = round($salarystr[$j]['salary_value']/$actualworkingdays*$empworkingdays);}else{echo $gradepay = 0;}?>.00
                              <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=$gradepay?>">
                            </td>
                          </tr>
                           <?php }?>
                           <?php if ($salarystr[$j]['wages_id'] == 8) { ?>
                          <tr>
                            <th><?=$salarystr[$j]['wages_name']?>(<?php echo $salarystr[$j]['deduction'] == '0' ? '+' : '-';?>)
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr[$j]['wages_id'];?>">
                            </th>
                            <td align="right">
                                  

                              <?php if($salarystr[$j]['salary_value'] > 0){echo $da = round(($basic+$gradepay)*164/100);}else{echo $da = 0;}?>.00
                              <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=$da?>">
                            </td>
                          </tr>
                           <?php }?>
                           <?php if ($salarystr[$j]['wages_id'] == 3) { ?>
                          <tr>
                            <th><?=$salarystr[$j]['wages_name']?>(<?php echo $salarystr[$j]['deduction'] == '0' ? '+' : '-';?>)
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr[$j]['wages_id'];?>">
                            </th>
                            <td align="right">
                                  

                              <?php if($salarystr[$j]['salary_value'] > 0){echo  $hra = round(($basic+$gradepay)*10/100);}else{echo $hra = 0;}?>.00
                                <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=$hra?>">
                            </td>
                          </tr>
                           <?php }?>
                           <?php if ($salarystr[$j]['wages_id'] == 10) { ?>
                          <tr>
                            <th><?=$salarystr[$j]['wages_name']?>(<?php echo $salarystr[$j]['deduction'] == '0' ? '+' : '-';?>)
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr[$j]['wages_id'];?>">
                            </th>
                            <td align="right">
                                  

                              <?=$sa=$salarystr[$j]['salary_value'];?>
                                
                                <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=$sa?>">
                              </td>
                          </tr>
                           <?php }?>
                           <?php if ($salarystr[$j]['wages_id'] == 12) { ?>
                          <tr>
                            <th><?=$salarystr[$j]['wages_name']?>(<?php echo $salarystr[$j]['deduction'] == '0' ? '+' : '-';?>)
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr[$j]['wages_id'];?>">
                            </th>
                            <td align="right">
                                  

                              <?=$mob=$salarystr[$j]['salary_value'];?>
                                
                                <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=$mob?>">
                              </td>
                          </tr>
                           <?php }?>
                            <!--<?php if ($salarystr[$j]['wages_id'] == 13) { ?>
                          <tr>
                            <th><?=$salarystr[$j]['wages_name']?>(<?php echo $salarystr[$j]['deduction'] == '0' ? '+' : '-';?>)
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr[$j]['wages_id'];?>">
                            </th>
                            <td align="right">
                                  

                              <?=$bonus=$salarystr[$j]['salary_value'];?>
                                <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=$bonus?>">
                              </td>
                          </tr>
                           <?php }?> -->
                           <?php if ($salarystr[$j]['wages_id'] == 14) { ?>
                          <tr>
                            <th><?=$salarystr[$j]['wages_name']?>(<?php echo $salarystr[$j]['deduction'] == '0' ? '+' : '-';?>)
                              <input type="hidden" name="wages_id<?=$i;?>[]" value="<?=$salarystr[$j]['wages_id'];?>">
                            </th>
                            <td align="right">
                                  

                              <?=$gratuity=$salarystr[$j]['salary_value'];?>
                                <input type="hidden" name="sal_value<?=$i;?>[]" value="<?=$gratuity?>">
                              </td>
                          </tr>
                          <?php }?>
                          <?php }}?>
                          <tr>
                            <th>Total Salary</th>
                            <td align="right"><?php echo $employeesalary = ($basic + $gradepay + $da + $hra + $sa + $mob +  $gratuity);?>.00
                              <?php $epf_finalamt =  round(($basic + $gradepay + $da )*12/100);?>
                            </td>
                          </tr>
                        </table>

                        <table class="table table-condensed">
                          <tr>
                            <th>Total Working Days</th>
                            <td align="right"><?=$no_of_working_days;?></td>
                          </tr>
                          <tr>
                            <th>Per Day Salary</th>
                            <td align="right"><?=$perDayamount = round($employeesalary / $no_of_working_days,2);?></td>
                          </tr>
                          <tr>
                            <th>Actual Working Days</th>
                            <td align="right"><?=$actualworkingdays;?></td>
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
                          //$notpaidleavesamt = $notpaidleaves * $perDayamount;
                          $notpaidleavesamt = 0;
                          ?>
                          <!--
                          <tr>
                            <th>Deduct Salary</th>
                            <td>
                              <select name="deductpaidleave[]" class="deductpaidleave pull-right" <?=$notpaidleaves > 0 ? '' : 'readonly="readonly"'?>>
                                <option value="2">No</option>
                                <option value="1">Yes</option>
                              </select>
                            </td>
                          </tr>
                          -->
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
                              <input type="hidden" name="employee_name[<?=$i;?>]" value="<?php echo $employees[$i]['employee_name'];?>" class="employee_name">
                              <input type="hidden" name="employee_mobile[<?=$i;?>]" value="<?php echo $employees[$i]['emp_mobile'];?>" class="employee_mobile">
                              <input type="hidden" name="ac_no[<?=$i;?>]" value="<?php echo $employees[$i]['ac_no'];?>" class="ac_no">
                              <input type="hidden" name="ifsc[<?=$i;?>]" value="<?php echo $employees[$i]['ifsc'];?>" class="ifsc">
                              <input type="hidden" name="bank_name[<?=$i;?>]" value="<?php echo $employees[$i]['bank_name'];?>" class="bank_name">
                              <input type="hidden" name="saltranid[<?=$i;?>]" value="<?php echo $employees[$i]['transaction_id'];?>" class="saltranid">
                              <input type="hidden" name="salary[<?=$i;?>]" value="<?php echo $employeesalary;?>" class="actualsalary">
                              <input type="hidden" name="perdayamtforemp[<?=$i;?>]" class="perdayamtforemp" value="<?=$perDayamount?>">
                              <input type="hidden" name="totalpending[<?=$i;?>]" class="totalpending" value="<?=$totalpending?>">
                              <input type="hidden" name="actualinstallment[<?=$i;?>]" class="actualinstallment" value="<?=$installmentpaid?>">
                              <input type="hidden" name="notpaidleaves[<?=$i;?>]" class="notpaidleaves" value="<?=$notpaidleaves?>">
                              <input type="hidden" name="notpaidleavesamt[<?=$i;?>]" class="notpaidleavesamt" value="<?=$notpaidleavesamt?>">
                              <input type="hidden" name="totaldeduct[<?=$i;?>]" class="totaldeduct" value="<?=((int)$epf_finalamt + (int)$employees[$i]['tds_percentile'] + (int)$employees[$i]['ptax_percentile'] + (int)$employees[$i]['tv_percentile'] + (int)$employees[$i]['internet_percentile'] + (int)$employees[$i]['electricity_percentile'] + (int)$employees[$i]['medical_percentile'] + (int)$employees[$i]['otherfee_percentile'] + (int)$notpaidleavesamt);?>">
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
                            <th>EPF</th>
                            <td align="right"><input type="text"  onkeyup="addtototal();" name="epf_percentile[<?=$i;?>]" id="epf_percentile[<?=$i;?>]" class="epf_percentile form-control-sm" value="<?=$epf_finalamt;?>" style="width:100px; text-align: right;" readonly></td>
                          </tr>
                          <!-- <tr>
                            <th>Arrear-2 (+)</th>
                            <td align="right"><input type="text"  onkeyup="addtototal();" name="arrearr[<?=$i;?>]" id="arrearr[<?=$i;?>]" class="arrearr form-control-sm" value="0.00" style="width:100px; text-align: right;" ></td>
                          </tr> -->
                          <tr>
                            <th>TDS</th>
                            <td align="right"><input type="text" name="tds_percentile[<?=$i;?>]" id="tds_percentile[<?=$i;?>]" class="tds_percentile form-control-sm" value="<?=$employees[$i]['tds_percentile']?>" style="width:100px; text-align: right;"></td>
                          </tr>
                          <tr>
                            <th>Professional Tax</th>
                            <td align="right"><input type="text" name="ptax_percentile[<?=$i;?>]" id="ptax_percentile[<?=$i;?>]" class="ptax_percentile form-control-sm" value="<?=$employees[$i]['ptax_percentile']?>" style="width:100px; text-align: right;"></td>
                          </tr>
                          <tr>
                            <th>Cable TV</th>
                            <td align="right"><input type="text" name="tv_percentile[<?=$i;?>]" id="tv_percentile[<?=$i;?>]" class="tv_percentile form-control-sm" value="<?=$employees[$i]['tv_percentile']?>" style="width:100px; text-align: right;"></td>
                          </tr>
                          <tr>
                            <th>Internet</th>
                            <td align="right"><input type="text" name="internet_percentile[<?=$i;?>]" id="internet_percentile[<?=$i;?>]" class="internet_percentile form-control-sm" value="<?=$employees[$i]['internet_percentile']?>" style="width:100px; text-align: right;"></td>
                          </tr>
                          <tr>
                            <th>Electricity</th>
                            <td align="right"><input type="text" name="electricity_percentile[<?=$i;?>]" id="electricity_percentile[<?=$i;?>]" class="electricity_percentile form-control-sm" value="<?=$employees[$i]['electricity_percentile']?>" style="width:100px; text-align: right;"></td>
                          </tr>
                          <tr>
                            <th>Medical</th>
                            <td align="right"><input type="text" name="medical_percentile[<?=$i;?>]" id="medical_percentile[<?=$i;?>]" class="medical_percentile form-control-sm" value="<?=$employees[$i]['medical_percentile']?>" style="width:100px; text-align: right;"></td>
                          </tr>
                          <tr>
                            <th>Others Dedn.& Fee</th>
                            <td align="right"><input type="text" name="otherfee_percentile[<?=$i;?>]" id="otherfee_percentile[<?=$i;?>]" class="otherfee_percentile form-control-sm" value="<?=$employees[$i]['otherfee_percentile']?>" style="width:100px; text-align: right;"></td>
                          </tr>

                          

                          <tr>
                            <th>Final Salary</th>
			<?php if($this->session->userdata("usertype") == 'Admin'){?>
                            <td>
                              <input type="hidden" class="finalsalaryy" value="<?=($employeesalary - ((int)$epf_finalamt + (int)$employees[$i]['tds_percentile'] + (int)$employees[$i]['ptax_percentile'] + (int)$employees[$i]['tv_percentile'] + (int)$employees[$i]['internet_percentile'] + (int)$employees[$i]['electricity_percentile'] + (int)$employees[$i]['medical_percentile'] + (int)$employees[$i]['otherfee_percentile'] + (int)$notpaidleavesamt)) - $installmentpaid;?>">

                              <input type="text" name="finalsalary[<?=$i;?>]" id="total_salary[<?=$i;?>]" class="finalsalary form-control" value="<?=($employeesalary - ((int)$epf_finalamt + (int)$employees[$i]['tds_percentile'] + (int)$employees[$i]['ptax_percentile'] + (int)$employees[$i]['tv_percentile'] + (int)$employees[$i]['internet_percentile'] + (int)$employees[$i]['electricity_percentile'] + (int)$employees[$i]['medical_percentile'] + (int)$employees[$i]['otherfee_percentile'] + (int)$notpaidleavesamt)) - $installmentpaid;?>" readonly="readonly" style="width:100px; text-align: right;"></td>
                          <?php }else{?>
                  			<td>

                          <input type="hidden" class="finalsalaryy" value="<?=($employeesalary - ((int)$epf_finalamt + (int)$employees[$i]['tds_percentile'] + (int)$employees[$i]['ptax_percentile'] + (int)$employees[$i]['tv_percentile'] + (int)$employees[$i]['internet_percentile'] + (int)$employees[$i]['electricity_percentile'] + (int)$employees[$i]['medical_percentile'] + (int)$employees[$i]['otherfee_percentile'] + (int)$notpaidleavesamt)) - $installmentpaid;?>">

                          <input type="text" name="finalsalary[<?=$i;?>]" id="total_salary[<?=$i;?>]" class="finalsalary form-control" value="<?=($employeesalary - ((int)$epf_finalamt + (int)$employees[$i]['tds_percentile'] + (int)$employees[$i]['ptax_percentile'] + (int)$employees[$i]['tv_percentile'] + (int)$employees[$i]['internet_percentile'] + (int)$employees[$i]['electricity_percentile'] + (int)$employees[$i]['medical_percentile'] + (int)$employees[$i]['otherfee_percentile'] + (int)$notpaidleavesamt)) - $installmentpaid;?>" readonly="readonly"  style="width:100px; text-align: right;"></td>
                  			<?php }?>
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
                    <label for="optionsRadios2">
                      <input type="radio" name="voucher" id="optionsRadios2" value="option2">
                      Multiple Voucher
                    </label>
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
        var asalary = parseInt(obj.closest('table').find(".actualsalary").val());
        var ainstall = parseInt(obj.closest('table').find(".actualinstallment").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        parseInt(obj.closest('table').find(".paidinstallment").val(ainstall));
        var epf = parseInt(obj.closest('table').find(".epf_percentile").val());
        //var arrearr = parseInt(obj.closest('table').find(".arrearr").val());
        var tds = parseFloat(obj.closest('table').find(".tds_percentile").val());
          
          var ptax = parseFloat(obj.closest('table').find(".ptax_percentile").val());
          var tv = parseFloat(obj.closest('table').find(".tv_percentile").val());
          var internet = parseFloat(obj.closest('table').find(".internet_percentile").val());
          var electricity = parseFloat(obj.closest('table').find(".electricity_percentile").val());
          var medical = parseFloat(obj.closest('table').find(".medical_percentile").val());
          var otherfee = parseFloat(obj.closest('table').find(".otherfee_percentile").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        var finalsalary = (asalary) - (ainstall + epf + notpaidleavesamt+tds+ptax+tv+internet+electricity+medical+otherfee);
        var totaldeduct = ainstall + epf + notpaidleavesamt+tds+ptax+tv+internet+electricity+medical+otherfee;
        obj.closest('table').find(".totaldeduct").val(totaldeduct)
        obj.closest('table').find(".finalsalary").val(finalsalary.toFixed(2));
        obj.closest('table').find(".finalsalaryy").val(finalsalary.toFixed(2));
      }else{
        ///obj.closest('table').find(".paidinstallment").attr("readonly", "readonly");
        var asalary = parseInt(obj.closest('table').find(".actualsalary").val());
        var ainstall = 0;
        var epf = parseInt(obj.closest('table').find(".epf_percentile").val());
        //var arrearr = parseInt(obj.closest('table').find(".arrearr").val());
        var tds = parseFloat(obj.closest('table').find(".tds_percentile").val());
          
          var ptax = parseFloat(obj.closest('table').find(".ptax_percentile").val());
          var tv = parseFloat(obj.closest('table').find(".tv_percentile").val());
          var internet = parseFloat(obj.closest('table').find(".internet_percentile").val());
          var electricity = parseFloat(obj.closest('table').find(".electricity_percentile").val());
          var medical = parseFloat(obj.closest('table').find(".medical_percentile").val());
          var otherfee = parseFloat(obj.closest('table').find(".otherfee_percentile").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        var finalsalary = (asalary) - (ainstall + epf + notpaidleavesamt+tds+ptax+tv+internet+electricity+medical+otherfee);
        var totaldeduct = ainstall + epf + notpaidleavesamt+tds+ptax+tv+internet+electricity+medical+otherfee;
        obj.closest('table').find(".totaldeduct").val(totaldeduct)
        obj.closest('table').find(".finalsalary").val(finalsalary.toFixed(2));
        obj.closest('table').find(".finalsalaryy").val(finalsalary.toFixed(2));
      }
      getgrandtotal();
    });

    $(".paidinstallment").change(function(){
      var obj = $(this);
      if(obj.closest('table').find(".payinstallment").val() == '1'){
        //obj.closest('table').find(".paidinstallment").removeAttr("readonly");
        var asalary = parseInt(obj.closest('table').find(".actualsalary").val());
        var ainstall = parseInt(obj.closest('table').find(".paidinstallment").val());
        var epf = parseInt(obj.closest('table').find(".epf_percentile").val());
        //var arrearr = parseInt(obj.closest('table').find(".arrearr").val());
        var tds = parseFloat(obj.closest('table').find(".tds_percentile").val());
          
          var ptax = parseFloat(obj.closest('table').find(".ptax_percentile").val());
          var tv = parseFloat(obj.closest('table').find(".tv_percentile").val());
          var internet = parseFloat(obj.closest('table').find(".internet_percentile").val());
          var electricity = parseFloat(obj.closest('table').find(".electricity_percentile").val());
          var medical = parseFloat(obj.closest('table').find(".medical_percentile").val());
          var otherfee = parseFloat(obj.closest('table').find(".otherfee_percentile").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        var finalsalary = (asalary) - (ainstall + epf + notpaidleavesamt+tds+ptax+tv+internet+electricity+medical+otherfee);
        var totaldeduct = ainstall + epf + notpaidleavesamt+tds+ptax+tv+internet+electricity+medical+otherfee;
        obj.closest('table').find(".totaldeduct").val(totaldeduct)
        obj.closest('table').find(".finalsalary").val(finalsalary.toFixed(2));
        obj.closest('table').find(".finalsalaryy").val(finalsalary.toFixed(2));
      }else{
        //obj.closest('table').find(".paidinstallment").attr("readonly", "readonly");
        var asalary = parseInt(obj.closest('table').find(".actualsalary").val());
        var ainstall = 0;
        var epf = parseInt(obj.closest('table').find(".epf_percentile").val());
        //var arrearr = parseInt(obj.closest('table').find(".arrearr").val());
        var tds = parseFloat(obj.closest('table').find(".tds_percentile").val());
          
          var ptax = parseFloat(obj.closest('table').find(".ptax_percentile").val());
          var tv = parseFloat(obj.closest('table').find(".tv_percentile").val());
          var internet = parseFloat(obj.closest('table').find(".internet_percentile").val());
          var electricity = parseFloat(obj.closest('table').find(".electricity_percentile").val());
          var medical = parseFloat(obj.closest('table').find(".medical_percentile").val());
          var otherfee = parseFloat(obj.closest('table').find(".otherfee_percentile").val());
        var notpaidleavesamt = parseInt(obj.closest('table').find(".notpaidleavesamt").val());
        var finalsalary = (asalary) - (ainstall + epf + notpaidleavesamt +tds+ptax+tv+internet+electricity+medical+otherfee);
        var totaldeduct = ainstall + epf + notpaidleavesamt+tds+ptax+tv+internet+electricity+medical+otherfee;
        obj.closest('table').find(".totaldeduct").val(totaldeduct)
        obj.closest('table').find(".finalsalary").val(finalsalary.toFixed(2));
        obj.closest('table').find(".finalsalaryy").val(finalsalary.toFixed(2));
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

/*function addtototal(){

$("#appendTr tr").each(function(i) {
//alert(7);
    var tds = $(this).find(parseFloat(".tds_percentile").val());
    var epf = $(this).find(parseFloat(".epf_percentile").val());
    
    var sal = $(parseFloat(".finalsalary").val());

    finalTot = sal - (parseFloat(epf));
   // alert(finalTot);
    $(".finalsalary").val(finalTot.toFixed(2));
});
}*/
$("#appendTr tr").keyup(function(i) {

    //var arrearr = parseFloat($(this).find(".arrearr").val());
    var tds = parseFloat($(this).find(".tds_percentile").val());
    var epf = parseFloat($(this).find(".epf_percentile").val());
    var ptax = parseFloat($(this).find(".ptax_percentile").val());
    var tv = parseFloat($(this).find(".tv_percentile").val());
    var internet = parseFloat($(this).find(".internet_percentile").val());
    var electricity = parseFloat($(this).find(".electricity_percentile").val());
    var medical = parseFloat($(this).find(".medical_percentile").val());
    var otherfee = parseFloat($(this).find(".otherfee_percentile").val());
    
    var sal = parseFloat($(this).find(".finalsalaryy").val());

    finalTot = (sal) - (tds+ptax+tv+internet+electricity+medical+otherfee);
    
    $(this).find(".finalsalary").val(finalTot.toFixed(2));
});


</script>

</body>
</html>

