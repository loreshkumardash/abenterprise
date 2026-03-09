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
          Leads <small>Add Leads</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Leads</li>
        </ol>
      </section>


    <!-- Main content -->
    <section class="content">
            <div class="row">
              <div class="col-md-12">
                                        <?php if ($this->session->flashdata('success')) { ?>
                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                                            </div>
                                        <?php } if ($this->session->flashdata('error')) { ?>
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                <div class="col-lg-8">
                    <div class="box" style="padding:10px;">
                      
                        <div class="box-body"> 
                            <form method="post" class="form-horizontal" enctype="multipart/form-data">

                              <div class="form-group">
                                <label for="name">Name <span style="color:red;">*</span></label>
                                <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control admname">
                              </div>

                              <div class="form-group">
                                <label for="customer_code">Customer Code</label>
                                <input type="text" id="customer_code" name="customer_code" placeholder="Enter Unique Code" class="form-control admname">
                              </div>

                              

                              <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control admemail">
                              </div>

                              <div class="form-group">
                                <label for="mobile">Mobile <span style="color:red;">*</span></label>
                                <input type="number" id="mobile" name="mobile" placeholder="Mobile Number" class="form-control admmobile" required>
                              </div>

                              <div class="form-group">
                                <label for="amobile">Alternate Mobile </label>
                                <input type="number" id="amobile" name="amobile" placeholder="Alternate Mobile Number" class="form-control admmobile">
                              </div>

                               <div class="form-group">
                                <label for="wp_no">Whatsapp No: </label>
                                <input type="number" id="wp_no" name="wp_no" placeholder="Whatsapp no." class="form-control admmobile">
                              </div>

                              <div class="form-group">
                                <label>Gender</label><br>
                                <label class="radio-inline">
                                  <input type="radio" id="male" name="gender" value="Male"> Male
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" id="female" name="gender" value="Female"> Female
                                </label>
                              </div>

                              <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" id="state" name="state" placeholder="Enter State" class="form-control">
                              </div>

                              <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" placeholder="Enter City" class="form-control">
                              </div>

                              <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" id="location" name="location" placeholder="Enter Location" class="form-control">
                              </div>

                              <div class="form-group">
                                <label for="specification">Specification</label>
                                <select id="specification" name="specification" class="form-control">
                                  <option value="">--Select Property Type--</option>
                                  <option value="Plot">Plot</option>
                                  <option value="Flat">Flat</option>
                                  <option value="Villa">Villa</option>
                                </select>
                              </div>
                              
                              <div class="form-group">
                                <label for="budget">Budget</label>
                                <input type="text" id="budget" name="budget" placeholder="Enter Budget" class="form-control">
                              </div>
                             <div class="form-group">
                                <label for="remark">Lead Remark</label>
                                <input type="text" id="remark" name="remark" placeholder="Enter lead remark" class="form-control">
                              </div>
                              
                              <div class="form-group">
                                <label for="source">Lead Source</label>
                                <select class="form-control" name="source" id="source">
                                            <option value="">--Select Source--</option>
                                            <?php if (!empty($source)) {
                                                foreach ($source as $src) { ?>
                                                    <option value="<?= $src['id']; ?>" <?= ($this->input->get('source') == $src['id']) ? 'selected' : ''; ?>>
                                                        <?= $src['source']; ?>
                                                    </option>
                                            <?php } } ?>
                                        </select>
                              </div>
                              

                              <div class="form-group text-center">
                                <button type="submit" value="submitBtn" name="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
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