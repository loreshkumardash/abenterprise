<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <?php $this->load->view('common/meta');?>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Leads <small>Lead List</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Leads</li>
        </ol>
      </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-body"> 
          <div class="card">
            
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
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
                </div>
                </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <?php if($records){?>
                  <table class="table table-striped table-bordered">
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    
                    <th>Number</th>                   
                    <th>Email</th>
                    <th>State</th>
                    <th>City</th>
                    <!-- <th>Purpose</th> -->
                    <th>Gender</th>
                    <th>Action</th>
                  </tr>
                  <?php if($records){
                    $cnt = 0;
                     for($i=0;$i<count($records);$i++){ 
                      $cnt++;
                  ?>
                      <tr>
                        <td><?=$cnt;?></td>
                        <td><?=$records[$i]['name'];?></td>
                        
                        <td><?=$records[$i]['mobile'];?></td>
                        <td><?=$records[$i]['email'];?></td>
                        <td><?=$records[$i]['state'];?></td>
                        <td><?=$records[$i]['city'];?></td>
                        <!-- <td><?=$records[$i]['course'];?></td> -->
                        <td><?=$records[$i]['gender'];?></td>
                        
                        <td>
                          <a href="<?=site_url('emp_leads/view_leads/'.$records[$i]['enq_id']);?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                      </tr>
                  <?php } } ?>
                </table>
                  <?php echo $sPages; }else{echo 'No records found';}?>
                </div>
              </div>
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