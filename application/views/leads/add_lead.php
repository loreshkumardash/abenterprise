<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <?php $this->load->view('common/meta'); ?>

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
          <li class="active">Add Leads</li>
        </ol>
      </section>

      <!-- Main content -->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <?php if ($this->session->flashdata('success')) { ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
              </div>
            <?php }
            if ($this->session->flashdata('error')) { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php } ?>
          </div>
          <div class="col-lg-6">
            <div class="box" style="padding:10px;">
              <div class="box-body">

                <form method="post" action="<?php echo site_url("lead/add_lead"); ?>" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="text-right">
                      <a class="btn btn-success btn-sm" href="<?= site_url("uploads/item/portfolio_demo.Xlsx") ?>"
                        download>Sample of Excel File</a>
                    </div>
                    <div class="row">

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="source">Portfolio</label>
                          <select class="form-control" id="source" name="source">
                            <option value="">--Select--</option>
                            <?php if ($records) {
                              for ($i = 0; $i < count($records); $i++) { ?>
                                <option value="<?= $records[$i]['id']; ?>"><?= $records[$i]['name']; ?></option>
                            <?php }
                            } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="file">Upload File</label>
                          <input type="file" class="form-control" id="upload_file" name="upload_file">
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
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->
    <?php $this->load->view('common/footer'); ?>
  </div>

  <?php $this->load->view('common/script'); ?>

</body>

</html>