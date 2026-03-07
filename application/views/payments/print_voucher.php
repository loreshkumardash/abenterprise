<div class="wrapper">
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <p style="margin:20px auto;">Amount : <b><?=$voucher[0]['amount'];?></b><br/>Paid to <b><u>
           
            
            <?php $emp = $voucher[0]['empnames'] == '' ? $voucher[0]['employee_name'].' ('.$voucher[0]['expense_name'].')' : $voucher[0]['empnames']; ?>
             <?php if($voucher[0]['unit_name']){echo $voucher[0]['unit_name'];}else{echo $emp;} ?>
            </u></b> the sum of Rupees (in words) <b><?php echo translateToWords($voucher[0]['amount']);?></b> by <b><?php echo $voucher[0]['payment_mode']?></b>. 
          <?=$voucher[0]['cheque_no'] != '' ? '<br/>Cheque No-'.$voucher[0]['cheque_no'] : '';?>
          <?=$voucher[0]['bank_name'] != '' ? '<br/>Bank Name-'.$voucher[0]['bank_name'] : '';?>
          <?=$voucher[0]['bank_branch'] != '' ? '<br/>Branch-'.$voucher[0]['bank_branch'] : '';?>
          <br/><?=$voucher[0]['mobile'] != '' && $voucher[0]['mobile'] != '0'? 'Mobile - '.$voucher[0]['mobile'] : '';?><br/>Remarks: <?php echo $voucher[0]['remarks'];?></p>
      </div>
      <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
      <table width="100%" border="0" style="margin-top:50px;">
        <tr>
          <td><b>Full Name and Address of the receiver</b><br/><br/>
        <div style="width:80%; border-bottom: 1px solid #000;"><?php if($voucher[0]['unit_name']){echo $voucher[0]['unit_name'];}else{echo $emp;} ?></div>
        <div style="width:80%; border-bottom: 1px solid #000;">&nbsp;</div>
        
    </td>
    <td valign="bottom" align="center">

        <br/><br/><br/><br/><br/>
        <b>Receiver's Signature</b>

      </td>
      <td valign="bottom" align="center">
        <br/><br/><br/><br/><br/>
        <b>Paying Officer</b>
    </td>
  </tr>
</table>
    </div>
  </section>
</div>