


<br><br><br>
<table width="100%" style="font-size: 12px;" border="0" cellspacing="0" cellpadding="2">  
  
 <tr>    
    <td width="100%" style="text-align: center; font-size: 16px;"><b><u>TERMINATION LETETR</u></b></td>   
 </tr><br><br>
 <tr>    
    <td width="80%"></td>
    <td width="20%"><b>DATE: <?=$termination[0]['ter_date']?date('d-m-Y',strtotime($termination[0]['ter_date'])):''; ?></b></td>  
   </tr><br>
   <tr>    
    <td width="30%"><b>NAME OF THE CANDIDATE :</b></td>
    <td width="70%"><b><?=$termination[0]['ter_emp_name']; ?></b></td>  
</tr><br>
<tr>    
    <td width="30%"><b>ADDRESS :</b></td>
    <td width="70%"><b><?=$employee[0]['emp_curraddress'];?>
</b></td>
 </tr><br>
 <tr>    
    <td width="30%"><b>RANK :</b></td>
    <td width="70%"><b></b></td>
 </tr><br>
 <tr>    
    <td width="30%"><b>EMPLOYEE ID :</b></td>
    <td width="70%"><b><?=$employee[0]['techno_emp_id'];?></b></td>
 </tr><br>
 <tr>    
    <td width="30%"><b>REASON OF TERMINATION :</b></td>
    <td width="70%"><b><?=$termination[0]['ter_reason']; ?></b></td>
 </tr><br><br><br><br><br><br><br>
 <br><br>


 <tr>    
    <td width="60%"><b>ASST. FACILITY MANAGER</b></td>
    <td width="40%"><b>HR MANAGER </b></td>
 </tr> <br>
 <tr>    
    <td width="100%"><b>REMARKS IF ANY</b></td>
 </tr>
 <br><br>
 
</table>

