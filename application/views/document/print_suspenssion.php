



<br><br><br>

<table width="100%" style="font-size: 13px;" border="0" cellspacing="0" cellpadding="2">  
  <tr>    
    <td width="80%"><b>Ref: G10/BBSR/<?=date('Y');?>/<?=$suspension[0]['suspension_id'];?></b></td>
    <td width="20%"><b>Date:- <?php echo date('d-m-Y');?></b></td>   
    </tr>
    <br>
 <tr>    
    <td width="100%"><b>To</b></td>   
 </tr>
 <tr>    
    <td width="100%"><b> <?=$suspension[0]['susemp_name']; ?></b></td>    
 </tr>
 <tr>    
    <td width="100%"><b>M/s Impronex Security Services</b></td>    
 </tr>
 <br>
 <tr>    
    <td width="100%"><b>Sub: Suspension letter.</b></td>     
 </tr>
 <br>
 <tr>    
    <td width="100%">Dear <?php $name = $suspension[0]['susemp_name'];
                    $name_parts = explode(" ", $name);
                    $first_name = $name_parts[0]; echo $first_name; ?>,</td>     
 </tr>
 <br>
 <tr>    
    <td width="100%">This is a notice by the Company that effective from <b><?=$suspension[0]['suspension_date']?date('d-m-Y',strtotime($suspension[0]['suspension_date'])):''; ?></b>, you are being placed on suspension from your position of employment till further order. <?=$suspension[0]['suspension_reason']; ?>.  No employer is expected to suffer the employment of an individual whose behaviour is such that it prevents a harmonious working atmosphere.</td>    
 </tr><br>
 <tr>    
    <td width="100%">During the period of suspension, you are restricted from all areas of the Office. </td>    
 </tr><br>
 <tr>    
    <td width="100%"><b>Thanks & Regards</b></td>    
 </tr>
 <br><br>
 <tr>        
    <td width="100%"><b>HR Manager</b></td>    
 </tr>  
 <tr>    
    <td width="100%"><b>For GLOSENT</b></td>    
 </tr>
 
</table>

