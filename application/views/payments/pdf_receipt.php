<table width="100%" style="font-size: 9px;" border="0" cellspacing="0" cellpadding="1">  <tr>    <td width="50%">      <img src="<?php echo base_url();?>assets/img/impronex.png" alt="Young Phoenix" width="60"><br><b>IMPRONEX SECURITY SERVICES</b>    </td>    <td width="10%"></td>    <td width="40%">Payment Receipt<hr/><b>Receipt # <?=$receipt[0]['receipt_id'];?></b><br><b>Receipt Date : </b> <?php echo date("d/m/Y g:i A", strtotime($receipt[0]['created_on']));?><br><b>Receipt By : </b><?=$usr[0]['firstname'].' '.$usr[0]['lastname'];?> </td>  </tr></table>
<table width="100%" style="font-size: 9px;" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td width="50%">
      <br/>
      PLOT NO-126/2899,LANE-1,KHANDAGIRI VIHAR BHUBANESWAR
<br/>
KHORDHA, ODISHA,751030 , Phone No - +91 9439072712,<br>Email - impronexlimited@gmail.com
    </td>
    <td width="10%"></td>
    <td width="40%">
      <?php if($employees){?>
      <address>
        <strong><?php echo $employees[0]['employee_name'];?></strong><br>
      </address>
      <?php }else{?>
      <address>
        <strong><?php echo $receipt[0]['cname'];?></strong><br>
        <?php echo $receipt[0]['cmobile'];?><br>
        <?php echo $receipt[0]['cdetails'];?>
      </address>
      <?php }?>
    </td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="3" cellspacing="0" style="font-size: 9px;">
  <thead>
  <tr>
    <th width="70%">Product</th>
    <th width="10%">Qty</th>
    <th width="20%">Total</th>
  </tr>
  </thead>
  <tbody>
  <?php if($items){ for($i=0;$i<count($items);$i++){?>
  <tr>
    <td width="70%"><?=$items[$i]['item_name'];?></td>
    <td width="10%"><?=$items[$i]['item_quantity'];?></td>
    <td align="right" width="20%"><?=$items[$i]['final_amount'];?></td>
  </tr>
  <?php }}?>
  </tbody>
  <tfoot>
    <tr>
      <td></td>
      <td align="right">Grand Total:</td>
      <td align="right"><?=$receipt[0]['total_amount'];?></td>
    </tr>
  </tfoot>
</table>
<p style="font-size: 11px;">Total Amount In Words : <b><?=translateToWords($receipt[0]['total_amount']);?></b> only

</p>
<!--<p style="font-size: 11px;">Payment Methods: <b><?=$receipt[0]['payment_mode'];?></b><?=$receipt[0]['cheque_no'] != '' ? ', Cheque No : <b>'.$receipt[0]['cheque_no'].'</b>' : '';?><?=$receipt[0]['bank_name'] != '' ? ', Bank Name : <b>'.$receipt[0]['bank_name'].'</b>' : '';?><?=$receipt[0]['bank_branch'] != '' ? ', Bank Branch : <b>'.$receipt[0]['bank_branch'].'</b>' : '';?><br/>
  
<?php if($bank){?>
<br/>Bank Name: <b><?=$bank[0]['bank_name'];?></b>
<?php }?>
</p>-->
<?php if($receipt[0]['payment_mode2'] != ''){ ?>
<p style="font-size: 11px;">Payment Methods 2: <b><?=$receipt[0]['payment_mode2'];?></b><?=$receipt[0]['cheque_no2'] != '' ? ', Cheque No : <b>'.$receipt[0]['cheque_no2'].'</b>' : '';?><?=$receipt[0]['bank_name2'] != '' ? ', Bank Name : <b>'.$receipt[0]['bank_name2'].'</b>' : '';?><?=$receipt[0]['bank_branch2'] != '' ? ', Bank Branch : <b>'.$receipt[0]['bank_branch2'].'</b>' : '';?><br/>
  Amount In Words : <b><?=translateToWords(floatval($receipt[0]['amount_paid2']));?></b> only
<?php if($bank){?>
<br/>Bank Name: <b><?=$bank2[0]['bank_name'];?></b>
<?php }?>
</p>
<?php }?>

<?php if($receipt[0]['payment_mode3'] != ''){ ?>
<p style="font-size: 11px;">Payment Methods 3: <b><?=$receipt[0]['payment_mode3'];?></b><?=$receipt[0]['cheque_no3'] != '' ? ', Cheque No : <b>'.$receipt[0]['cheque_no3'].'</b>' : '';?><?=$receipt[0]['bank_name3'] != '' ? ', Bank Name : <b>'.$receipt[0]['bank_name3'].'</b>' : '';?><?=$receipt[0]['bank_branch3'] != '' ? ', Bank Branch : <b>'.$receipt[0]['bank_branch3'].'</b>' : '';?><br/>
  Amount In Words : <b><?=translateToWords(floatval($receipt[0]['amount_paid3']));?></b> only
<?php if($bank){?>
<br/>Bank Name: <b><?=$bank3[0]['bank_name'];?></b>
<?php }?>
</p>
<?php }?>

<!--<p style="font-size: 11px;">Remarks: <b><?=$receipt[0]['remarks'];?></b></p>-->
<table width="100%" border="1" cellpadding="5" cellspacing="0" style="font-size: 10px;">
  <tr>
    <td width="70%">
<div class="col-xs-12" style="font-size: 8px;">
NB:
</div>
</td>
<td width="30%" valign="bottom"><br/>
  <br/>  <br/>
  <br/>
Account Seal with Signature
</td>
</tr>
</table>

<p></p>
<p></p>
<br>
<table style="border-top: 1px dashed #142145;height: 1px;"></table>
<p></p>
<br>

