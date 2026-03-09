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
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="box" style="padding:10px;">
              <div class="box-body"> 
                    <table class="table">
                        <tr>
                            <th>Sl No.</th>
                            <th>Counselor</th>
                            <th>Lead Name</th>
                            <th>Course</th>
                            <th>Reason</th>
                        </tr>
                        <?php if($records){
                            for ($i=0; $i < count($records) ; $i++) { ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td><?=$records[$i]['CounselorName']?></td>
                                <td><?=$records[$i]['name']?></td>
                                <td><?=$records[$i]['course']?></td>
                                <td><?=$records[$i]['cancel_reason']?></td>
                            <tr>
                        <?php }} ?> 
                    </table>

            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <!-- Main Footer -->
  <?php $this->load->view('common/footer');?>
</div>

<?php $this->load->view('common/script');?>


    
</body>
</html>

