<br><br><br>

<table width="100%" style="font-size: 13px;" border="0" cellspacing="0" cellpadding="2">

  <tr>    
    <td width="80%"><b>Ref: G10/BBSR/<?=date('Y');?>/<?=$appointment[0]['appointment_id'];?></b></td>
    <td width="20%"><b>Date:- <?php echo date('d-m-Y');?></b></td>   
    </tr>
    <br>
 <tr>    
    <td width="100%">TO</td>   
 </tr>
 <tr>    
    <td width="100%"><?=$appointment[0]['name'];?></td>    
 </tr>
 <tr>    
    <td width="100%">S/O-  <?=$appointment[0]['so_name'];?></td>    
 </tr>
 <tr>    
    <td width="100%">At-  <?=$appointment[0]['at'];?></td>    
 </tr>
 <tr>    
    <td width="100%">Po-  <?=$appointment[0]['post'];?></td>    
 </tr>
 <tr>    
    <td width="100%">Dist-  <?=$appointment[0]['dist'];?></td>     
 </tr>
 <tr>    
    <td width="100%">State-  <?=$appointment[0]['state'];?></td>     
 </tr>
 <tr>    
    <td width="100%">Pin-  <?=$appointment[0]['pincode'];?></td>    
 </tr><br><br><br>
 <tr>    
    <td width="100%" style="text-align: center;"><b><u>LETTER OF APPOINTMENT</u></b></td>     
 </tr>
 <tr>    
    <td width="100%">Dear <?php $name = $appointment[0]['name'];
                    $name_parts = explode(" ", $name);
                    $first_name = $name_parts[0]; echo $first_name; ?></td>     
 </tr>
 <br>
 <tr>    
    <td width="100%">This has reference to your application and the subsequent discussions you had with us on the following terms and conditions:</td>    
 </tr><br>
 <tr>    
    <td width="100%">1.   <b>Position:</b> You are being appointed as <b>“<?=$appointment[0]['position'];?>”.</b></td>    
 </tr><br>
 <tr>    
    <td width="100%">2.   You will initially be based at <b><?=$appointment[0]['based_at'];?>.</b></td>    
 </tr><br>
 <tr>    
    <td width="100%">3.   <b>Joining & Reporting:</b>  Your date of joining shall be <?=$appointment[0]['joining_date']?date('d-m-Y',strtotime($appointment[0]['joining_date'])):'';?> and you will be reporting to the <?=$appointment[0]['reporting_to'];?>.</td>    
 </tr><br>
 <tr>    
    <td width="100%">4.   <b>Compensation and Benefits:</b> You will receive compensation of                               per annum as outlined in the attached sheet. Income Tax or any other statutory deductions will be done at source. You will be eligible for leave and other such benefits in accordance with the Company’s rules and regulations. The perquisites applicable to your grade are subject to alteration and amendment, and you will be entitled to the same as per the rules of the company.</td>    
 </tr><br>
 <tr>    
    <td width="100%">5.   <b>Posting & Transfer:</b> Your place of work, in the first instant, is as indicated above. However, you can be transferred temporarily or permanently for duty anywhere in India, depending upon the needs of the organization. Your service may be transferred to any office of the Company or its associate organizations in India or abroad depending upon the exigencies of work.  You will be governed by the transfer rules prevailing in the company at any given point of time.</td>    
 </tr><br>
 <tr>    
    <td width="100%">6.   <b>Probation:</b> You will be on probation for a period of 6 months, from your date of joining, after which your performance will be appraised. You will be confirmed in your appointment in writing on successful completion of the said probationary period.</td>    
 </tr><br>
 <tr>    
    <td width="100%">7.   <b>Notice period:</b> After confirmation, either party, by stating their intention to do so, in writing may terminate this employment at any time, provided that at least 1 months’ notice or salary in lieu thereof is given. </td>    
 </tr><br>
 <tr>    
    <td width="100%">8.   However, in the event of your being guilty of misconduct or inattention or negligence in the discharge of your duties or in the conduct of the Company’s business, or such misdemeanor which is likely to affect, or affects the reputation of the Company’s working or of any breach of the terms and conditions herein, the Company reserves its right to terminate your services at any given point of time, with immediate effect, without any compensation or notice.</td>    
 </tr><br>
 <tr>    
    <td width="100%">9.   You will treat matters pertaining to the Company's business interests with utmost confidentiality and such confidentiality has to be maintained during your employment with the Company and thereafter. </td>    
 </tr><br>
 <tr>    
    <td width="100%">10.     During your services with the company, you will be governed by the rules and regulations in respect to conduct & discipline and other matters as may be framed by the company from time to time.</td>    
 </tr><br>
 <tr>    
    <td width="100%">11.     Amendments to the above terms and conditions, if any will be made in writing.</td>    
 </tr><br>
 <tr>    
    <td width="100%">12.   That, if you have deviates from any of the above mentioned clauses, your services shall be terminated at any time without showing any reason thereof & legal action will be taken by the management of Glosent.</td>    
 </tr><br>
 <tr>    
    <td width="100%">You are welcome to our Impronex Security Services family and we wish all the best and good wishes.</td>    
 </tr><br>
 <tr>    
    <td width="100%">Please sign and return the duplicate copy of this letter of appointment (initialing each page) as a token of your having accepted the above terms and conditions.</td>    
 </tr><br>
 <tr>    
    <td width="100%">Wish you all the very best in your new assignment. </td>    
 </tr><br>
 <tr>    
    <td width="100%">Thanking You.</td>    
 </tr><br>
<tr>    
    <td width="100%">Yours faithfully</td>    
 </tr>
 <tr>    
    <td width="100%">For <b>GLOSENT</b></td>    
 </tr><br><br>
<tr>    
    <td width="50%"><b>(Dy. General Manager)</b></td>
     <td width="50%">sign:_______________<br>Name:<b><?=$appointment[0]['name'];?></b></td>    
 </tr>
 <br><br><br>
<tr>    
    <td width="100%"><b><u>Annexure “A”</u></b></td>    
 </tr><br>
 <tr>    
    <td width="100%"><b><u>Emoluments:</u></b></td>    
 </tr><br><br>
 <tr>    
    <td width="100%">Your monthly gross remuneration shall be regulated as follows & additional expenses will be reimbursed as per company rules and regulations:-</td>    
 </tr>
</table>
<br><br><br><br><br><br>
<table width="100%" style="font-size: 13px;" border="1" cellspacing="0" cellpadding="5">
<tr style="text-align: center;">
   <td width="15%"><b>Sl. No.</b></td>
   <td width="50%"><b>Particulars</b></td>
   <td width="20%"><b>Amount</b></td>
</tr>
<tbody>
   <?php if ($salary) { for ($i=0; $i < count($salary); $i++) {  ?>
<tr>
   <td width="15%" style="text-align: center;"><?=$i+1;?></td>
   <td width="50%" > <?=$salary[$i]['perticular']; ?></td>
   <td width="20%" style="text-align:right;"> Rs. <?=number_format($salary[$i]['amount'],2) ?></td>
</tr>
 <?php }} ?>  
</tbody>
<tr>
   <td width="15%"></td>
   <td width="50%"><b> Total Amount (Per Month)</b></td>
   <td width="20%" style="text-align:right;"><b> Rs. <?=number_format($appointment[0]['total_amount'],2); ?></b></td>
</tr> 
</table>



