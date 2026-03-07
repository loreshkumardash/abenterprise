<div style="border:1px solid #000; width:100%; float: left;">
<table width="100%" style="font-size: 11px;" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td width="50%">
      <img src="<?=base_url()?>assets/img/phoenixnew.png" alt="O.P Jindal" width="100">
      <h3>Statement of Fees</h3>
      <?=$date_from != '' ? 'Date From - '.$date_from : ''; ?><br/><?=$date_to != '' ? 'Date To - '.$date_to : '';?>
    </td>
    <td width="10%"></td>
    <td width="40%">
      <h1 style="color:#800000;">O.P.JINDAL SCHOOL</h1>
      Affiliated to CBSE, Affiliation No.-1530161
      Jindal Nagar, Nisha, Angul-759111, Odisha
      Tel: 06761-264181, E-mail : opjs@angul.jspl.com, Website: http://www.opjsangul.com/<br>
      </td>
  </tr>
</table>
<br/>
<div class="row">
<div class="col-xs-12 table-responsive">
  <table width="99%" cellpadding="5" cellspacing="0" style="font-size: 11px; margin-top: -10px;" border="1">
    <thead>
      <tr>
      <td colspan="3">
        <address>
          <strong>Student Information</strong><br>
          <?php echo $student[0]['student_first_name'].' '.$student[0]['student_last_name'];?><br>
          <?php echo $student[0]['session_name'];?><br>
          <?php echo $student[0]['class_name'];?><br>
        </address>
      </td>
      <td colspan="2">
        <address>
      <strong>Parent Information</strong><br>
      <?php echo $student[0]['father_name'];?><br>
      Mobile: <?php echo $student[0]['father_contact_no'];?><br>
      <?php echo $student[0]['mother_name'];?><br>
      Mobile: <?php echo $student[0]['mother_contact_no'];?><br>
      Email: <?php echo $student[0]['student_email'];?>
      </address>
      </td>
    </tr>
    <tr>
      <th><b>Sl No</b></th>
      <th><b>Date</b></th>
      <th><b>Receipt No</b></th>
      <th><b>Description</b></th>
      <th><b>Amount</b></th>
    </tr>
    </thead>
    <tbody>
      <?php
      $sl = 1;
      $total = 0;
      for($i=0;$i<count($receipts);$i++){
      $items = db_query("SELECT GROUP_CONCAT(DISTINCT item_type) AS items FROM receipts_items WHERE receipt_id = ".$receipts[$i]['receipt_id']);
      $total = $total + $receipts[$i]['total_amount'];
      ?>
      <tr>
        <td><?=$sl++;?></td>
        <td><?=date("d/m/Y", strtotime($receipts[$i]['receipt_date']));?></td>
        <td><?=$receipts[$i]['receipt_no'];?></td>
        <td><?=$items[0]['items'];?></td>
        <td align="right"><?=$receipts[$i]['total_amount'];?></td>
      </tr>
      <?php 
      }
      ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="4" align="right">Grand Total</th>
        <td align="right"><b><?=number_format($total,  2, '.', '');?></b></td>
      </tr>
      <tr>
      	<td colspan="5">Amount In Words : <b><?=strtoupper(translateToWords($total));?></b> only</td>
      </tr>
    </tfoot>
  </table>
  
</div>
<!-- /.col -->
</div>
<br/>
<table width="100%" cellpadding="5" cellspacing="0" style="font-size: 12px; margin-top: 30px;">
	<tr>
		<!--<td width="25%" style="font-weight: bold; text-align: center;"><br/><br/><br/><hr/>Signature of Authority</td>-->
		<td width="25%" style="font-weight: bold; text-align: center;"></td>
		<td width="25%" style="font-weight: bold; text-align: center;"></td>
		<td width="20%" style="font-weight: bold; text-align: center;"></td>
		<td width="25%" style="font-weight: bold; text-align: center;"><br/><br/><br/><hr/>Signature of Accounts</td>
	</tr>
</table>
</div>