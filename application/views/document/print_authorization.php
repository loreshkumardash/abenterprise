



<br><br><br>

<table width="100%" style="font-size: 13px;" border="0" cellspacing="0" cellpadding="2">

  <tr>    
    <td width="80%"><b>REF: G10/BBSR/<?=date('Y');?>/<?=$authorization[0]['authorization_id'];?></b></td>
    <td width="20%"><b>DATE: <?=$authorization[0]['date']?date('d-m-Y',strtotime($authorization[0]['date'])):'';?></b></td>   
    </tr>
    <br><br><br> <tr>    
    <td width="100%"><b>To</b></td>   
 </tr>
 <tr>    
    <td width="100%"><b><?=$authorization[0]['authorization_to'];?>,</b></td>    
 </tr>
 <tr>    
    <td width="100%"><b>RBG Head (<?=$authorization[0]['address'];?>),</b></td>    
 </tr>
 <tr>    
    <td width="100%"><b><?=$authorization[0]['sitename'];?>.</b></td>     
 </tr><br>
 <tr>    
    <td width="100%"><b>Sub: <?=$authorization[0]['sub'];?>. </b></td>    
 </tr>
 <br>
 <tr>    
    <td width="100%">Dear Sir,</td>     
 </tr>
 <br>
 <tr>    
    <td width="100%">Dear Sir,
<?=$authorization[0]['description'];?>.  
</td>    
 </tr><br>
 <tr>    
    <td width="100%">Thank you for your kind cooperation.  </td>    
 </tr><br>
 <tr>    
    <td width="100%"><b>Thanks & Regards</b></td>    
 </tr>
 <br><br><br><br>
 <tr>    
    <td width="100%"></td>    
 </tr>
 <br>
 <tr>        
    <td width="100%"><b><?=$authorization[0]['regards'] ?>
</b></td>    
 </tr>  
 <tr>    
    <td width="100%"><b>Manager (HR)</b></td>    
 </tr>
 <tr>    
    <td width="100%"><b>For GLOSENT</b></td>    
 </tr>
 
 
</table>

