<table id="" class="table table-bordered table-condensed table-striped">
  <tr>
    <th>ID</th>
    <th>Receipt No</th>
    <th>Date</th>
    <th>Amount</th>
    <th>&nbsp;</th>
  </tr>
  <?php if($records){ for($i=0;$i<count($records);$i++){?>
  <tr>
    <td><?php echo $records[$i]['receipt_id'];?></td>
    <td><a href="<?php echo site_url("payments/view_receipt/".$records[$i]['receipt_id']);?>" class="btn bg-maroon btn-flat margin btn-xs"><?php echo $records[$i]['receipt_id'];?></td>
    <td><?php echo date("d/m/Y g:i A", strtotime($records[$i]['created_on']));?></td>
    <td><?php echo $records[$i]['total_amount'];?></td>
    
    <td><a href="<?php echo site_url("payments/print_receipt/".$records[$i]['receipt_id']);?>" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a></td>
  </tr>
  <?php }} ?>
</table>