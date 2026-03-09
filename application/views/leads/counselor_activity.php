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
        <form class="breadcrumb float-right" style="padding:0;margin:0;">
          <li style="width:200px">
            <select name="Counselor" class="form-control">
              <option value="">All Counselor</option>
              <?php if ($Counselor) { 
              for ($i=0; $i < count($Counselor) ; $i++) { ?>
                <option value="<?=$Counselor[$i]['employee_id']?>" <?= $Counselor[$i]['employee_id']==$_REQUEST['Counselor'] ?'selected':''?>><?= $Counselor[$i]['employee_name']?></option>
              <?php } }?>
            </select>
          </li>
          <li><button type="submit" class="btn btn-primary btn-flat">Submit</button></li>
        </form>
      </section>

    <!-- Main content -->
    <div class="content">
      <div class="box">
        <div class="box-body"> 
          <div class="col-md-12">
            <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <i class="mdi mdi-close-circle font-32"></i><strong class="pr-1">Success !</strong> <?=$this->session->flashdata('success')?>
            </div>
            <?php }?>
            <?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <i class="mdi mdi-close-circle font-32"></i><strong class="pr-1">Error !</strong> <?=$this->session->flashdata('error')?>
            </div>
            <?php }?>
          </div>
          <div class="row">
            <div class="col-md-12" id="dataTablediv">
              <table class="table table-striped table-bordered">
              <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Lead Name</th>
                <th>Purpose</th>
                <th>Activity Type</th> 
                <th>Status</th>                 
                <th>Time</th>
              </tr>
              <?php if ($activities) { 
                for ($i=0; $i < count($activities) ; $i++) { ?>
                  <tr>
                    <td><?= $i+1 ?></td>
                    <td><?=$activities[$i]['EmpName'];?></td>
                    <td><?=$activities[$i]['LeadName'];?></td>
                    <td><?=$activities[$i]['course'];?></td>
                    <td><?=$activities[$i]['enquiry_remark'];?></td>
                    <td><?=$activities[$i]['enquiry_status'];?></td>
                    <td><?=date('d/m/Y h:i A', strtotime($activities[$i]['dateadded']));?></td> 
                  </tr>
               <?php } } else { ?>
                <tr>
                    <td colspan="7">No activities found.</td>
                </tr>
              <?php } ?>
            </table>
            </div>
          </div>
              
        </div>
        <!-- /.row -->
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