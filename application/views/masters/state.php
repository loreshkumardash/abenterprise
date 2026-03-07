<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>State Master</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List State</h3>
              
            </div>
            <div class="box-body">
              <form method="post" action="<?php echo site_url("masters/state");?>" id="frmSaveSession">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>State Name</th>
                  <th>LWF Percent</th>
                  <th>LWF Emp. Share</th>
                  <th>LWF Empr. Share</th>
                  <th>LWF Deduction Period</th> 
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['state_id'];?></td>
                  <td><?php echo $records[$i]['state_title'];?></td>
                  <td><?php echo $records[$i]['lwf_percent'];?></td>
                  <td><?php echo $records[$i]['lwfemp_share'];?></td>
                  <td><?php echo $records[$i]['lwfempr_share'];?></td>
                  <td><?php echo $records[$i]['lwfdeduction_period'];?></td>
                  
                  <td>
                    <?php if(in_array('statesedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/edit_state/".$records[$i]['state_id']);?>" class="btn btn-xs btn-warning">Edit</a>
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