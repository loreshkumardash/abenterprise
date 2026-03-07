<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Subjects</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Subjects</h3>
            </div>
            <div class="box-body">
              <?php
                  if($this->session->flashdata('success')){
                  ?>
                  <div class="alert alert-dismissable alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
                  </div>
                  <?php
                  }                    
                  
                  if($this->session->flashdata('error')){
                  ?>
                  <div class="alert alert-dismissable alert-danger">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                  </div>
                  <?php
                  }
                  ?>
              <table class="table table-striped">
                  <tr>
                    <th>Sl No</th>
                    <th>Route Name</th>
                    <th>Status</th>
                    <th>Route Regd. Date</th>
                    <th>Action</th>
                  </tr>
                  <?php if($records){
                    $cnt = 0;
                     for($i=0;$i<count($records);$i++){ 
                      $cnt++;
                  ?>
                      <tr>
                        <td><?=$cnt;?></td>
                        <td><?=$records[$i]['route_name'];?></td>
                        <td><?=($records[$i]['status'] == 1)?'Active':'In-Active';?></td>
                        <td><?=date('d M Y',strtotime($records[$i]['entry_date']));?></td>
                        <td>
                          <a href="<?=site_url('masters/add_edit_transport/'.$records[$i]['trans_id']);?>" class="btn btn-warning btn-xs">Edit</a>
                          <a href="<?=site_url('masters/delete_transport/'.$records[$i]['trans_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                          <a title="Download Report" href="<?=site_url('masters/download_route_data/'.$records[$i]['trans_id']);?>" class="btn btn-success btn-xs">Download Report</a>
                          <a title="Download Report" href="<?=site_url('masters/bulkassigntransport/'.$records[$i]['trans_id']);?>" class="btn btn-default btn-xs">Assign Students</a>
                        </td>
                      </tr>
                  <?php } } ?>
                </table>
            </div>
            <div class="card-footer">
              <?php if($records){echo $sPages; }?>
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