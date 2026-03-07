
<table style="font-family:serif;">	
	<tr>
		<td width="20%">
			<img src="<?=base_url('assets/img/technologoupd.png');?>" alt="TFSM Logo" width="90" style="padding-left: 30px;" >
		</td>
		<td width="60%" style="text-align:center;">
				<br>
				<span style="font-size:15px;text-decoration: underline;"><b>TECHNO FACILITY AND MANAGEMENT SERVICES</b></span><br>
				<span style="font-size:13px;">Damana Square, Chandrasekharpur, Bhubaneswar (Odisha)</span><br>
				<span style="font-size:14px;text-decoration: underline;">Pay Slip For <?php if ($salmonth) {
					echo date("F",mktime(0, 0, 0, $salmonth, 10)); 
				} ?> <?=$salyear;?></span>

			
		</td>
		<td width="20%"></td>
	</tr>
</table>
<br><br><br>
<?php 
	 if(!empty($empSalary)){ 
    $totalSal = array();
    foreach ($empSalary as $a => $b) {
    array_push($totalSal, $b['sal_value']);
	}}

    $notpaidleave = array(); if($leave_taken){ for($i=0;$i<count($leave_taken);$i++){ if($leave_taken[$i]['is_paid'] == 0){ array_push($notpaidleave, $leave_taken[$i]['no_of_days']); }}}
    
	$totalincwages     = array_sum($totalSal);
	$epfAmount         = ($employee[0]['epf_status'] > 0)?$allTransaction[0]['empepfamt']:0;
	$totalLeavetake    = (!empty($totalleaves[0]['totleaves']))?$totalleaves[0]['totleaves']:0;
	$totalnotpaidleave = array_sum($notpaidleave);
	$totalWorkingDays  = $no_of_working_days-$totalLeavetake;
	$perDayamount      = round($totalincwages/$totalWorkingDays,2);
	$totalNotPaidlvamt = $totalnotpaidleave*$perDayamount;
	?>
<table style="font-family: cursive;font-size: 12px;" class="table table-bordered table-condensed table-striped " width="100%" border="1" cellpadding="4">	
	<tr>
		<td width="22%">Employee ID</td>
		<td width="28%"><?=$employee[0]['techno_emp_id'];?></td>
		<td width="22%">PF Number</td>
		<td width="28%"><?=$employee[0]['pf_number'];?></td>
	</tr>
	<tr>
		<td width="22%">Employee Name</td>
		<td width="28%"><span style="text-transform:uppercase;"><?=$employee[0]['employee_name'];?></span></td>
		<td width="22%">Date of Joining</td>
		<td width="28%"><?=$employee[0]['emp_doj']?date("d-m-Y",strtotime($employee[0]['emp_doj'])):'';?></td>
	</tr>
	<tr>
		<td width="22%">Designation</td>
		<td width="28%"><?=$designation[0]['designation_name'];?></td>
		<td width="22%">Days</td>
		<td width="28%"><?=$no_of_working_days;?></td>
	</tr>
	<tr>
		<td width="22%">Bank Details</td>
		<td width="28%"><?=$employee[0]['bank_name'];?></td>
		<td width="22%">Present</td>
		<td width="28%"><?=$totalWorkingDays;?></td>
	</tr>
	<tr>
		<td width="22%">PAN Number</td>
		<td width="28%"><?=$employee[0]['employee_pan'];?></td>
		<td width="22%"></td>
		<td width="28%"></td>
	</tr>
</table>
<br><br>

