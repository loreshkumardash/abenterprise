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
          <li><a href="<?=site_url("emp_leads");?>" class="btn btn-primary btn-flat" style="color:#fff">List Leads</a></li>
        </ol>
      </section>

    <!-- Main content -->
    <section class="content">
      <div class="box" style="margin-top:10px;padding:10px;">
        <div class="box-body"> 
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


                <form method="post" action="<?php echo site_url('emp_leads/view_leads/'.$records[0]['enq_id']);?>">
                      <div class="row">
                        <div class="col-md-6" style="padding:0;">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="Name" style="margin-top:5px;">Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="name" class="form-control" value="<?=$records[0]['name'];?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="dob" style="margin-top:5px;">Date Of Birth</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="dob" class="form-control" value="<?=$records[0]['dob'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="mobile" style="margin-top:5px;">Mobile No</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="mobile" class="form-control" value="<?=$records[0]['mobile'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="state" style="margin-top:5px;">State</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="state" class="form-control" value="<?=$records[0]['state'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="city" style="margin-top:5px;">City</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="city" class="form-control" value="<?=$records[0]['city'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="followup" style="margin-top:5px;">Next Follow Up Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" name="followup_date" class="form-control" value="<?=$records[0]['followup_date'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="campus" style="margin-top:5px;"> Visit Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" name="campus_visit_dt" class="form-control" value="<?=$records[0]['campus_visit_dt'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 cancel_details" style="margin-top:1px;" >
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="cancel_reason" style="margin-top:5px;">Cancel Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" name="cancel_date" class="form-control" value="<?=$records[0]['cancel_date'];?>" >
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6" style="padding:0;">
                          <div class="form-group">
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="enqdate" style="margin-top:5px;">Enquiry Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="enquiry_date" class="form-control" value="<?=$records[0]['enquiry_date'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="email" style="margin-top:5px;">Email Id</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="email" class="form-control" value="<?=$records[0]['email'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="course" style="margin-top:5px;">Purpose</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="course" class="form-control" value="<?=$records[0]['course'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="gender" style="margin-top:5px;">Gender</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="gender" class="form-control" value="<?=$records[0]['gender'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="enqremark" style="margin-top:5px;">Enquiry Remark</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="enq_remark" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="enqstatus" style="margin-top:5px;">Enquiry Status</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select id="enq_status" name="enq_status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Not Started" <?=$records[0]['enquiry_status'] == "Not Started" ? "selected" : "" ?>>Not Started</option>
                                            <option value="In Progress" <?=$records[0]['enquiry_status'] == "In Progress" ? "selected" : "" ?>>In Progress</option>
                                            <option value="On Hold" <?=$records[0]['enquiry_status'] == "On Hold" ? "selected" : "" ?>>On Hold</option>
                                            <option value="Cancelled" <?=$records[0]['enquiry_status'] == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:1px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="adm_con" style="margin-top:5px;"> Confirm Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" name="adm_confirm_dt" class="form-control" value="<?=$records[0]['adm_confirm_dt'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 cancel_details" style="margin-top:1px;" >
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="cancel_reason" style="margin-top:5px;">Reason For Cancel</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text"  name="cancel_reason" class="form-control" value="<?=$records[0]['cancel_reason'];?>">
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>

                    <center style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary" name="update" value="update">Update</button>
                    </center>
                  </form>
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

<script type="text/javascript">
    $(document).ready(function() {
        // Check initial state on page load
        if ($('#enq_status').val() != 'Cancelled') {
            $('.cancel_details').hide();
        }

        // Show/hide the reason input box based on selection
        $('#enq_status').on('change', function() {
            if ($(this).val() === 'Cancelled') {
                $('.cancel_details').show();
            } else {
                $('.cancel_details').hide();
                $('.cancel_details').val(''); // Clear the input if hidden
            }
        });
    });

</script>

</body>
</html>