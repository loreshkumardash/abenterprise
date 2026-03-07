<table id="" class="table table-condensed table-small-font table-bordered table-striped"  cellpadding="2" style="font-family:serif;font-size:15px;">
	<thead>
		<tr>
	      <th width="100%" colspan="9"><b>Scanner Attendance of Dt:- <?=date('d-m-Y',strtotime($log_date));?></b></th>
	      
	    </tr>
	</thead>
</table>
<table id="" class="table table-condensed table-small-font table-bordered table-striped" border="1" cellpadding="2" style="font-family:serif;font-size:13px;">
	<thead>
		
	    <tr>
	      <th>Sl#</th>
	      <th>Unit Code</th>
	      <th>Employee Code</th>
	      <th>Employee Name</th>
	      <th>Log Date</th>
	      <th>Check in Time</th>
	      <th>Check Out Time</th>
	      <th>Hours</th>
	      <th>Status</th>
	    </tr>
	</thead>
	<tbody id="attendancedata">
		<?php $html='';
		if (!empty($unit_id)) {
				$rec1 = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id","a.*,b.employee_name,b.techno_emp_id","log_date='".$log_date."' AND unit_id=".$unit_id." AND status='1'");
				if ($rec1) { for ($i=0; $i <count($rec1) ; $i++) { 
					
				

					$rec2 = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id","a.*,b.employee_name,b.techno_emp_id","log_date='".$log_date."' AND unit_id=".$unit_id." AND user_id=".$rec1[$i]['user_id']." AND status='2'");
				
				
				
				if ($rec1[$i]['log_datetime']) {
					$checkin = date('d-m-Y H:i:s',strtotime($rec1[0]['log_datetime']));
				}else{
					$checkin = '';
				}

				if ($rec2[0]['log_datetime']) {
					$checkout = date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime']));
				}else{
					$checkout = '';
				}

				if (!empty($rec1[$i]['log_datetime']) && !empty($rec2[0]['log_datetime'])) {
					$datetime1 = new DateTime($rec1[$i]['log_datetime']);
					$datetime2 = new DateTime($rec2[0]['log_datetime']);
					$interval = $datetime1->diff($datetime2);
					$workinghour = $interval->format('%h').".".$interval->format('%i')."";
					
					$status = 'Present';
				}else{
					$status = 'Absent';
					$workinghour = '';
				}
				$html.='<tr><td>'.($i+1).'</td><td>'.$unit_id.'</td><td>'.$rec1[$i]['techno_emp_id'].'</td><td>'.$rec1[$i]['employee_name'].'</td><td>'.$log_date.'</td><td>'.$checkin.'</td><td>'.$checkout.'</td><td>'.$workinghour.'</td><td>'.$status.'</td></tr>';
				}
			}else{
				$html .='No records found !!';
			}
		}else{
			$html .='';
			
		} echo $html; ?>
	</tbody>

</table>