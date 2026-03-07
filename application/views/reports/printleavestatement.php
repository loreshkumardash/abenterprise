<table class="table table-condensed table-bordered table-striped" border="1" cellpadding="3">
				<tr >
					<th width="100%" style="text-align: center;" colspan="15"><span><b>GLOSENT</b></span></th>
				</tr>
				<tr>
					<th width="100%" style="text-align: center;" colspan="15"><span><b>LEAVE STATEMENT FOR THE MONTH OF <span style="text-transform: uppercase;"><?php echo date('F-Y',strtotime($month));?></span></b></span></th>
				</tr>
				<tr>
					<th width="46%" colspan="3"></th>
					<th  width="18%" colspan="3" style="text-align: center;"><span style="font-size:8px;">LEAVE B/F & DUE</span></th>
					<th width="18%" colspan="3" style="text-align: center;"><span style="font-size:8px;">TAKEN IN <span style="text-transform: uppercase;"><?php echo date('F-Y',strtotime($month));?></span></span></th>
					<th width="18%" colspan="3" style="text-align: center;"><span style="font-size:8px;">BALANCE FOR <span style="text-transform: uppercase;"><?php echo date('F-Y',strtotime(date( "Y-m-d", strtotime( $month ) ) . "+1 month" ));?></span></span></th>
				</tr>
				<tr>
					<th width="5%" class="text-center">SL</th>
					<th width="25%" >NAME OF THE STAFF</th>
					<th width="16%" class="text-center">DESIGN.</th>
					<th width="6%" class="text-center">EL</th>
					<th width="6%" class="text-center">CL</th>
					<th width="6%" class="text-center">DL</th>

					<th width="6%" class="text-center">EL</th>
					<th width="6%" class="text-center">CL</th>
					<th width="6%" class="text-center">DL</th>

					<th width="6%" class="text-center">EL</th>
					<th width="6%" class="text-center">CL</th>
					<th width="6%" class="text-center">DL</th>

				</tr>

		

		<?php if ($employee) { for ($i=0; $i < count($employee) ; $i++) { 

				$el = $this->Common_Model->FetchData("leave_master","*","leave_type='EL'");
				$cl = $this->Common_Model->FetchData("leave_master","*","leave_type='CL'");
				$dl = $this->Common_Model->FetchData("leave_master","*","leave_type='DL'");

				$tot_el = $this->Common_Model->db_query("SELECT SUM(no_of_days) as totalel FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE b.leave_type='EL' AND a.employee_id='".$employee[$i]['employee_id']."' AND a.session='".$session[0]['session_name']."' AND a.apply_from <= '".$ldateoflmonth."'");
		
			$tot_cl = $this->Common_Model->db_query("SELECT SUM(no_of_days) as totalcl FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE b.leave_type='CL' AND a.employee_id='".$employee[$i]['employee_id']."' AND a.session='".$session[0]['session_name']."' AND a.apply_from <= '".$ldateoflmonth."'");

			$tot_dl = $this->Common_Model->db_query("SELECT SUM(no_of_days) as totaldl FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE b.leave_type='DL' AND a.employee_id='".$employee[$i]['employee_id']."' AND a.session='".$session[0]['session_name']."' AND a.apply_from <= '".$ldateoflmonth."'");


			$tot_el_in_month = $this->Common_Model->db_query("SELECT SUM(no_of_days) as totalelm FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE b.leave_type='EL' AND a.employee_id='".$employee[$i]['employee_id']."' AND a.session='".$session[0]['session_name']."' AND created_on>='".$fdate."' AND created_on<='".$ldate."'");
			$tot_cl_in_month = $this->Common_Model->db_query("SELECT SUM(no_of_days) as totalclm FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE b.leave_type='CL' AND a.employee_id='".$employee[$i]['employee_id']."' AND a.session='".$session[0]['session_name']."' AND apply_from>='".$fdate."' AND apply_from<='".$ldate."'");

			$tot_dl_in_month = $this->Common_Model->db_query("SELECT SUM(no_of_days) as totaldlm FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE b.leave_type='DL' AND a.employee_id='".$employee[$i]['employee_id']."' AND a.session='".$session[0]['session_name']."' AND apply_from>='".$fdate."' AND apply_from<='".$ldate."'");

			$due_el = ($el[0]['leave_count'] - $tot_el[0]['totalel']);
			$due_cl = ($cl[0]['leave_count'] - $tot_cl[0]['totalcl']);
			$due_dl = ($dl[0]['leave_count'] - $tot_dl[0]['totaldl']);
			
			$blnce_el = $due_el - $tot_el_in_month[0]['totalelm'];
			$blnce_cl = $due_cl - $tot_cl_in_month[0]['totalclm'];
			$blnce_dl = $due_dl - $tot_dl_in_month[0]['totaldlm'];

			?>
			
				<tr>
					<td width="5%" class="text-center"><?=($i + 1);?></td>
					<td width="25%"><?=$employee[$i]['employee_name'];?></td>
					<td width="16%" class="text-center"><?=$employee[$i]['department_name'];?></td>
					<td width="6%" class="text-center"><?=($due_el>0?''.$due_el.'':'0');?></td>
					<td width="6%" class="text-center"><?=($due_cl>0?''.$due_cl.'':'0');?></td>
					<td width="6%" class="text-center"><?=($due_dl>0?''.$due_dl.'':'0');?></td>

					<td width="6%" class="text-center"><?=($tot_el_in_month[0]['totalelm']>0?''.$tot_el_in_month[0]['totalelm'].'':'0');?></td>
					<td width="6%" class="text-center"><?=($tot_cl_in_month[0]['totalclm']>0?''.$tot_cl_in_month[0]['totalclm'].'':'0');?></td>
					<td width="6%" class="text-center"><?=($tot_dl_in_month[0]['totaldlm']>0?''.$tot_dl_in_month[0]['totaldlm'].'':'0');?></td>

					<td width="6%" class="text-center"><?=($blnce_el>0?''.$blnce_el.'':'0');?></td>
					<td width="6%" class="text-center"><?=($blnce_cl>0?''.$blnce_cl.'':'0');?></td>
					<td width="6%" class="text-center"><?=($blnce_dl>0?''.$blnce_dl.'':'0');?></td>

				</tr>
			
		<?php }} ?>
		</table>

	