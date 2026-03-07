<table id="" class="table table-bordered table-condensed table-striped">
  <tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Mobile</th>
    <th>Username</th>
    <th>User Type</th>
    <th>Action</th>
  </tr>
  <?php if($records){ for($i=0;$i<count($records);$i++){?>
  <tr>
    <td><?php echo $records[$i]['user_id'];?></td>
    <td><?php echo $records[$i]['firstname'];?></td>
    <td><?php echo $records[$i]['lastname'];?></td>
    <td><?php echo $records[$i]['useremail'];?></td>
    <td><?php echo $records[$i]['userphone'];?></td>
    <td><?php echo $records[$i]['username'];?></td>
    <td><?php echo $records[$i]['usertype'];?></td>
    <td>
      <?php if(in_array('usersedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
      <a href="<?php echo site_url("users/edituser/".$records[$i]['user_id']);?>" class="btn btn-xs btn-warning">Edit</a>
      <?php }?>
      <?php if(in_array('usersdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
      <a href="<?php echo site_url("users/deleteuser/".$records[$i]['user_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
      <?php }?>
    </td>
  </tr>
  <?php }}else{ ?>
  <tr><td colspan="8">No Records Found</td></tr>
  <?php } ?>
</table>
<?php echo $this->ajax_pagination->create_links(); ?>