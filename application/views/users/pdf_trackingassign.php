<table id="" class="table table-condensed table-small-font table-bordered table-striped"  cellpadding="2" style="font-family:serif;font-size:15px;">
	<thead>
		<tr>
	      <th width="100%" style="text-align: center;"><b><?=$user[0]['firstname'].' '.$user[0]['lastname'];?></b></th>
	      
	    </tr>
		<tr>
	      <th width="100%"><b>Employee Assign Report</b></th>
	      
	    </tr>
	</thead>
</table>
<table id="" class="table table-condensed table-small-font table-bordered table-striped" border="1" cellpadding="2" style="font-family:serif;font-size:13px;">
	<thead>
		
	    <tr>
	      <th width="5%"><b>Sl#</b></th>
	      <th width="15%"><b>Employee Code</b></th>
	      <th width="50%"><b>Employee Name</b></th>
	      <th width="15%"><b>Mobile</b></th>
	      <th width="15%"><b>Joining Date</b></th>
	    </tr>
	</thead>
	<tbody id="attendancedata">
		<?php if ($records) { $cnt =0;
			$accessar = json_decode($records[0]['tracking_access']);

			foreach ($accessar as $key => $value) {
					 $employee = $this->Common_Model->FetchData("employees", "*", "user_id=".$value."");
					 if ($employee) {
					 	$cnt +=1;
			 ?>
			 <tr>
		      <td width="5%"><?=$cnt;?></td>
		      <td width="15%"><?=$employee[0]['techno_emp_id'];?></td>
		      <td width="50%"><?=$employee[0]['employee_name'];?></td>
		      <td width="15%"><?=$employee[0]['emp_mobile'];?></td>
		      <td width="15%"><?=$employee[0]['emp_doj'];?></td>
		    </tr>
				
		<?php }}} ?>
	</tbody>

</table>
