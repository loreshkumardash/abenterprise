<?php $this->load->view("common/meta");?>
<style type="text/css">
    @media print {
        body * {
            visibility: hidden;
        }
        #section-to-print, #section-to-print * {
            visibility: visible;
            margin-top: -50px;
        }
        @page {
            margin-top: 1cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
        }
    }

    @print { 
        @page :footer { 
            display: none
        } 

        @page :header { 
            display: none
        } 
    } 

</style>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
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
                    <!-- <div class="pull-right"><a href="javascript:void(0);" onclick="return window.print();" class="btn btn-success">Print</a></div> -->
                    <div class="pull-right"><a href="<?=site_url("employee/printsalaryreceipt/".$saltranid.'/'.$employeeId.'/'.$salmonth.'/'.$salyear);?>" class="btn btn-success" target="_blank">Print</a></div>
                    <div class="active tab-pane" id="profile">
                        <div id="section-to-print">
                            <div class="row" style="margin-top:20px;">
                         <div class="col" style="float:left; margin-left: 20px;">
                            <img src="<?=base_url("assets/img/technologoupd.png");?>" alt="TFSM Logo" width="70px;">
                        </div>
                         <div class="col" style="text-align: center;">
                                <h4>
                                    <i>Salary Statement Of </i> <b><?php echo $employee[0]['employee_name'];?></b>
                                    <small>For the month of <b><?=date("F", mktime(0, 0, 0, $salmonth, 10))?> </b> - <?=$salyear;?></small>
                                </h4><br>
                        </div>
                    </div>
                            <table class="table table-bordered table-condensed table-striped" id="">
                                <tr>
                                    <th colspan="4">Employee Name</th>
                                </tr>
                                <tr>
                                    <td colspan="4"><?php echo $employee[0]['employee_name'];?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                				    <th>Aadhaar Number</th>
                				    <th>Pancard Number</th>
                                </tr>
                                <tr>
                                    <td><?php echo $employee[0]['employee_email'];?></td>
                                    <td><?php echo $employee[0]['emp_mobile'];?></td>
                				    <td><?php echo $employee[0]['aadhar_number'];?></td>
                				    <td><?php echo $employee[0]['employee_pan'];?></td>
                                </tr>
                                <tr>
                                    <th colspan="4">Employee Address</th>
                                </tr>
                                <tr>
                                    <td colspan="4"><?php echo $employee[0]['employee_address'];?></td>
                                </tr>
                                <?php if($voucher){?>
                                <tr>
                                    <th colspan="4">Voucher</th>
                                </tr>
                                <tr>
                                    <td colspan="4">No - <?=$voucher[0]['voucher_no'];?>, Date - <?=date("d/m/Y", strtotime($voucher[0]['payment_date']));?></td>
                                </tr>
                                <tr>
                                    <th colspan="4">Mode of Payment</th>
                                </tr>
                                <tr>
                                    <td colspan="4"><?=$voucher[0]['payment_mode'];?> <?=($voucher[0]['payment_mode'] == 'Cheque') ? ', Cheque No - '.$voucher[0]['cheque_no'].', Bank Name - '.$voucher[0]['bank_name']  : '';?><?=($voucher[0]['payment_mode'] == 'Net Banking') ? ', Bank Name - '.$voucher[0]['bank_name']  : '';?></td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <th colspan="4">Salary Structure</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <table class="table table-bordered table-condensed table-striped">
                                            <tr>
                                                <td>Wages Head</td>
                                                <td>Wages Value</td>
                                            </tr>
                                            <?php if(!empty($empSalary)){ 
                                            $totalSal = array();
                                            foreach ($empSalary as $a => $b) {
                                            array_push($totalSal, $b['sal_value']);
                                            ?>
                                            <tr>
                                                <td><?=$b['wages_name'];?></td>
                                                <td><?=$b['sal_value'];?></td>
                                            </tr>
                                            <?php }
                                            //echo '<tr><td>Total</td><td>'.$totalSalary = array_sum($totalSal).'</td></tr>';
                                            }?>  
                                            <?php if($employee[0]['epf_status'] > 0){?>
                                            <tr><td>EPF</td><td><?=$allTransaction[0]['empepfamt']?></td></tr>
                                            <tr><td>TDS</td><td><?=$allTransaction[0]['emptdsamt']?></td></tr>
                                            <tr><td>PROFESSIONAL TAX</td><td><?=$allTransaction[0]['empptaxamt']?></td></tr>
                                            <tr><td>CABLE TV</td><td><?=$allTransaction[0]['emptvamt']?></td></tr>

                                            <tr><td>INTERNET</td><td><?=$allTransaction[0]['empinternetamt']?></td></tr>
                                            <tr><td>ELECTRICITY</td><td><?=$allTransaction[0]['empelectricityamt']?></td></tr>
                                            <tr><td>MEDICAL</td><td><?=$allTransaction[0]['empmedicalamt']?></td></tr>
                                            <tr><td>OTHER DEDUCTION FEE</td><td><?=$allTransaction[0]['empotherfeeamt']?></td></tr>
                                            <?php }?> 
                                            
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4">Holiday(s) Of the Month</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
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
                                    <th colspan="4">Leave(s) History of the month</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
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
                                            <?php }}else{ echo '<tr><td colspan = "6"><center>N/A.</center></td></tr>';} ?>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4">Installment Of Advance Salary</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <table id="" class="table table-bordered table-condensed table-striped">
                                            <tr>
                                                <th>#Sl No.</th>
                                                <th>Advance Installment Amount</th>
                                                <th>Voucher No</th>
                                                <th>Payment Mode</th>
                                                <th>Advance Taken Date</th>
                                            </tr>
                                            <?php if(!empty($advinstallments)){
                                            foreach ($advinstallments as $e => $f) {
                                            ?>
                                            <tr>
                                                <td><?=($e+1)?></td>
                                                <td><?php echo $f['installamt'];?></td>
                                                <td><?php echo $f['voucher_no'];?></td>
                                                <td><?php echo $f['payment_mode'];?></td>
                                                <td><?php echo date("d/m/Y", strtotime($f['payment_date']));?></td>
                                            </tr>
                                            <?php }}else{ echo '<tr><td colspan = "4"><center>Sorry!! No data found.</center></td></tr>';} ?>
                                        </table>
                                    </td>
                                </tr>
                                

                                <tr>
                                    <th colspan="4">Total Calculation</th>
                                </tr>

                                <tr>
                                    <td colspan="4">
                                        <?php 
                                        $totalincwages     = array_sum($totalSal);
                                        $epfAmount         = ($employee[0]['epf_status'] > 0)?$allTransaction[0]['empepfamt']:0;
                                        $totalLeavetake    = (!empty($totalleaves[0]['totleaves']))?$totalleaves[0]['totleaves']:0;
                                        $totalnotpaidleave = array_sum($notpaidleave);
                                        $totalWorkingDays  = $no_of_working_days-$totalLeavetake;
                                        $perDayamount      = round($totalincwages/$totalWorkingDays);
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
                                            <tr>
                                                <td>(D) Advance Installment Amount Paid</td>
                                                <td><?=$allTransaction[0]['installamt'];?></td>
                                            </tr>
                                            <tr>
                                                <td>Total Deduct (B+C+D)</td>
                                                <td><?=$deduct_amt = $allTransaction[0]['empepfamt'] + $allTransaction[0]['emptdsamt'] + $allTransaction[0]['empptaxamt'] + $allTransaction[0]['emptvamt']+$allTransaction[0]['empinternetamt']+$allTransaction[0]['empelectricityamt']+$allTransaction[0]['empmedicalamt']+$allTransaction[0]['empotherfeeamt'] ;?></td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Total In Hand (A-(B+C+D)+E)</td>
                                                <td><?=$totalincwages - $deduct_amt;?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

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
    $('.clockpick').clockpicker({
        autoclose:true
    });
    </script>
</body>
</html>