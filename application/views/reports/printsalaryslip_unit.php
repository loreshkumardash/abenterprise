<br><br><table class="table table-condensed table-striped table-bordered" style="font-family: serif;font-size: 13px;background:;" border="1" cellpadding="5">
								<tr>
									<td style="text-transform: uppercase;text-align:center;">SALARY SLIP OF <b><?=$employee[0]['employee_name'];?></b> [<?=$employee[0]['techno_emp_id'];?>] FOR THE MONTH OF <b><?php echo date('F-Y',strtotime($datee));?></b></td>
								</tr>
								</table><br><br>
						
						<?php $totsalary = 0;
						$duty = 0;

						for ($i=0; $i < count($attribute); $i++) { 
								$empSalary = $this->Common_Model->FetchData("salary_transaction_wages","*","attr_id=".$attribute[$i]['attr_id']."");

								$totsalary += $attribute[$i]['totalpaid'];
								$duty += $attribute[$i]['totalduty']; ?>

							<br><table style="font-family: serif;font-size: 12px;background:;" class="table table-bordered table-condensed table-striped " width="100%" border="1" cellpadding="4">
								<tr style="background:#d2e6fa!important;">
									<td width="50%" colspan="2" style=""><b><span style=""><?=$attribute[$i]['unit_name'];?></span></b></td>
									<td width="50%" colspan="2" style=""><b>TOTAL DUTY : <span style=""><?=$attribute[$i]['totalduty'];?></span></b></td>
								</tr>
								<tr>
									<td width="50%" colspan="2" style="text-align:center;"><b>EARNING</b></td>
									<td width="50%" colspan="2" style="text-align:center;"><b>DEDUCTION</b></td>
								</tr>
								<tr>
									<td width="30%">BASIC</td>
									<td width="20%" style="text-align:right;"><?=$attribute[$i]['basicamt'];?></td>
									<td width="30%">EPF</td>
									<td width="20%" style="text-align:right;"><?=$attribute[$i]['empepfamt'];?></td>
									</tr>
									<tr>
										<td width="30%">HRA</td>
										<td width="20%" style="text-align:right;"><?=$attribute[$i]['hraamt'];?></td>
										<td width="30%">ESI</td>
										<td width="20%" style="text-align:right;"><?=$attribute[$i]['empesiamt'];?></td>
									</tr>
									<tr>
										<td width="30%">CONVEYANCE ALLOWANCES</td>
										<td width="20%" style="text-align:right;"><?=$attribute[$i]['conalamt'];?></td>
										<td width="30%">PT</td>
										<td width="20%" style="text-align:right;"><?=$attribute[$i]['ptamt'];?></td>
									</tr>
									<tr>
										<td width="30%">SPECIAL ALLOWANCES</td>
										<td width="20%" style="text-align:right;"><?=$attribute[$i]['spcalamt'];?></td>
										<td width="30%">ADMIN & OTHER CHARGES</td>
										<td width="20%" style="text-align:right;">
											<?=$attribute[$i]['admnchrge'];?></td>
									</tr>
									<tr>
										<td width="30%">BONUS</td>
										<td width="20%" style="text-align:right;"><?=$attribute[$i]['empbonusamt'];?></td>
										<td width="30%">OTHER DED.</td>
										<td width="20%" style="text-align:right;">
											<?=$attribute[$i]['empother_dedamt'];?></td>
									</tr>
									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%">FOOD</td>
										<td width="20%" style="text-align:right;">
											<?=$attribute[$i]['empfoodamt'];?></td>
									</tr>
									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%">UNIFORM</td>
										<td width="20%" style="text-align:right;">
											<?=$attribute[$i]['empuniformamt'];?></td>
									</tr>

									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%">PENALTY</td>
										<td width="20%" style="text-align:right;"><?=$attribute[$i]['emppenaltyamt'];?></td>
									</tr>
									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%">INSTALLMENT</td>
										<td width="20%" style="text-align:right;"><?=$attribute[$i]['installamt'];?></td>
									</tr>
									
									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
									</tr>
									
								<tr>
									<td width="30%"><b>GROSS SALARY</b></td>
									<td width="20%" style="text-align:right;"><b><?=$attribute[$i]['totalempwages'];?></b></td>
									<td width="30%"><b>TOTAL DEDUCTION</b></td>
									<td width="20%" style="text-align:right;"><b><?=$attribute[$i]['totaldeduct'];?></b></td>
								</tr>
								<tr>
									<td width="30%"></td>
									<td width="20%"></td>
									<td width="30%"><b>ALLOWANCES</b></td>
									<td width="20%" style="text-align:right;"><b><?=$attribute[$i]['allowancesamt'];?></b></td>
								</tr>
								<tr>
									<td width="30%"></td>
									<td width="20%"></td>
									<td width="30%"><b>NET SALARY</b></td>
									<td width="20%" style="text-align:right;"><b><?=$attribute[$i]['totalpaid'];?></b></td>
								</tr>
								<tr>
									<td width="100%" colspan="4" style="text-align:center;">
										<b><?=strtoupper(translateToWords(floatval($attribute[$i]['totalpaid'])));?> ONLY</b> 
									</td>
								</tr>
	
								</table><br><br><br>
									
					<?php	}  ?>
					
						<table class="table table-condensed table-bordered " style="font-weight:600px;font-size:13px;font-family:serif;" border="1" cellpadding="5">
								<tr>
									<th width="22%"></th>
									<th width="28%"><b>Duty : <?=$duty;?></b></th>
									<th width="22%"><b>TOTAL SALARY</b></th>
									<th width="28%" style="text-align:right;"><b><?=number_format($totsalary,2);?></b></th>
								</tr>
						</table>