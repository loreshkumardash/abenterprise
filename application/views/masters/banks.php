<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Bank Master</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Banks</h3>
              <?php if(in_array('banksadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/add_bank");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a>
              <?php }?>
            </div>
            <div class="box-body">
              <form method="post" action="<?php echo site_url("masters/banks");?>" id="frmSaveSession">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>Bank Name</th>
                  <th>Account No</th>
                  <th>IFSC</th>
                  <th>Branch</th>
                  <th>Online</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['bank_id'];?></td>
                  <td><?php echo $records[$i]['bank_name'];?></td>
                  <td><?php echo $records[$i]['account_no'];?></td>
                  <td><?php echo $records[$i]['bank_ifsc'];?></td>
                  <td><?php echo $records[$i]['bank_address'];?></td>
                  <td><input type="radio" name="online_bank" value="<?php echo $records[$i]['bank_id'];?>" onchange="this.form.submit()" <?php echo $records[$i]['online'] == '1' ? 'checked="checked"' : '';?>></td>
                  <td><?php echo $records[$i]['status'] == '1' ? 'Active' : 'Inactive';?></td>
                  <td>
                    <?php if(in_array('banksedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/edit_bank/".$records[$i]['bank_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('banksdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/delete_bank/".$records[$i]['bank_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php }?>
                  </td>
                </tr>
                <?php }} ?>
              </table>
              </form>
            </div>
          </div>
        </div>
      </div>
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
</body>
</html>