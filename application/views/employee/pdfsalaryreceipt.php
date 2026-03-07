<table width="100%" cellpadding="5" cellspacing="0" style="font-size: 11px; margin-top: 30px;" border="1">
    <tr>
        <td colspan="2" style="font-weight: bold; text-align: center;">
            <img src="<?=base_url()?>assets/img/phoenixnew.png" alt="Young Phoenix" width="350"> 
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold; text-align: center;">Payslip for the month of - <?php echo date("F", mktime(0, 0, 0, $salmonth, 10)).', '.$curSession;?></td>
    </tr>
    <tr>
        <td width="50%">
            <table border="0" width="100%" cellpadding="3" cellspacing="0">
                <tr><th width="40%">Name</th><th width="60%"><?php echo $employee[0]['employee_name'];?></th></tr>
                <tr><th>Email</th><th><?php echo $employee[0]['employee_email'];?></th></tr>
                <tr><th>Phone Number</th><th><?php echo $employee[0]['employee_mobile'];?></th></tr>
            </table>
        </td>
        <td width="50%">
            <table border="0" width="100%" cellpadding="3" cellspacing="0">
                <tr><th width="40%">Bank Name</th><th width="60%"><?php echo $employee[0]['bank_name'];?></th></tr>
                <tr><th>Bank Account No</th><th><?php echo $employee[0]['ac_no'];?></th></tr>
                <tr><th>IFSC</th><th><?php echo $employee[0]['ifsc'];?></th></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Earnings <span style="float:right;">Amount</span></td>
        <td style="font-weight: bold;">Deductions <span style="float:right;">Amount</span></td>
    </tr>
    <tr>
        <td>
            <table border="0" width="100%" cellpadding="3" cellspacing="0">
                <?php $totalSal = 0; if(!empty($empSalary)){ 
                
                foreach ($empSalary as $a => $b) {
                    if($b['deduction'] == '1')
                        continue;
                    $totalSal = $totalSal + $b['salary_value'];
                ?>
                <tr>
                    <td width="40%"><?=$b['wages_name'];?></td>
                    <td width="60%" align="right"><?=$b['salary_value'];?></td>
                </tr>
                <?php }
                //echo '<tr><td>Total</td><td>'.$totalSalary = array_sum($totalSal).'</td></tr>';
                }?>
            </table>
        </td>
        <td>
            <table border="0" width="100%" cellpadding="3" cellspacing="0">
                <?php $totalSub = 0; if(!empty($empSalary)){ 
                
                foreach ($empSalary as $a => $b) {
                    if($b['deduction'] == '0')
                        continue;
                    $totalSub = $totalSub + $b['salary_value'];
                ?>
                <tr>
                    <td width="40%"><?=$b['wages_name'];?></td>
                    <td width="60%" align="right"><?=$b['salary_value'];?></td>
                </tr>
                <?php }

                }
                $totalSub = $totalSub + (int)$allTransaction[0]['empepfamt'] + (int)$allTransaction[0]['empnotpaidleave'] + (int)$allTransaction[0]['installamt'];
                ?>
                <tr><th width="40%">EPF Amount</th><th width="60%" align="right"><?php echo $allTransaction[0]['empepfamt'];?></th></tr>
                <tr><th>Not Paid Leave</th><th align="right"><?php echo $allTransaction[0]['empnotpaidleave'];?></th></tr>
                <tr><th>Advance Installment</th><th align="right"><?php echo $allTransaction[0]['installamt'];?></th></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Total Earnings: Rs. <span style="float:right;"><?=$totalSal?></span></td>
        <td style="font-weight: bold;">Total Deductions: Rs. <span style="float:right;"><?=$totalSub;?></span></td>
    </tr>
    <tr>
        <td colspan="2">
            Net Pay for the month ( Total Earnings - Total Deductions): <?=$totalSal - $totalSub;?><br/>
            (<b><?=translateToWords($totalSal - $totalSub);?></b> only)
        </td>
    </tr>
</table>
<!-- Table row -->

<br/>
<table width="100%" cellpadding="5" cellspacing="0" style="font-size: 12px; margin-top: 30px;">
    <tr>
        <td width="25%" style="font-weight: bold; text-align: center;"><br/><br/><br/><hr/>Signature of Accounts</td>
        <td width="25%" style="font-weight: bold; text-align: center;"></td>
        <td width="20%" style="font-weight: bold; text-align: center;"></td>
        <td width="25%" style="font-weight: bold; text-align: center;"><br/><br/><br/><hr/>Signature of Pincipal</td>
    </tr>
</table>
