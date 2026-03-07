<table id="" class="table table-condensed table-small-font table-bordered table-striped"  cellpadding="2" style="font-family:serif;font-size:15px;">
	<thead>
		<tr>
	      <th width="100%"><b>User Attendance of Dt:- <?=date('d-m-Y',strtotime($log_date));?></b></th>
	      
	    </tr>
	</thead>
</table>
<table id="" class="table table-condensed table-small-font table-bordered table-striped" border="1" cellpadding="2" style="font-family:serif;font-size:13px;">
	<thead>
		
	    <tr>
	      <th width="5%"><b>Sl#</b></th>
	      <th width="5%"><b>User Id</b></th>
	      <th width="40%"><b>User Name</b></th>
	      <th width="10%"><b>Log Date</b></th>
	      <th width="15%"><b>Check in Time</b></th>
	      <th width="15%"><b>Check Out Time</b></th>
	      <th width="10%"><b>Status</b></th>
	    </tr>
	</thead>
	<tbody id="attendancedata">
		<?php if (!empty($user_id)) {
				$rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$user_id." AND status='1'");
				$rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$user_id." AND status='2'");
				$user = $this->Common_Model->FetchData("users", "*", "user_id=".$user_id."");
				if ($rec1) {
					$checkin = date('d-m-Y H:i:s',strtotime($rec1[0]['log_datetime']));
				}else{
					$checkin = '';
				}

				if ($rec2) {
					$checkout = date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime']));
				}else{
					$checkout = '';
				}

				if (!empty($rec1) && !empty($rec2)) {
					$status = 'Present';
				}else{
					$status = 'Absent';
				} ?>
				<tr><td width="5%">1</td><td width="5%"><?=$user[0]['user_id'];?></td><td width="40%"><?=$user[0]['firstname'];?> <?=$user[0]['lastname'];?></td><td width="10%"><?=date('d-m-Y',strtotime($log_date));?></td><td width="15%"><?=$checkin;?></td><td width="15%"><?=$checkout;?></td><td width="10%"><?=$status;?></td></tr>
		<?php }else{
			$users = $this->Common_Model->FetchData("users", "*", "usertype!='Others' AND usercategory='1'");
			if ($users) { for ($i=0; $i <count($users) ; $i++) { 
				$rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$users[$i]['user_id']." AND status='1'");
				$rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$users[$i]['user_id']." AND status='2'");

				if ($rec1) {
					$checkin = date('d-m-Y H:i:s',strtotime($rec1[0]['log_datetime']));
				}else{
					$checkin = '';
				}

				if ($rec2) {
					$checkout = date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime']));
				}else{
					$checkout = '';
				}

				if (!empty($rec1) && !empty($rec2)) {
					$status = 'Present';
				}else{
					$status = 'Absent';
				} ?>
				<tr><td width="5%"><?=$i+1;?></td><td width="5%"><?=$users[$i]['user_id'];?></td><td width="40%"><?=$users[$i]['firstname'];?> <?=$users[$i]['lastname'];?></td><td width="10%"><?=date('d-m-Y',strtotime($log_date));?></td><td width="15%"><?=$checkin;?></td><td width="15%"><?=$checkout;?></td><td width="10%"><?=$status;?></td></tr>
		<?php	}}
			
		} ?>
	</tbody>

</table>
