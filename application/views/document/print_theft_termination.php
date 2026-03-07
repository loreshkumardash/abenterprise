



<br><br><br>

<table width="100%" style="font-size: 13px;" border="0" cellspacing="0" cellpadding="2">
  
  <tr>    
    <td width="80%"><b>Ref: G10/BBSR/<?=date('Y');?>/<?=$termination[0]['termination_id'];?> </b></td>
    <td width="20%"><b>Date:- <?=$termination[0]['theft_date']?date('d-m-Y',strtotime($termination[0]['theft_date'])):'';?></b></td>   
   </tr>
    <br>
 <tr>    
    <td width="100%"><b>To</b></td>   
 </tr>
 <tr>    
    <td width="100%"><b>Mr. <?=$termination[0]['theftemp_name']; ?>,</b></td>    
 </tr>
 <tr>    
    <td width="100%"><b><?=$employee[0]['designation_name'];?>,</b></td>    
 </tr>
 <br>
 <tr>    
    <td width="100%"><b>Sub: Termination Letter.</b></td>    
 </tr>
 <br>
 <tr>    
    <td width="100%">Dear <?php $name = $termination[0]['theftemp_name'];
                    $name_parts = explode(" ", $name);
                    $first_name = $name_parts[0]; echo $first_name; ?>,</td>     
 </tr>
 <br>
 <tr>    
    <td width="100%"><?=$termination[0]['reason_of_ter']; ?></td>    
 </tr><br>
 <tr>    
    <td width="100%">We would like you to leave your job. Your salary is hereby withheld towards theft recovery </td>    
 </tr><br>
 <tr>    
    <td width="100%"><b>Thanks & Regards</b></td>    
 </tr>
 <br>
 <tr>    
    <td width="100%"></td>    
 </tr>
 <br><br><br><br>
 <tr>        
    <td width="100%"><b>HR Manager</b></td>    
 </tr>  
 <tr>    
    <td width="100%"><b>For GLOSENT</b></td>    
 </tr>
 
</table>