<table style="font-family: inherit;font-size: 11px;" class="table table-bordered table-condensed table-striped " width="100%" border="1" cellpadding="4">	
	<tr>
		<td width="50%" colspan="2" style="text-align:center;"><b>EARNING</b></td>
		<td width="50%" colspan="2" style="text-align:center;"><b>DEDUCTION</b></td>
	</tr>
	<tr>
		<td width="22%">BASIC</td>
		<td width="28%" style="text-align:right;">
			<?php if ($empSalary) { for ($i=0; $i < count($empSalary); $i++) { 
				if ($empSalary[$i]['wgs_id']=='6') {
					echo $empSalary[$i]['sal_value'];
				}
			} }?>

		</td>
		<td width="22%">TDS</td>
		<td width="28%" style="text-align:right;"><?=$allTransaction[0]['emptdsamt']?></td>
	</tr>
	<tr>
		<td width="22%">GRADE PAY</td>
		<td width="28%" style="text-align:right;">
			<?php if ($empSalary) { for ($i=0; $i < count($empSalary); $i++) { 
				if ($empSalary[$i]['wgs_id']=='7') {
					echo $empSalary[$i]['sal_value'];
				}
			} }?>
		</td>
		<td width="22%">EPF</td>
		<td width="28%" style="text-align:right;"><?=$allTransaction[0]['empepfamt']?></td>
	</tr>
	<tr>
		<td width="22%">DA (@ 164%)</td>
		<td width="28%" style="text-align:right;">
			<?php if ($empSalary) { for ($i=0; $i < count($empSalary); $i++) { 
				if ($empSalary[$i]['wgs_id']=='8') {
					echo $empSalary[$i]['sal_value'];
				}
			} }?>
		</td>
		<td width="22%">PROFESSIONAL TAX</td>
		<td width="28%" style="text-align:right;"><?=$allTransaction[0]['empptaxamt']?></td>
	</tr>
	<tr>
		<td width="22%">HRA (@ 10%)</td>
		<td width="28%" style="text-align:right;">
			<?php if ($empSalary) { for ($i=0; $i < count($empSalary); $i++) { 
				if ($empSalary[$i]['wgs_id']=='3') {
					echo $empSalary[$i]['sal_value'];
				}
			} }?>
		</td>
		<td width="22%">CABLE TV</td>
		<td width="28%" style="text-align:right;"><?=$allTransaction[0]['emptvamt']?></td>
	</tr>
	<tr>
		<td width="22%">SPL. ALLOWANCE</td>
		<td width="28%" style="text-align:right;">
			<?php if ($empSalary) { for ($i=0; $i < count($empSalary); $i++) { 
				if ($empSalary[$i]['wgs_id']=='10') {
					echo $empSalary[$i]['sal_value'];
				}
			} }?>
		</td>
		<td width="22%">INTERNET</td>
		<td width="28%" style="text-align:right;"><?=$allTransaction[0]['empinternetamt']?></td>
	</tr>
	<tr>
		<td width="22%">MOBILE</td>
		<td width="28%" style="text-align:right;">
			<?php if ($empSalary) { for ($i=0; $i < count($empSalary); $i++) { 
				if ($empSalary[$i]['wgs_id']=='12') {
					echo $empSalary[$i]['sal_value'];
				}
			} }?>
		</td>
		<td width="22%">ELECTRICITY</td>
		<td width="28%" style="text-align:right;"><?=$allTransaction[0]['empelectricityamt']?></td>
	</tr>
	<tr>
		<td width="22%">BONUS</td>
		<td width="28%" style="text-align:right;">
			<?php if ($empSalary) { for ($i=0; $i < count($empSalary); $i++) { 
				if ($empSalary[$i]['wgs_id']=='13') {
					echo $empSalary[$i]['sal_value'];
				}
			} }?> 
			
		</td>
		<td width="22%">MEDICAL</td>
		<td width="28%" style="text-align:right;"><?=$allTransaction[0]['empmedicalamt']?></td>
	</tr>
	<tr>
		<td width="22%">GRATUITY</td>
		<td width="28%" style="text-align:right;">
			<?php if ($empSalary) { for ($i=0; $i < count($empSalary); $i++) { 
				if ($empSalary[$i]['wgs_id']=='14') {
					echo $empSalary[$i]['sal_value'];
				}
			} }?>
		</td>
		<td width="22%">OTHER DED. FEE</td>
		<td width="28%" style="text-align:right;"><?=$allTransaction[0]['empotherfeeamt']?></td>
	</tr>
	<tr>
		<td width="22%"><b>GROSS SALARY</b></td>
		<td width="28%" style="text-align:right;"><b><?=$totalincwages+$allTransaction[0]['emparrearramt'];?></b></td>
		<td width="22%"><b>TOTAL DEDUCTION</b></td>
		<td width="28%" style="text-align:right;"><b><?php $totaldedn = ($allTransaction[0]['emptdsamt']+$allTransaction[0]['empepfamt']+$allTransaction[0]['emptvamt']+$allTransaction[0]['empptaxamt']+$allTransaction[0]['empinternetamt']+$allTransaction[0]['empelectricityamt']+$allTransaction[0]['empmedicalamt']+$allTransaction[0]['empotherfeeamt']);echo round($totaldedn,2);  ?></b></td>
	</tr>
	<tr>
		<td width="22%"></td>
		<td width="28%"></td>
		<td width="22%"><b>NET SALARY</b></td>
		<td width="28%" style="text-align:right;"><b><?php $netsalary = $totalincwages - $totaldedn + $allTransaction[0]['emparrearramt'];echo round($netsalary,2); ?></b></td>
	</tr>
	<tr>
		<td width="100%" colspan="4" style="text-align:center;">
			<b><?php $netsalaryamt =round($netsalary,2); echo strtoupper(translateToWords(floatval($netsalaryamt)));?>ONLY</b> 
		</td>
	</tr>
	
</table>
<table style="font-family: inherit;font-size: 10px;" class="table table-bordered table-condensed table-striped " width="100%" border="1" cellpadding="7">
	<tr>
		<td style="text-align:center;"><b>Note: This is a computer generated. No signature is required.</b>
		</td>
	</tr>
</table>
<br><br>
<table>
	<tr>
		<td style="text-align: center;"><b style="text-decoration:underline;font-size: 12px;">LEAVE STATUS</b></td>
	</tr>
</table>

<br><br>

<table id="" class="table table-bordered table-condensed table-striped" border="1" cellpadding="4">
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
    <?php }}else{ echo '<tr><td colspan = "6" style="text-align:center;">N/A.</td></tr>';} ?>
</table>