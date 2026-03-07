<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Branch Master</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Branch</h3>
              <?php if(in_array('branchadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/add_branch");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a>
              <?php }?>
            </div>
            <div class="box-body">
              <form method="post" action="<?php echo site_url("masters/branch");?>" id="frmSaveSession">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>Branch Name</th>
                  <th>Address</th>
                  <th>State</th>
                  <th>Manager</th>
                  <th>Mobile No</th> 
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['branch_id'];?></td>
                  <td><?php echo $records[$i]['branch_name'];?></td>
                  <td><?php echo $records[$i]['address'];?></td>
                  <td><?php echo $records[$i]['state_title'];?></td>
                  <td><?php echo $records[$i]['branch_manager'];?></td>
                  <td><?php echo $records[$i]['mobile_no'];?></td>
                  
                  <td>
                    <?php if(in_array('branchedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/edit_branch/".$records[$i]['branch_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('branchdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/delete_branch/".$records[$i]['branch_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php }?>
                  </td>
                </tr>
                <?php }} ?>
              </table>
              <?php if ($records) {
               echo $sPages;
              } ?>
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