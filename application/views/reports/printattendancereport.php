<table class="table table-condensed table-bordered table-striped" border="1" cellpadding="4" style="font-size: 13px;font-family: serif;">
				
				<tr>
					<td width="100%" style="text-align: center;" colspan="6"><span>ATTENDANCE FOR THE MONTH OF <span style="text-transform: uppercase;"><b><?php echo date('F-Y',strtotime($datee));?></b></span></span></td>
				</tr><tr>
						<th width="5%">#Sl</th>
						<th width="15%">Emp. Code</th>
						<th width="40%">Name</th>
						<th width="10%" style="text-align:center;">Payable Days</th>
						<th width="10%" style="text-align:center;">OT Days</th>
						<th width="10%" style="text-align:center;">Total Duty</th>
						<th width="10%" style="text-align:center;">Extra Hour</th>

					</tr>

				<?php $totalduty = 0;
				$totalextrahour = 0;
				$totalfooding = 0;
				$totaluniform = 0;
				$totalpt = 0;
				$totalallowances = 0; if ($attendance) { for ($i=0; $i < count($attendance); $i++) { ?>
					<tr>
						<th><?=$i+1;?></th>
						<th><?=$attendance[$i]['techno_emp_id'];?></th>
						<th><?=substr($attendance[$i]['employee_name'],0,18);?></th>
						<th style="text-align:center;"><?=$attendance[$i]['payable_days'];?></th>
						<th style="text-align:center;"><?=$attendance[$i]['ot_days'];?></th>
						<th style="text-align:center;"><?=$attendance[$i]['total_duty'];?></th>
						<th style="text-align:right;"><?=$attendance[$i]['extra_hour'];?></th>
					</tr>
				<?php $totalduty += $attendance[$i]['total_duty'];
						$totalextrahour += $attendance[$i]['extra_hour'];

					}?> 
					<tr>
						<th colspan="5" style="text-align:right;"><b>TOTAL</b></th>
						<th style="text-align:center;"><b><?=$totalduty;?></b></th>
						<th style="text-align:right;"><b><?=$totalextrahour;?></b></th>
					</tr>
					<?php }else{ ?>
						<tr>
							<td width="100%" colspan="7" style="text-align:center;">No records found !</td>
						</tr>
				<?php } ?>
					
				

	</table>