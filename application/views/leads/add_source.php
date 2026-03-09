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
          Source <small>Add Source</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Source</li>
        </ol>
      </section>

    <!-- Main content -->
    <div class="content">
        <div class="box" style="margin-top:10px;padding:10px;">
          <div class="box-body"> 
            <div class="row">
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
                <div class="col-lg-6">
                        <form method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                   
                                  </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="source">Source</label>
                                        <input type="text" class="form-control" id="source" name="source" required >
                                    </div>
                                    
                                    
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="refer_by">Referred By</label>
                                        <select class="form-control" id="refer_by" name="refer_by">
                                            <option value="" disabled selected>--Select--</option>
                                            <option value="Partner">Partner</option>
                                            <option value="Employee">Employee</option>
                                            <option value="Agent">Agent</option>
                                        </select>    
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <center>
                            <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
                            </center>
                        </div>
                        </form>
                    </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <table class="table table-bordered">
                            <thead>
                                <th>Sl No.</th>
                                <th>Source</th>
                                <th>Refered By</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            <?php if ($records) { for ($i = 0; $i < count($records); $i++) { ?>
                                <tr>
                                    <td><?=$i+1?></td>
                                    <td><?=$records[$i]['source'];?></td>
                                     <td><?=$records[$i]['refer_by'];?></td>
                                    <td><a class="btn btn-danger btn-sm" href="<?= site_url('lead/deletesource/').$records[$i]['id']?>">Delete</a></td>
                                </tr>
                            <?php } }else{echo '<tr><td colspan="3">No record Found</td></tr>'; } ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 </div>
  <!-- Main Footer -->
  <?php $this->load->view('common/footer');?>
</div>

<?php $this->load->view('common/script');?>
    
</body>
</html>