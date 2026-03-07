<table id="" class="table table-bordered table-condensed table-striped">
  <tr>
    <th>Item Name</th>
    <!--<th>Price</th>-->
    <th>Quantity</th>
    <th>Details</th>
    <th>Action</th>
  </tr>
  <?php if($records){ for($i=0;$i<count($records);$i++){?>
  <tr>
    <td><?php echo $records[$i]['item_name'];?></td>
    <td><?php echo $records[$i]['item_price'];?></td>
    <td><?php echo $records[$i]['item_quantity'];?></td>
    <td><?php echo $records[$i]['item_description'];?></td>
    <td>
      <?php if(in_array('accessoriesedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
      <a href="<?php echo site_url("masters/edit_accessories/".$records[$i]['item_id']);?>" class="btn btn-xs btn-info">Edit</a>
      <?php }if(in_array('accessoriesdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
      <a href="<?php echo site_url("masters/delete_accessories/".$records[$i]['item_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
    <?php }?>
    </td>
  </tr>
  <?php }} ?>
</table>
<?php echo $this->ajax_pagination->create_links(); ?>