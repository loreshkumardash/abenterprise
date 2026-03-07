<div class="table-responsive mb-0" data-pattern="priority-columns">
<table id="" class="table table-condensed table-small-font table-bordered table-striped">
  <tr>
    <th>ID</th>
    <th>Mode</th>
    <th>Date</th>
    <th>Amount</th>
    <th>From</th>
    <th>Remarks</th>
    <th>Balance</th>
  </tr>
  <?php if($records){ for($i=0;$i<count($records);$i++){?>
  <tr>
    <td><?php echo $records[$i]['id'];?></td>
    <td><?php echo $records[$i]['mode'];?></td>
    <td><?php echo date("d/m/Y g:i A", strtotime($records[$i]['created_on']));?></td>
    <td><?php echo $records[$i]['amount'];?></td>
    <td><?php echo $records[$i]['voucher_no'] == '' ? 'Receipt No: '.$records[$i]['receipt_no'] : 'Voucher No: '.$records[$i]['voucher_no'];?></td>
    <td><?php echo $records[$i]['remarks'];?></td>
    <th><?php echo $records[$i]['cash_balance'];?></th>
  </tr>
  <?php }} ?>
</table>
</div>
<?php echo $this->ajax_pagination->create_links(); ?>